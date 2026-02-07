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
            $cartCount = 0;
            $wishlistCount = 0;
            if (Auth::check() && (Auth::user()->role ?? '') === 'Customer') {
                $cartCount = (int) Cart::where('user_id', Auth::id())->sum('qty');
                $wishlistCount = (int) Wishlist::where('user_id', Auth::id())->whereHas('product')->count();
            }
            $view->with('cartCount', $cartCount)->with('wishlistCount', $wishlistCount);
        });
    }
}
