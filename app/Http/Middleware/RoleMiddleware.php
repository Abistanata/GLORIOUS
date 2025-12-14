<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RoleMiddleware
{
    /**
     * Handle an incoming request.
     */
    public function handle(Request $request, Closure $next, ...$roles)
    {
        if (!Auth::check()) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Unauthenticated',
                    'error' => 'UNAUTHENTICATED'
                ], 401);
            }
            return redirect('/');
        }

        $user = Auth::user();
        $userRole = strtolower(trim($user->role));

        // ✅ NORMALISASI ROLE UNTUK PERBANDINGAN
        $normalizedRoles = array_map(function($role) {
            return strtolower(trim($role));
        }, $roles);

        // Cek jika user memiliki salah satu role yang diizinkan
        foreach ($normalizedRoles as $allowedRole) {
            if (str_contains($userRole, $allowedRole) || str_contains($allowedRole, $userRole)) {
                return $next($request);
            }
        }

        // Role tidak sesuai
        if ($request->expectsJson()) {
            return response()->json([
                'success' => false,
                'message' => 'Akses ditolak. Anda tidak memiliki permission untuk mengakses halaman ini.',
                'user_role' => $user->role,
                'required_roles' => $roles
            ], 403);
        }

        // Redirect berdasarkan role user
        $redirectUrl = match(true) {
            str_contains($userRole, 'admin') => '/admin/dashboard',
            str_contains($userRole, 'manajer') => '/manajergudang/dashboard',
            str_contains($userRole, 'staff') => '/staff/dashboard',
            default => '/',
        };

        return redirect($redirectUrl)->with('error', 'Akses ditolak. Anda tidak memiliki permission untuk mengakses halaman tersebut.');
    }
}