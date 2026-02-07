<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;

class AuthController extends Controller
{
    protected $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    // ======================== LOGIN METHOD ========================

    /**
     * Handle user login - SATU LOGIN UNTUK SEMUA (Customer & Admin/Staff)
     * Setelah login: Customer → tetap di halaman, Admin/Staff → redirect dashboard
     */
    public function login(Request $request)
    {
        try {
            $validated = $request->validate([
                'login' => 'required|string',
                'password' => 'required|string',
                'remember' => 'boolean',
            ]);

            $login = trim($validated['login']);
            $password = $validated['password'];
            $remember = $validated['remember'] ?? false;

            Log::info('Login attempt', ['login' => $login, 'ip' => $request->ip()]);

            $user = User::where('email', $login)
                ->orWhere('username', $login)
                ->orWhere('phone', $login)
                ->first();

            if (!$user) {
                Log::warning('User not found', ['login' => $login]);
                return $this->loginFailedResponse($request);
            }

            if (!Hash::check($password, $user->password)) {
                Log::warning('Password mismatch', ['user_id' => $user->id]);
                return $this->loginFailedResponse($request);
            }

            // SATU GUARD: Auth::login (web)
            Auth::login($user, $remember);
            $request->session()->regenerate();
            if (\Schema::hasColumn('users', 'last_login_at')) {
                $user->update(['last_login_at' => now()]);
            }

            $role = $user->role ?? 'Customer';

            Log::info('Login successful', ['user_id' => $user->id, 'name' => $user->name, 'role' => $role]);

            // Customer → tetap di halaman (back/intended). Admin/Staff → redirect dashboard
            $redirectUrl = ($role === 'Customer') ? (url()->previous() ?: '/') : $this->getRedirectUrlByRole($role);

            $response = [
                'success' => true,
                'message' => 'Login berhasil! Selamat datang, ' . $user->name,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email ?? null,
                    'username' => $user->username ?? null,
                    'phone' => $user->phone ?? null,
                    'role' => $role,
                    'last_login' => now()->format('Y-m-d H:i:s'),
                ],
                'redirect' => $redirectUrl,
            ];

            if ($request->expectsJson()) {
                return response()->json($response);
            }

            return redirect($redirectUrl);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $errorMessage = 'Validasi gagal: ' . implode(', ', array_map(function ($fieldErrors) {
                return implode(', ', $fieldErrors);
            }, array_values($errors)));

            Log::warning('Admin/Staff login validation failed', [
                'errors' => $errors,
                'request' => $request->all()
            ]);

            $errorResponse = [
                'success' => false,
                'message' => $errorMessage,
                'errors' => $errors
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 422);
            }

