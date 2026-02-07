<?php

namespace App\Http\Controllers\Customer;

use App\Http\Controllers\Controller;
use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AuthController extends Controller
{
    /**
     * Login customer dengan username/password
     */
    public function login(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'username' => 'required|string',
            'password' => 'required|string',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Username dan password wajib diisi'
            ], 422);
        }

        // Coba login dengan username
        $credentials = [
            'username' => $request->username,
            'password' => $request->password
        ];
        
        $remember = $request->boolean('remember', false);

        if (Auth::guard('customer')->attempt($credentials, $remember)) {
            $customer = Auth::guard('customer')->user();

            // Check if customer is active
            if (!$customer->isActive()) {
                Auth::guard('customer')->logout();
                return response()->json([
                    'success' => false,
                    'message' => 'Akun Anda dinonaktifkan. Silakan hubungi admin.'
                ], 403);
            }

            return response()->json([
                'success' => true,
                'message' => 'Login berhasil',
                'user' => [
                    'id' => $customer->id,
                    'username' => $customer->username,
                    'name' => $customer->name,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'whatsapp' => $customer->whatsapp,
                    'status' => $customer->status,
                ]
            ]);
        }

        return response()->json([
            'success' => false,
            'message' => 'Username atau password salah'
        ], 401);
    }

    /**
     * Register customer baru
     */
    public function register(Request $request)
    {
        // Validasi input
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'username' => 'required|string|unique:customers|min:3|max:20',
            'phone' => 'required|string|max:20',
            'whatsapp' => 'nullable|string|max:20',
            'password' => 'required|string|min:8|confirmed',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $validator->errors()
            ], 422);
        }

        // Create customer
        $customer = Customer::create([
            'username' => $request->username,
            'name' => $request->name,
            'email' => $request->email, // opsional
            'phone' => $request->phone,
            'whatsapp' => $request->whatsapp ?? $request->phone,
            'password' => Hash::make($request->password),
            'status' => 'active',
        ]);

        // Auto login setelah registrasi
        Auth::guard('customer')->login($customer);

        return response()->json([
            'success' => true,
            'message' => 'Registrasi berhasil',
            'user' => [
                'id' => $customer->id,
                'username' => $customer->username,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'whatsapp' => $customer->whatsapp,
                'status' => $customer->status,
            ]
        ], 201);
    }

    /**
     * Logout customer
     */
    public function logout(Request $request)
    {
        Auth::guard('customer')->logout();
        
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return response()->json([
            'success' => true,
            'message' => 'Logout berhasil'
        ]);
    }

    /**
     * Get authenticated customer
     */
    public function me(Request $request)
    {
        $customer = Auth::guard('customer')->user();
        
        if (!$customer) {
            return response()->json([
                'success' => false,
                'message' => 'Tidak terautentikasi'
            ], 401);
        }

        return response()->json([
            'success' => true,
            'user' => [
                'id' => $customer->id,
                'username' => $customer->username,
                'name' => $customer->name,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'whatsapp' => $customer->whatsapp,
                'status' => $customer->status,
            ]
        ]);
    }
}