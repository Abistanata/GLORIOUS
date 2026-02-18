<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\StockTransaction;
use App\Models\Wishlist;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class DashboardsController extends Controller
{
    public function index()
    {
        // Ambil 6 produk terbaru untuk dashboard - hitung stok dari StockTransaction
        $productsQuery = Product::with(['category', 'supplier', 'reviews'])
            ->addSelect([
                'current_stock' => StockTransaction::selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0)')
                    ->whereColumn('product_id', 'products.id')
            ])
            ->having('current_stock', '>', 0) // Hanya produk dengan stok > 0
            ->latest()
            ->take(6);

        $products = $productsQuery->get();

        // Untuk Customer: tandai produk yang ada di wishlist (selaras dengan navbar & product card)
        $wishlistProductIds = collect();
        if (Auth::check() && Auth::user()->role === 'Customer') {
            $wishlistProductIds = Wishlist::where('user_id', Auth::id())
                ->whereIn('product_id', $products->pluck('id'))
                ->pluck('product_id');
        }
        $products->each(function ($product) use ($wishlistProductIds) {
            $product->is_in_wishlist = $wishlistProductIds->contains($product->id);
        });

        // Untuk statistik (opsional)
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        // Hitung total stok yang tersedia menggunakan subquery yang sama
        $availableStock = StockTransaction::selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as total_stock')
            ->value('total_stock') ?? 0;

        // Ambil reviews terbaru untuk ditampilkan di dashboard
        $reviews = Review::with(['user:id,name,profile_photo_path', 'product:id,name'])
            ->whereHas('product') // Hanya review yang produknya masih ada
            ->latest()
            ->take(6)
            ->get();

        return view('main.dashboard.index', compact(
            'products',
            'totalProducts',
            'totalCategories',
            'availableStock',
            'reviews'
        ));
    }
}
