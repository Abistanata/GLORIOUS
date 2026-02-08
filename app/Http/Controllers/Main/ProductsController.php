<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    /**
     * Display a listing of products with filters and search
     */
    public function index(Request $request)
    {
        $productsQuery = Product::with(['category', 'supplier']);

        // Hitung stok saat ini menggunakan subquery - sama dengan AdminDashboardController
        $productsQuery->addSelect([
            'current_stock' => StockTransaction::selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0)')
                ->whereColumn('product_id', 'products.id')
        ]);

        // Filter by category
        if ($request->has('category_id') && $request->category_id) {
            $productsQuery->where('category_id', $request->category_id);
        }

        // Search functionality
        if ($request->has('search') && $request->search) {
            $search = $request->search;
            $productsQuery->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('specification', 'like', "%{$search}%");
            });
        }

        // Filter hanya produk dengan stok > 0
        if ($request->has('in_stock') && $request->in_stock) {
            $productsQuery->having('current_stock', '>', 0);
        }

        // Filter produk diskon
        if ($request->has('on_sale') && $request->on_sale) {
            $productsQuery->where('is_on_sale', true)
                         ->where('discount_price', '>', 0)
                         ->whereColumn('discount_price', '<', 'original_price');
        }

        // Sorting
        $sort = $request->sort ?? 'name_asc';
        switch ($sort) {
            case 'name_desc': 
                $productsQuery->orderBy('name', 'desc'); 
                break;
            case 'price_asc': 
                $productsQuery->orderBy('selling_price', 'asc'); 
                break;
            case 'price_desc': 
                $productsQuery->orderBy('selling_price', 'desc'); 
                break;
            case 'stock_asc': 
                $productsQuery->orderBy('current_stock', 'asc'); 
                break;
            case 'stock_desc': 
                $productsQuery->orderBy('current_stock', 'desc'); 
                break;
            case 'latest': 
                $productsQuery->orderBy('created_at', 'desc'); 
                break;
            case 'oldest': 
                $productsQuery->orderBy('created_at', 'asc'); 
                break;
            default: 
                $productsQuery->orderBy('name', 'asc'); 
                break;
        }

        $products = $productsQuery->paginate(12);
        
        // Generate WhatsApp message untuk setiap produk
        $products->getCollection()->transform(function ($product) {
            $finalPrice = $product->final_price ?? $product->selling_price ?? 0;
            $currentStock = $product->current_stock ?? 0;
            $condition = $product->getConditionLabel();
            $warranty = $product->getWarrantyLabel();
            $product->whatsapp_message = $this->getWhatsAppMessage(
                $product,
                $finalPrice,
                $currentStock,
                $condition,
                $warranty
            );
            return $product;
        });
        
        $categories = Category::all();
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        // Hitung total stok yang tersedia menggunakan subquery yang sama
        $availableStock = StockTransaction::selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as total_stock')
            ->value('total_stock') ?? 0;

        return view('main.products.index', compact(
            'products',
            'categories',
            'totalProducts',
            'totalCategories',
            'availableStock'
        ));
    }

    /**
     * Display the specified product
     */
    public function show($id)
    {
        $product = Product::with(['category', 'supplier'])
            ->findOrFail($id);

        // Hitung stok saat ini dari StockTransaction - cara yang sama dengan index
        $currentStock = StockTransaction::where('product_id', $product->id)
            ->selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
            ->value('stock') ?? 0;

        // Update current_stock attribute
        $product->current_stock = $currentStock;

        // Get related products menggunakan raw query
        $relatedProductIds = DB::table('products')
            ->select('products.id')
            ->where('products.category_id', $product->category_id)
            ->where('products.id', '!=', $product->id)
            ->whereIn('products.id', function($query) {
                $query->select('product_id')
                      ->from('stock_transactions')
                      ->groupBy('product_id')
                      ->havingRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) > 0');
            })
            ->limit(4)
            ->pluck('id');

        $relatedProducts = Product::with(['category'])
            ->whereIn('id', $relatedProductIds)
            ->get();

        // Hitung stok untuk setiap related product
        foreach ($relatedProducts as $relatedProduct) {
            $relatedProduct->current_stock = $this->calculateProductStock($relatedProduct->id);
        }

        $isInCart = false;
        $isInWishlist = false;
        if (Auth::check() && Auth::user()->role === 'Customer') {
            $isInCart = Cart::where('user_id', Auth::id())->where('product_id', $product->id)->exists();
            $isInWishlist = Wishlist::where('user_id', Auth::id())->where('product_id', $product->id)->exists();
        }

        return view('main.products.show', compact('product', 'relatedProducts', 'isInCart', 'isInWishlist'));
    }

    /**
     * Display dashboard with latest and sale products
     */
    public function dashboard()
    {
        // Query untuk produk terbaru dengan stok > 0 - FIXED QUERY
        $latestProducts = Product::with(['category'])
            ->whereHas('stockTransactions', function($query) {
                $query->selectRaw('product_id, COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
                      ->groupBy('product_id')
                      ->havingRaw('stock > 0');
            })
            ->latest()
            ->take(6)
            ->get();

        // Hitung stok untuk setiap produk
        foreach ($latestProducts as $product) {
            $product->current_stock = StockTransaction::where('product_id', $product->id)
                ->selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
                ->value('stock') ?? 0;
        }

        // Query untuk produk diskon - FIXED QUERY
        $saleProducts = Product::with(['category'])
            ->where('is_on_sale', true)
            ->where('discount_price', '>', 0)
            ->whereColumn('discount_price', '<', 'original_price')
            ->whereHas('stockTransactions', function($query) {
                $query->selectRaw('product_id, COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
                      ->groupBy('product_id')
                      ->havingRaw('stock > 0');
            })
            ->latest()
            ->take(6)
            ->get();

        // Hitung stok untuk setiap produk diskon
        foreach ($saleProducts as $product) {
            $product->current_stock = StockTransaction::where('product_id', $product->id)
                ->selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
                ->value('stock') ?? 0;
        }

        $totalProducts = Product::count();
        $totalCategories = Category::count();
        
        // Hitung total stok yang tersedia
        $availableStock = StockTransaction::selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as total_stock')
            ->value('total_stock') ?? 0;

        return view('main.dashboard.index', compact(
            'latestProducts', 
            'saleProducts',
            'totalProducts', 
            'totalCategories', 
            'availableStock'
        ));
    }

    /**
     * Search products
     */
    public function search(Request $request)
    {
        $search = $request->get('q');
        
        $products = Product::with(['category'])
            ->where(function($query) use ($search) {
                $query->where('name', 'like', "%{$search}%")
                      ->orWhere('sku', 'like', "%{$search}%")
                      ->orWhere('description', 'like', "%{$search}%")
                      ->orWhere('specification', 'like', "%{$search}%");
            })
            ->whereHas('stockTransactions', function($query) {
                $query->selectRaw('product_id, COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
                      ->groupBy('product_id')
                      ->havingRaw('stock > 0');
            })
            ->paginate(12);

        // Hitung stok untuk setiap produk
        foreach ($products as $product) {
            $product->current_stock = StockTransaction::where('product_id', $product->id)
                ->selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
                ->value('stock') ?? 0;
        }

        return view('main.products.search', compact('products', 'search'));
    }

    /**
     * Display products by category
     */
    public function byCategory(Category $category)
    {
        $products = Product::with(['category'])
            ->where('category_id', $category->id)
            ->whereHas('stockTransactions', function($query) {
                $query->selectRaw('product_id, COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
                      ->groupBy('product_id')
                      ->havingRaw('stock > 0');
            })
            ->paginate(12);

        // Hitung stok untuk setiap produk
        foreach ($products as $product) {
            $product->current_stock = StockTransaction::where('product_id', $product->id)
                ->selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
                ->value('stock') ?? 0;
        }

        return view('main.products.category', compact('products', 'category'));
    }

    /**
     * Display products on sale
     */
    public function onSale()
    {
        $products = Product::with(['category'])
            ->where('is_on_sale', true)
            ->where('discount_price', '>', 0)
            ->whereColumn('discount_price', '<', 'original_price')
            ->whereHas('stockTransactions', function($query) {
                $query->selectRaw('product_id, COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
                      ->groupBy('product_id')
                      ->havingRaw('stock > 0');
            })
            ->paginate(12);

        // Hitung stok untuk setiap produk
        foreach ($products as $product) {
            $product->current_stock = StockTransaction::where('product_id', $product->id)
                ->selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
                ->value('stock') ?? 0;
        }

        return view('main.products.sale', compact('products'));
    }

    /**
     * Display out of stock products
     */
    public function outOfStock()
    {
        $products = Product::with(['category'])
            ->whereHas('stockTransactions', function($query) {
                $query->selectRaw('product_id, COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
                      ->groupBy('product_id')
                      ->havingRaw('stock <= 0');
            })
            ->paginate(12);

        // Hitung stok untuk setiap produk
        foreach ($products as $product) {
            $product->current_stock = StockTransaction::where('product_id', $product->id)
                ->selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
                ->value('stock') ?? 0;
        }

        return view('main.products.out-of-stock', compact('products'));
    }

    /**
     * Display products with stock using JOIN
     */
    public function withStock()
    {
        $products = Product::with(['category'])
            ->select('products.*')
            ->addSelect(DB::raw('COALESCE(SUM(CASE WHEN stock_transactions.type = "Masuk" THEN stock_transactions.quantity ELSE -stock_transactions.quantity END), 0) as current_stock'))
            ->leftJoin('stock_transactions', 'products.id', '=', 'stock_transactions.product_id')
            ->groupBy('products.id')
            ->having('current_stock', '>', 0)
            ->paginate(12);

        return view('main.products.with-stock', compact('products'));
    }

    /**
     * Calculate product stock from transactions
     *
     * @param int $productId
     * @return int
     */
    private function calculateProductStock($productId)
    {
        return StockTransaction::where('product_id', $productId)
            ->selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
            ->value('stock') ?? 0;
    }

    /**
     * Generate WhatsApp message for product inquiry
     *
     * @param Product $product
     * @param float $finalPrice
     * @param int $currentStock
     * @param string $condition
     * @param string $warranty
     * @return string
     */
    private function getWhatsAppMessage($product, $finalPrice, $currentStock, $condition, $warranty)
    {
        $message = "Halo, saya tertarik dengan produk berikut:\n\n";
        $message .= "📦 *Produk:* {$product->name}\n";
        $message .= "🏷️ *SKU:* " . ($product->sku ?? '-') . "\n";
        $message .= "💰 *Harga:* Rp " . number_format($finalPrice, 0, ',', '.') . "\n";
        
        if ($product->has_discount && $product->selling_price > 0) {
            $message .= "🔥 *Diskon:* " . round($product->discount_percentage ?? 0) . "% (Hemat Rp " . number_format($product->getDiscountAmount(), 0, ',', '.') . ")\n";
            $message .= "~~Rp " . number_format($product->selling_price, 0, ',', '.') . "~~\n";
        }
        
        $message .= "📊 *Stok:* " . ($currentStock > 0 ? $currentStock . " unit tersedia" : "Habis") . "\n";
        if (!empty($condition)) $message .= "🔧 *Kondisi:* {$condition}\n";
        if (!empty($warranty)) $message .= "✅ *Garansi:* {$warranty}\n";
        if ($product->category) $message .= "📂 *Kategori:* {$product->category->name}\n";
        $message .= "\nApakah produk ini masih tersedia? Saya ingin order.";
        return $message;
    }
}