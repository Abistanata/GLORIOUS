<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Laravel\Sanctum\HasApiTokens; // Jika menggunakan Sanctum

class AuthController extends Controller
{
    protected $auth;

    public function __construct(AuthService $auth)
    {
        $this->auth = $auth;
    }

    /**
     * Handle user registration - SEMUA USER DAFTAR DI TABLE USERS
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'username' => 'required|string|unique:users,username|min:3|max:50|regex:/^[a-zA-Z0-9_]+$/',
                'phone' => 'required|string|unique:users,phone|min:8|max:20',
                'password' => 'required|string|min:6|confirmed',
                'email' => 'nullable|email|unique:users,email',
                'terms' => 'sometimes|accepted',
            ], [
                'username.regex' => 'Username hanya boleh mengandung huruf, angka, dan underscore',
                'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
                'phone.min' => 'Nomor telepon minimal 8 digit',
                'phone.max' => 'Nomor telepon maksimal 20 digit',
                'phone.unique' => 'Nomor telepon ini sudah terdaftar',
                'email.unique' => 'Email ini sudah terdaftar',
                'username.unique' => 'Username ini sudah terdaftar',
            ]);

            // Format nomor telepon
            $phone = $validated['phone'];
            $phone = preg_replace('/[^0-9]/', '', $phone);
            
            if (Str::startsWith($phone, '+62')) {
                $phone = Str::replaceFirst('+62', '', $phone);
            } elseif (Str::startsWith($phone, '62')) {
                $phone = Str::replaceFirst('62', '', $phone);
            }
            
            if (!Str::startsWith($phone, '0')) {
                $phone = '0' . $phone;
            }
            
            if (strlen($phone) < 10) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Nomor telepon terlalu pendek setelah diformat',
                        'errors' => ['phone' => ['Nomor telepon minimal 10 digit setelah diformat']]
                    ], 422);
                }
                return back()->withErrors(['phone' => 'Nomor telepon minimal 10 digit setelah diformat'])->withInput();
            }

            // Cek apakah email sudah ada
            if (!empty($validated['email'])) {
                $existingEmail = User::where('email', $validated['email'])->first();
                if ($existingEmail) {
                    if ($request->expectsJson()) {
                        return response()->json([
                            'success' => false,
                            'message' => 'Email sudah terdaftar',
                            'errors' => ['email' => ['Email ini sudah terdaftar']]
                        ], 422);
                    }
                    return back()->withErrors(['email' => 'Email ini sudah terdaftar'])->withInput();
                }
            }

            // Buat user dengan role Customer
            $userData = [
                'name' => $validated['name'],
                'username' => $validated['username'],
                'phone' => $phone,
                'whatsapp' => $phone,
                'password' => Hash::make($validated['password']),
                'role' => 'Customer',
                'status' => 'active',
                'last_login_at' => now(),
            ];

            if (!empty($validated['email'])) {
                $userData['email'] = $validated['email'];
            }

            $user = User::create($userData);

            // Auto login untuk web
            if (!$request->expectsJson()) {
                Auth::login($user, $request->has('remember'));
            }

            Log::info('User registered successfully', [
                'user_id' => $user->id,
                'username' => $user->username,
                'role' => $user->role
            ]);

            $response = [
                'success' => true,
                'message' => 'Registrasi berhasil! Selamat bergabung.',
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => $user->role,
                    'status' => $user->status,
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                ]
            ];

            // Tambahkan token jika API request
            if ($request->expectsJson()) {
                // Jika menggunakan Sanctum
                if (method_exists($user, 'createToken')) {
                    $token = $user->createToken('auth_token')->plainTextToken;
                    $response['access_token'] = $token;
                    $response['token_type'] = 'Bearer';
                }
                return response()->json($response, 201);
            }

            return redirect('/customer/dashboard')
                ->with('success', 'Registrasi berhasil!');

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

            return back()
                ->withErrors(['error' => 'Registrasi gagal. Silakan coba lagi.'])
                ->withInput();
        }
    }

    /**
     * API Register - khusus untuk API calls
     * Method alternatif jika route mengarah ke apiRegister
     */
    public function apiRegister(Request $request)
    {
        // Panggil method register biasa
        return $this->register($request);
    }

