<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class ProductsController extends Controller
{
    // Method index yang sudah ada
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

    // Method show yang diperbaiki
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

        return view('main.products.show', compact('product', 'relatedProducts'));
    }

    // Method untuk dashboard yang diperbaiki
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

    // Method baru untuk mencari produk - FIXED QUERY
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

    // Method untuk produk berdasarkan kategori - FIXED QUERY
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

    // Method untuk produk diskon - FIXED QUERY
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

    // Method untuk produk dengan stok habis - FIXED QUERY
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

    // Method alternatif untuk menghitung stok dengan cara yang lebih aman
    private function calculateProductStock($productId)
    {
        return StockTransaction::where('product_id', $productId)
            ->selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
            ->value('stock') ?? 0;
    }

    // Method untuk mendapatkan produk dengan stok menggunakan JOIN (Alternatif)
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
}