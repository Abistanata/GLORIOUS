<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;
use App\Models\Cart;
use App\Models\Wishlist;

class ViewServiceProvider extends ServiceProvider
{
    public function boot()
    {
        View::composer('*', function ($view) {
            $view->with('categories', Category::all());
        });

        View::composer(['layouts.theme', 'components.navbar'], function ($view) {
            $view->with('categories', Category::all());
        });

        // Cart & Wishlist count: hanya untuk auth + role Customer (satu guard web)
        View::composer(['layouts.theme'], function ($view) {
            $cartCount = 0;
            $wishlistCount = 0;
            if (Auth::check() && Auth::user()->role === 'Customer') {
                $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');
                $wishlistCount = Wishlist::where('user_id', Auth::id())->whereHas('product')->count();
            }
            $view->with('cartCount', $cartCount)->with('wishlistCount', $wishlistCount);
        });
    }
}
