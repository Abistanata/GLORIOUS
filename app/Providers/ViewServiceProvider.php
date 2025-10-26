<?php

namespace App\Providers;

use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider;
use App\Models\Category;

class ViewServiceProvider extends ServiceProvider
{
    
    public function boot()
    {
        // Share categories to all views
        View::composer('*', function ($view) {
            $view->with('categories', Category::all());
        });

        // Or only to specific views (more efficient)
        View::composer(['layouts.theme', 'components.navbar'], function ($view) {
            $view->with('categories', Category::all());
            
        });
        
    }
}
