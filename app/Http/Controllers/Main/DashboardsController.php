<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use App\Models\StockTransaction;
use Illuminate\Http\Request;

class DashboardsController extends Controller
{
    public function index()
    {
        // Ambil 6 produk terbaru untuk dashboard - hitung stok dari StockTransaction
        $productsQuery = Product::with(['category', 'supplier'])
            ->addSelect([
                'current_stock' => StockTransaction::selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0)')
                    ->whereColumn('product_id', 'products.id')
            ])
            ->having('current_stock', '>', 0) // Hanya produk dengan stok > 0
            ->latest()
            ->take(6);

        $products = $productsQuery->get();

        // Untuk statistik (opsional)
        $totalProducts = Product::count();
        $totalCategories = Category::count();

        // Hitung total stok yang tersedia menggunakan subquery yang sama
        $availableStock = StockTransaction::selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as total_stock')
            ->value('total_stock') ?? 0;

        return view('main.dashboard.index', compact(
            'products',
            'totalProducts',
            'totalCategories',
            'availableStock'
        ));
    }
}