    /**
     * Handle user login - SEMUA USER DI TABLE USERS
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

            // Format login jika berupa nomor telepon
            if (is_numeric($login) || Str::startsWith($login, '+') || Str::startsWith($login, '0')) {
                $phone = preg_replace('/[^0-9]/', '', $login);
                if (Str::startsWith($phone, '62')) {
                    $phone = '0' . substr($phone, 2);
                } elseif (!Str::startsWith($phone, '0')) {
                    $phone = '0' . $phone;
                }
                $login = $phone;
            }

            // Cari user
            $user = User::where(function ($query) use ($login) {
                $query->where('email', $login)
                    ->orWhere('username', $login)
                    ->orWhere('phone', $login)
                    ->orWhere('whatsapp', $login);
            })->first();

            if (!$user || !Hash::check($password, $user->password)) {
                return $this->loginFailedResponse($request);
            }

            // Cek status
            if ($user->status !== 'active') {
                $errorResponse = [
                    'success' => false,
                    'message' => 'Akun tidak aktif. Silakan hubungi administrator.',
                ];

                if ($request->expectsJson()) {
                    return response()->json($errorResponse, 403);
                }

                return back()->withErrors(['login' => 'Akun tidak aktif.'])->withInput();
            }

            // Login berhasil
            if (!$request->expectsJson()) {
                Auth::login($user, $remember);
                $request->session()->regenerate();
            }
            
            $user->update(['last_login_at' => now()]);

            $role = $user->role ?? 'Customer';
            $redirectUrl = $this->getRedirectUrlByRole($role);
            
            $response = [
                'success' => true,
                'message' => 'Login berhasil! Selamat datang, ' . $user->name,
                'user' => [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'username' => $user->username,
                    'phone' => $user->phone,
                    'role' => $role,
                    'status' => $user->status,
                ],
                'redirect' => $redirectUrl,
            ];

            // Tambahkan token untuk API
            if ($request->expectsJson()) {
                if (method_exists($user, 'createToken')) {
                    $token = $user->createToken('auth_token')->plainTextToken;
                    $response['access_token'] = $token;
                    $response['token_type'] = 'Bearer';
                }
                return response()->json($response);
            }

            return redirect($redirectUrl);

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $errorResponse = [
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $errors
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 422);
            }

            return back()->withErrors($errors)->withInput();

        } catch (\Exception $e) {
            Log::error('Login process failed', [
                'error' => $e->getMessage()
            ]);

            $errorResponse = [
                'success' => false,
                'message' => 'Terjadi kesalahan server.',
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 500);
            }

            return back()->withErrors(['error' => 'Login gagal.']);
        }
    }

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
            ->withInput();
    }

    /**
     * Get redirect path based on user role
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
            'customer' => '/',
            'default' => '/',
        ];

        if (isset($redirectMap[$role])) {
            return $redirectMap[$role];
        }

        foreach ($redirectMap as $key => $url) {
            if (str_contains($role, $key) || str_contains($key, $role)) {
                return $url;
            }
        }

        return $redirectMap['default'];
    }

    /**
     * Logout user
     */
    public function logout(Request $request)
    {
        try {
            $user = Auth::user();
            
            // Logout API token jika ada
            if ($request->expectsJson() && $user) {
                $user->tokens()->delete();
            }
            
            // Logout session
            Auth::logout();
            $request->session()->invalidate();
            $request->session()->regenerateToken();

            $response = [
                'success' => true,
                'message' => 'Logout berhasil.',
            ];

            if ($request->expectsJson()) {
                return response()->json($response);
            }

            return redirect('/')->with('success', 'Logout berhasil.');

        } catch (\Exception $e) {
            Log::error('Logout failed', [
                'error' => $e->getMessage()
            ]);

            $errorResponse = [
                'success' => false,
                'message' => 'Terjadi kesalahan saat logout.'
            ];

            if ($request->expectsJson()) {
                return response()->json($errorResponse, 500);
            }

            return redirect('/')->with('error', 'Terjadi kesalahan saat logout.');
        }
    }

    /**
     * Get current authenticated user info
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
                    'last_login' => $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : null,
                ]
            ]);

        } catch (\Exception $e) {
            Log::error('Auth check failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error checking authentication',
                'authenticated' => false
            ], 500);
        }
    }

    /**
     * Check session untuk frontend
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
                    'email' => $user->email,
                    'username' => $user->username,
                    'phone' => $user->phone,
                    'role' => $role,
                    'status' => $user->status,
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
                'message' => 'Error checking session'
            ], 500);
        }
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

            // Format identifier jika berupa nomor telepon
            if (is_numeric($identifier) || Str::startsWith($identifier, '+') || Str::startsWith($identifier, '0')) {
                $phone = preg_replace('/[^0-9]/', '', $identifier);
                if (Str::startsWith($phone, '62')) {
                    $phone = '0' . substr($phone, 2);
                } elseif (!Str::startsWith($phone, '0')) {
                    $phone = '0' . $phone;
                }
                $identifier = $phone;
            }

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

                return response()->json([
                    'success' => true,
                    'message' => 'Instruksi reset password telah dikirim.',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Email/nomor telepon/username tidak terdaftar.'
            ], 404);

        } catch (\Exception $e) {
            Log::error('Forgot password failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan. Silakan coba lagi nanti.'
            ], 500);
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