            return back()->withErrors($errors)->withInput();

        } catch (\Exception $e) {
            Log::error('Admin/Staff login process failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString(),
                'request' => $request->all()
            ]);

            $errorResponse = [
                'success' => false,
                'message' => 'Terjadi kesalahan server. Silakan coba lagi nanti.',
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 500);
            }

            return back()
                ->withErrors(['error' => 'Terjadi kesalahan sistem.'])
                ->with('error', 'Login gagal. Silakan coba lagi nanti.');
        }
    }

    // ======================== REGISTER METHOD ========================

    /**
     * Handle user registration - khusus untuk CUSTOMER
     * Setelah register, auto login ke guard customer
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'username' => 'required|string|unique:users,username|min:3|max:50|regex:/^[a-zA-Z0-9_]+$/',
                'phone' => 'required|string|unique:users,phone|min:10|max:15',
                'password' => 'required|string|min:6|confirmed',
                'email' => 'nullable|email|unique:users,email',
                'terms' => 'accepted',
            ], [
                'username.regex' => 'Username hanya boleh mengandung huruf, angka, dan underscore',
                'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
                'phone.min' => 'Nomor telepon minimal 10 digit',
                'phone.max' => 'Nomor telepon maksimal 15 digit',
            ]);

            // Format nomor telepon
            $phone = $validated['phone'];
            if (Str::startsWith($phone, '+62')) {
                $phone = Str::replaceFirst('+62', '', $phone);
            } elseif (Str::startsWith($phone, '62')) {
                $phone = Str::replaceFirst('62', '', $phone);
            }
            
            if (!Str::startsWith($phone, '0')) {
                $phone = '0' . $phone;
            }

            // Buat user dengan role Customer
            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'phone' => $phone,
                'whatsapp' => $phone,
                'email' => $validated['email'] ?? null,
                'password' => Hash::make($validated['password']),
                'role' => 'Customer', // Default role adalah Customer
                'status' => 'active',
            ]);

            // SATU GUARD: Auth::login (web) - customer tetap di website yang sama
            Auth::login($user, $request->has('remember'));
            $request->session()->regenerate();
            if (\Schema::hasColumn('users', 'last_login_at')) {
                $user->update(['last_login_at' => now()]);
            }

            $response = [
                'success' => true,
                'message' => 'Registrasi berhasil! Selamat bergabung dengan Glorious Computer.',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                ],
                'redirect' => '/', // Redirect ke home, BUKAN customer/dashboard
            ];

            Log::info('Customer registered and logged in', [
                'user_id' => $user->id,
                'username' => $user->username
            ]);

            if ($request->expectsJson()) {
                return response()->json($response);
            }

            // Redirect ke home page, bukan dashboard khusus
            return redirect('/')
                ->with('success', 'Registrasi berhasil! Selamat bergabung.');

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $errorMessage = 'Validasi gagal: ' . implode(', ', array_map(function ($fieldErrors) {
                return implode(', ', $fieldErrors);
            }, array_values($errors)));

            $errorResponse = [
                'success' => false,
                'message' => $errorMessage,
                'errors' => $errors
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 422);
            }

            return back()->withErrors($errors)->withInput();

        } catch (\Exception $e) {
            Log::error('Registration failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorResponse = [
                'success' => false,
                'message' => 'Terjadi kesalahan server. Silakan coba lagi nanti.',
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 500);
            }

            return back()->withErrors(['error' => 'Registrasi gagal. Silakan coba lagi.'])->withInput();
        }
    }

    // ======================== LOGOUT METHOD ========================

    /**
     * Logout - SATU LOGOUT UNTUK SEMUA (auth web)
     */
    public function logout(Request $request)
    {
        try {
            $userName = 'Unknown';
            if (Auth::check()) {
                $user = Auth::user();
                $userName = $user->name;
                Log::info('Logout', ['user_id' => $user->id, 'name' => $user->name, 'role' => $user->role ?? 'unknown']);
            }

            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Log::info('Admin/Staff session invalidated');

            $response = [
                'success' => true,
                'message' => 'Logout berhasil. Sampai jumpa lagi, ' . $userName,
            ];

            if ($request->expectsJson()) {
                return response()->json($response);
            }

            return redirect('/')
                ->with('success', 'Logout berhasil. Sampai jumpa lagi!');

        } catch (\Exception $e) {
            Log::error('Admin/Staff logout failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorResponse = [
                'success' => false,
                'message' => 'Terjadi kesalahan saat logout.'
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 500);
            }

            return redirect('/')
                ->with('error', 'Terjadi kesalahan saat logout.');
        }
    }

    // ======================== SESSION & AUTH CHECK ========================

    /**
     * Get current authenticated user info (satu guard: web, cek role)
     */
    public function me(Request $request)
    {
        try {
            if (!Auth::check()) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak terautentikasi',
                    'authenticated' => false
                ], 401);
            }

            $user = Auth::user();
            $role = $user->role ?? 'Customer';

            Log::debug('Auth me check', [
                'user_id' => $user->id,
                'role' => $role
            ]);

            return response()->json([
                'success' => true,
                'authenticated' => true,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'phone' => $user->phone,
                    'role' => $role,
                    'status' => $user->status ?? 'active',
                    'email_verified_at' => $user->email_verified_at,
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                    'last_login' => $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : null,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Auth check failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error checking authentication',
                'authenticated' => false,
                'debug' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * Check session untuk frontend (auth web + role)
     */
    public function checkSession(Request $request)
    {
        try {
            $userData = null;
            if (Auth::check()) {
                $user = Auth::user();
                $role = $user->role ?? 'Customer';
                $userData = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email ?? null,
                    'username' => $user->username ?? null,
                    'phone' => $user->phone ?? null,
                    'role' => $role,
                ];
            }

            return response()->json([
                'success' => true,
                'authenticated' => !is_null($userData),
                'user' => $userData
            ]);
        } catch (\Exception $e) {
            Log::error('Check session failed', ['error' => $e->getMessage()]);
            return response()->json([
                'success' => false,
                'authenticated' => false,
                'message' => 'Error checking session'
            ], 500);
        }
    }

    /**
     * Session info tanpa middleware auth - untuk theme JS (guest atau auth)
     */
    public function session(Request $request)
    {
        try {
            $userData = null;
            if (Auth::check()) {
                $user = Auth::user();
                $role = $user->role ?? 'Customer';
                $userData = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email ?? null,
                    'username' => $user->username ?? null,
                    'phone' => $user->phone ?? null,
                    'role' => $role,
                ];
            }
            return response()->json([
                'success' => true,
                'authenticated' => !is_null($userData),
                'user' => $userData
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'authenticated' => false,
                'user' => null
            ], 500);
        }
    }

    // ======================== HELPER METHODS ========================

    /**
     * Response ketika login gagal
     */
    protected function loginFailedResponse(Request $request)
    {
        $errorResponse = [
            'success' => false,
            'message' => 'Username/email/phone atau password salah.',
        ];

        if ($request->expectsJson()) {
            return response()->json($errorResponse, 401);
        }

        return back()
            ->withErrors(['login' => 'Kredensial tidak valid.'])
            ->withInput($request->only('login', 'remember'))
            ->with('error', 'Login gagal. Periksa kembali kredensial Anda.');
    }

    /**
     * Get redirect path based on user role (untuk admin/staff)
     */
    protected function getRedirectUrlByRole($role)
    {
        $role = strtolower(trim($role));
        
        $redirectMap = [
            'admin' => '/admin/dashboard',
            'administrator' => '/admin/dashboard',
            'manajer gudang' => '/manajergudang/dashboard',
            'manager gudang' => '/manajergudang/dashboard',
            'staff gudang' => '/staff/dashboard',
            'staff' => '/staff/dashboard',
            'customer' => '/', // Customer redirect ke home, BUKAN dashboard
            'default' => '/',
        ];

        // Cek exact match
        if (isset($redirectMap[$role])) {
            return $redirectMap[$role];
        }

        // Cek partial match
        foreach ($redirectMap as $key => $url) {
            if (str_contains($role, $key) || str_contains($key, $role)) {
                return $url;
            }
        }

        return $redirectMap['default'];
    }

    /**
     * Forgot Password handler
     */
    public function forgotPassword(Request $request)
    {
        try {
            $validated = $request->validate([
                'identifier' => 'required|string',
            ]);

            $identifier = trim($validated['identifier']);

            Log::info('Forgot password request', [
                'identifier' => $identifier
            ]);

            // Cari user
            $user = User::where('email', $identifier)
                ->orWhere('phone', $identifier)
                ->orWhere('username', $identifier)
                ->first();

            if ($user) {
                // Generate reset token
                $resetToken = Str::random(60);
                $user->update([
                    'reset_token' => $resetToken,
                    'reset_token_expires' => now()->addHours(2)
                ]);

                Log::info('Reset token generated', [
                    'user_id' => $user->id,
                    'email' => $user->email,
                ]);

                $response = [
                    'success' => true,
                    'message' => 'Instruksi reset password telah dikirim.',
                ];

                if ($request->expectsJson()) {
                    return response()->json($response);
                }

                return back()->with('success', 'Instruksi reset password telah dikirim.');
            }

            Log::warning('Forgot password - identifier not found', [
                'identifier' => $identifier
            ]);

            $errorResponse = [
                'success' => false,
                'message' => 'Email/nomor telepon tidak terdaftar dalam sistem.'
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 404);
            }

            return back()->withErrors(['identifier' => 'Email/nomor telepon tidak terdaftar.']);

        } catch (\Exception $e) {
            Log::error('Forgot password failed', [
                'error' => $e->getMessage(),
                'trace' => $e->getTraceAsString()
            ]);

            $errorResponse = [
                'success' => false,
                'message' => 'Terjadi kesalahan. Silakan coba lagi nanti.'
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 500);
            }

            return back()->withErrors(['error' => 'Terjadi kesalahan. Silakan coba lagi nanti.']);
        }
    }

    /**
     * Simple ping endpoint untuk testing
     */
    public function ping()
    {
        return response()->json([
            'success' => true,
            'message' => 'Auth API is working',
            'timestamp' => now()->format('Y-m-d H:i:s'),
            'php_version' => PHP_VERSION,
            'laravel_version' => app()->version()
        ]);
    }
}