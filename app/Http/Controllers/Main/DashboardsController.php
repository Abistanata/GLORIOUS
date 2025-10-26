<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class DashboardsController extends Controller
{
    public function index()
    {
        // Ambil 6 produk terbaru untuk dashboard
        $products = Product::with(['category', 'supplier'])
            ->where('current_stock', '>', 0) // Hanya produk dengan stok > 0
            ->latest()
            ->take(6)
            ->get();

        // Untuk statistik (opsional)
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $availableStock = Product::sum('current_stock');

        return view('main.dashboard.index', compact(
            'products', 
            'totalProducts', 
            'totalCategories', 
            'availableStock'
        ));
    }
}