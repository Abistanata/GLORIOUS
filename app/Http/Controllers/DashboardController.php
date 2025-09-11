<?php

namespace App\Http\Controllers;
use App\Models\Category;



use Illuminate\Http\Request;

class DashboardController extends Controller
{
    public function index()
{
    $categories = Category::all(['id', 'name']);
    return view('main.dashboard.index', compact('categories'));
}
}
