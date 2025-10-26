<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Product;
use App\Models\Category;
use Illuminate\Http\Request;

class ProductsController extends Controller
{
    // Method index yang sudah ada
    public function index(Request $request)
    {
        $productsQuery = Product::with(['category', 'supplier']);

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
                      ->orWhere('description', 'like', "%{$search}%");
            });
        }

        // Sorting
        $sort = $request->sort ?? 'name_asc';
        switch ($sort) {
            case 'name_desc': $productsQuery->orderBy('name', 'desc'); break;
            case 'price_asc': $productsQuery->orderBy('selling_price', 'asc'); break;
            case 'price_desc': $productsQuery->orderBy('selling_price', 'desc'); break;
            case 'stock_asc': $productsQuery->orderBy('current_stock', 'asc'); break;
            case 'stock_desc': $productsQuery->orderBy('current_stock', 'desc'); break;
            default: $productsQuery->orderBy('name', 'asc'); break;
        }

        $products = $productsQuery->paginate(12);
        $categories = Category::all();
        $totalProducts = Product::count();
        $totalCategories = Category::count();
        $availableStock = Product::sum('current_stock');

        return view('main.products.index', compact(
            'products',
            'categories',
            'totalProducts',
            'totalCategories',
            'availableStock'
        ));
    }

    // TAMBAHKAN METHOD SHOW INI
    public function show($id)
    {
        $product = Product::with(['category', 'supplier'])->findOrFail($id);
        
        return view('main.products.show', compact('product'));
    }

    // Optional: Method untuk dashboard
    public function dashboard()
    {
        $products = Product::with(['category', 'supplier'])
            ->where('current_stock', '>', 0)
            ->latest()
            ->take(6)
            ->get();

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