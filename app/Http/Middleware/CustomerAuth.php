<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerAuth
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next)
    {
        if (!Auth::guard('customer')->check()) {
            return response()->json([
                'success' => false,
                'message' => 'Unauthorized. Please login as customer.'
            ], 401);
        }

        return $next($request);
    }
}