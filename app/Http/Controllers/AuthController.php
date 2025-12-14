<?php

namespace App\Http\Controllers;

use App\Services\AuthService;
use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Customer;
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

    /**
     * Handle user registration dengan TYPE EXPLICIT
     */
    public function register(Request $request)
    {
        try {
            // ✅ TAMBAHKAN VALIDASI TYPE
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'username' => 'required|string|unique:customers,username|min:3|max:50|regex:/^[a-zA-Z0-9_]+$/',
                'phone' => 'required|string|unique:customers,phone|min:10|max:15',
                'password' => 'required|string|min:6|confirmed',
                'email' => 'nullable|email|unique:customers,email',
                'terms' => 'accepted',
                'type' => 'required|in:customer' // ✅ HANYA CUSTOMER BISA REGISTER VIA WEB
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

            // Buat customer
            $customer = Customer::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'phone' => $phone,
                'email' => $validated['email'] ?? null,
                'whatsapp' => $phone,
                'password' => Hash::make($validated['password']),
                'status' => 'active',
            ]);

            // Auto login customer
            Auth::guard('customer')->login($customer, $request->has('remember'));
            
            // ✅ UPDATE LAST LOGIN (tambah method recordLogin di model Customer)
            if (method_exists($customer, 'recordLogin')) {
                $customer->recordLogin();
            } else {
                $customer->update(['last_login_at' => now()]);
            }

            $response = [
                'success' => true,
                'message' => 'Registrasi berhasil! Selamat bergabung dengan Glorious Computer.',
                'user_type' => 'customer',
                'user' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'username' => $customer->username,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'role' => 'customer',
                    'created_at' => $customer->created_at->format('Y-m-d H:i:s'),
                ],
                'redirect' => '/customer/dashboard', // ✅ REDIRECT KE DASHBOARD CUSTOMER
            ];

            Log::info('Customer registered successfully', [
                'customer_id' => $customer->id,
                'username' => $customer->username
            ]);

            if ($request->expectsJson()) {
                return response()->json($response);
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

            return back()->withErrors(['error' => 'Registrasi gagal. Silakan coba lagi.'])->withInput();
        }
    }

    /**
     * Handle user login - DENGAN TYPE EXPLICIT
     */
    public function login(Request $request)
    {
        try {
            // ✅ TAMBAHKAN VALIDASI TYPE
            $validated = $request->validate([
                'login' => 'required|string',
                'password' => 'required|string',
                'remember' => 'boolean',
                'type' => 'required|in:user,customer' // ✅ TYPE WAJIB ADA
            ]);

            $login = trim($validated['login']);
            $password = $validated['password'];
            $remember = $validated['remember'] ?? false;
            $type = $validated['type']; // ✅ AMBIL TYPE

            Log::info('Login attempt', [
                'login' => $login,
                'type' => $type,
                'remember' => $remember,
                'ip' => $request->ip()
            ]);

            // ✅ LOGIKA BERDASARKAN TYPE
            if ($type === 'customer') {
                return $this->loginCustomer($login, $password, $remember, $request);
            } else {
                return $this->loginUser($login, $password, $remember, $request);
            }

        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $errorMessage = 'Validasi gagal: ' . implode(', ', array_map(function ($fieldErrors) {
                return implode(', ', $fieldErrors);
            }, array_values($errors)));

            Log::warning('Login validation failed', [
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
            Log::error('Login process failed', [
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

    /**
     * Login untuk Customer
     */
    protected function loginCustomer($login, $password, $remember, Request $request)
    {
        $customer = Customer::where('username', $login)
            ->orWhere('email', $login)
            ->orWhere('phone', $login)
            ->orWhere('whatsapp', $login)
            ->first();

        if (!$customer) {
            return $this->loginFailedResponse($request, 'customer');
        }

        Log::debug('Customer found', [
            'customer_id' => $customer->id,
            'username' => $customer->username
        ]);

        if (!Hash::check($password, $customer->password)) {
            Log::warning('Customer password mismatch', ['customer_id' => $customer->id]);
            return $this->loginFailedResponse($request, 'customer');
        }

        // Login customer berhasil
        Auth::guard('customer')->login($customer, $remember);
        
        // Update last login
        if (method_exists($customer, 'recordLogin')) {
            $customer->recordLogin();
        } else {
            $customer->update(['last_login_at' => now()]);
        }

        Log::info('Customer login successful', [
            'customer_id' => $customer->id,
            'name' => $customer->name
        ]);

        $response = [
            'success' => true,
            'message' => 'Login berhasil! Selamat datang, ' . $customer->name,
            'user_type' => 'customer',
            'user' => [
                'id' => $customer->id,
                'name' => $customer->name,
                'username' => $customer->username,
                'email' => $customer->email,
                'phone' => $customer->phone,
                'role' => 'customer',
                'last_login' => now()->format('Y-m-d H:i:s'),
            ],
            'redirect' => '/customer/dashboard', // ✅ REDIRECT KONSISTEN
        ];

        if ($request->expectsJson()) {
            return response()->json($response);
        }

        return redirect('/customer/dashboard')
            ->with('success', 'Login berhasil!');
    }

    /**
     * Login untuk User (Admin/Staff/Manager)
     */
    protected function loginUser($login, $password, $remember, Request $request)
    {
        // User hanya login dengan email
        $user = User::where('email', $login)->first();

        if (!$user) {
            return $this->loginFailedResponse($request, 'user');
        }

        Log::debug('User found', [
            'user_id' => $user->id,
            'email' => $user->email,
            'role' => $user->role ?? 'User'
        ]);

        if (!Hash::check($password, $user->password)) {
            Log::warning('User password mismatch', ['user_id' => $user->id]);
            return $this->loginFailedResponse($request, 'user');
        }

        // Login user berhasil
        Auth::login($user, $remember);
        $request->session()->regenerate();
        $user->update(['last_login_at' => now()]);

        $role = $user->role ?? 'User';
        
        Log::info('User login successful', [
            'user_id' => $user->id,
            'name' => $user->name,
            'role' => $role
        ]);

        // Tentukan redirect URL berdasarkan role
        $redirectUrl = $this->getRedirectUrlByRole($role);
        
        $response = [
            'success' => true,
            'message' => 'Login berhasil! Selamat datang, ' . $user->name,
            'user_type' => $this->normalizeRole($role),
            'user' => [
                'id' => $user->id,
                'name' => $user->name,
                'email' => $user->email,
                'role' => $role,
                'original_role' => $role,
                'last_login' => now()->format('Y-m-d H:i:s'),
            ],
            'redirect' => $redirectUrl,
        ];

        if ($request->expectsJson()) {
            return response()->json($response);
        }

        return redirect($redirectUrl);
    }

    /**
     * Response ketika login gagal
     */
    protected function loginFailedResponse(Request $request, $type = 'user')
    {
        $message = $type === 'customer' 
            ? 'Username/email/phone atau password salah.'
            : 'Email atau password salah.';

        $errorResponse = [
            'success' => false,
            'message' => $message,
        ];

        if ($request->expectsJson()) {
            return response()->json($errorResponse, 401);
        }

        return back()
            ->withErrors(['login' => 'Kredensial tidak valid.'])
            ->withInput($request->only('login', 'remember', 'type'))
            ->with('error', 'Login gagal. Periksa kembali kredensial Anda.');
    }

    /**
     * Normalize role untuk response konsisten
     */
    protected function normalizeRole($role)
    {
        $role = strtolower(trim($role));
        
        $mapping = [
            'admin' => 'admin',
            'administrator' => 'admin',
            'manajer gudang' => 'manajer_gudang',
            'manager gudang' => 'manajer_gudang',
            'staff gudang' => 'staff_gudang',
            'staff' => 'staff_gudang',
            'user' => 'user',
            'customer' => 'customer',
        ];

        return $mapping[$role] ?? str_replace(' ', '_', $role);
    }

    /**
     * Get redirect path based on user role - FIXED (tanpa /stockify)
     */
    protected function getRedirectUrlByRole($role)
    {
        $role = strtolower(trim($role));
        
        // ✅ MAPPING ROLE KE REDIRECT URL (TANPA /stockify)
        $redirectMap = [
            'admin' => '/admin/dashboard',
            'administrator' => '/admin/dashboard',
            'manajer gudang' => '/manajergudang/dashboard',
            'manager gudang' => '/manajergudang/dashboard',
            'staff gudang' => '/staff/dashboard',
            'staff' => '/staff/dashboard',
            'customer' => '/customer/dashboard',
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
     * Logout user dengan TYPE EXPLICIT
     */
    public function logout(Request $request)
    {
        try {
            $userType = 'guest';
            $userName = 'Unknown';
            
            // ✅ DETEKSI TYPE DARI REQUEST
            $type = $request->input('type', 'user');

            if ($type === 'customer') {
                if (Auth::guard('customer')->check()) {
                    $customer = Auth::guard('customer')->user();
                    $userType = 'customer';
                    $userName = $customer->name;
                    Auth::guard('customer')->logout();
                    
                    Log::info('Customer logout', [
                        'customer_id' => $customer->id,
                        'name' => $customer->name
                    ]);
                }
            } else {
                if (Auth::check()) {
                    $user = Auth::user();
                    $userType = $this->normalizeRole($user->role ?? 'user');
                    $userName = $user->name;
                    Auth::logout();
                    
                    Log::info('User logout', [
                        'user_id' => $user->id,
                        'name' => $user->name,
                        'role' => $user->role ?? 'unknown'
                    ]);
                }
            }

            $request->session()->invalidate();
            $request->session()->regenerateToken();

            Log::info('Session invalidated and token regenerated');

            $response = [
                'success' => true,
                'message' => 'Logout berhasil. Sampai jumpa lagi, ' . $userName,
                'user_type' => $userType
            ];

            if ($request->expectsJson()) {
                return response()->json($response);
            }

            return redirect('/')
                ->with('success', 'Logout berhasil. Sampai jumpa lagi!');

        } catch (\Exception $e) {
            Log::error('Logout failed', [
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

    /**
     * Get current authenticated user info
     */
    public function me(Request $request)
    {
        try {
            $isAuthenticated = false;
            $userData = null;
            $userType = null;

            // Cek customer dulu
            if (Auth::guard('customer')->check()) {
                $user = Auth::guard('customer')->user();
                $userType = 'customer';
                $isAuthenticated = true;
                
                $userData = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => 'customer',
                    'status' => $user->status ?? 'active',
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                    'last_login' => $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : null,
                ];

            } elseif (Auth::check()) {
                $user = Auth::user();
                $role = $user->role ?? 'User';
                $userType = $this->normalizeRole($role);
                $isAuthenticated = true;
                
                $userData = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $role,
                    'original_role' => $role,
                    'email_verified_at' => $user->email_verified_at,
                    'created_at' => $user->created_at->format('Y-m-d H:i:s'),
                    'last_login' => $user->last_login_at ? $user->last_login_at->format('Y-m-d H:i:s') : null,
                ];
            }

            if (!$isAuthenticated) {
                return response()->json([
                    'success' => false,
                    'message' => 'User tidak terautentikasi',
                    'authenticated' => false
                ], 401);
            }

            Log::debug('Auth check successful', [
                'user_type' => $userType,
                'user_id' => $userData['id'] ?? null
            ]);

            return response()->json([
                'success' => true,
                'authenticated' => true,
                'user_type' => $userType,
                'user' => $userData
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
     * ✅ TAMBAHKAN METHOD CHECK SESSION UNTUK FRONTEND
     */
    public function checkSession(Request $request)
    {
        try {
            $userData = null;
            $userType = null;

            // Cek customer dulu
            if (Auth::guard('customer')->check()) {
                $user = Auth::guard('customer')->user();
                $userType = 'customer';
                $userData = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => 'customer',
                ];
            } elseif (Auth::check()) {
                $user = Auth::user();
                $role = $user->role ?? 'User';
                $userType = $this->normalizeRole($role);
                $userData = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $role,
                ];
            }

            return response()->json([
                'success' => true,
                'authenticated' => !is_null($userData),
                'user_type' => $userType,
                'user' => $userData
            ]);

        } catch (\Exception $e) {
            Log::error('Check session failed', [
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'authenticated' => false,
                'message' => 'Error checking session'
            ], 500);
        }
    }

    /**
     * API Login untuk mobile/external clients (Sanctum)
     */
    public function apiLogin(Request $request)
    {
        try {
            $validated = $request->validate([
                'login' => 'required|string',
                'password' => 'required|string',
            ]);

            $login = trim($validated['login']);
            $password = $validated['password'];

            // Coba sebagai Customer
            $customer = Customer::where('username', $login)
                ->orWhere('email', $login)
                ->orWhere('phone', $login)
                ->first();

            if ($customer && Hash::check($password, $customer->password)) {
                $token = $customer->createToken('customer-api-token')->plainTextToken;
                
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'user_type' => 'customer',
                    'user' => [
                        'id' => $customer->id,
                        'name' => $customer->name,
                        'username' => $customer->username,
                        'email' => $customer->email,
                        'phone' => $customer->phone,
                        'role' => 'customer',
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer',
                ]);
            }

            // Coba sebagai User (Admin/Staff/Manager)
            $user = User::where('email', $login)->first();

            if ($user && Hash::check($password, $user->password)) {
                $token = $user->createToken('user-api-token')->plainTextToken;
                $role = $user->role ?? 'User';
                
                return response()->json([
                    'success' => true,
                    'message' => 'Login berhasil',
                    'user_type' => strtolower(str_replace(' ', '_', $role)),
                    'user' => [
                        'id' => $user->id,
                        'name' => $user->name,
                        'email' => $user->email,
                        'role' => $role,
                    ],
                    'token' => $token,
                    'token_type' => 'Bearer',
                ]);
            }

            return response()->json([
                'success' => false,
                'message' => 'Username/Email/Phone atau password salah',
            ], 401);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * API Register untuk Customer (Sanctum)
     */
    public function apiRegister(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'username' => 'required|string|unique:customers,username|min:3|max:50|regex:/^[a-zA-Z0-9_]+$/',
                'phone' => 'required|string|unique:customers,phone|min:10|max:15',
                'password' => 'required|string|min:6|confirmed',
                'email' => 'nullable|email|unique:customers,email',
            ]);

            // Format phone
            $phone = $validated['phone'];
            if (Str::startsWith($phone, '+62')) {
                $phone = Str::replaceFirst('+62', '', $phone);
            } elseif (Str::startsWith($phone, '62')) {
                $phone = Str::replaceFirst('62', '', $phone);
            }
            if (!Str::startsWith($phone, '0')) {
                $phone = '0' . $phone;
            }

            $customer = Customer::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'phone' => $phone,
                'email' => $validated['email'] ?? null,
                'whatsapp' => $phone,
                'password' => Hash::make($validated['password']),
                'status' => 'active',
            ]);

            // Create token
            $token = $customer->createToken('customer-api-token')->plainTextToken;

            return response()->json([
                'success' => true,
                'message' => 'Registrasi berhasil',
                'user_type' => 'customer',
                'user' => [
                    'id' => $customer->id,
                    'name' => $customer->name,
                    'username' => $customer->username,
                    'email' => $customer->email,
                    'phone' => $customer->phone,
                    'role' => 'customer',
                ],
                'token' => $token,
                'token_type' => 'Bearer',
            ]);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Validasi gagal',
                'errors' => $e->errors()
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Terjadi kesalahan server',
                'error' => config('app.debug') ? $e->getMessage() : null
            ], 500);
        }
    }

    /**
     * API Logout (Sanctum)
     */
    public function apiLogout(Request $request)
    {
        try {
            $user = $request->user();
            $user->tokens()->delete();
            
            return response()->json([
                'success' => true,
                'message' => 'Logout berhasil',
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Logout gagal',
            ], 500);
        }
    }

    /**
     * API Get Current User (Sanctum)
     */
    public function apiMe(Request $request)
    {
        try {
            $user = $request->user();
            
            if (!$user) {
                return response()->json([
                    'success' => false,
                    'authenticated' => false,
                ], 401);
            }

            // Check if user is customer or regular user
            if ($user instanceof Customer) {
                $userType = 'customer';
                $userData = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'username' => $user->username,
                    'email' => $user->email,
                    'phone' => $user->phone,
                    'role' => 'customer',
                ];
            } else {
                $role = $user->role ?? 'User';
                $userType = strtolower(str_replace(' ', '_', $role));
                $userData = [
                    'id' => $user->id,
                    'name' => $user->name,
                    'email' => $user->email,
                    'role' => $role,
                ];
            }

            return response()->json([
                'success' => true,
                'authenticated' => true,
                'user_type' => $userType,
                'user' => $userData,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Error checking authentication',
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
                'type' => 'required|in:user,customer' // ✅ TAMBAHKAN TYPE
            ]);

            $identifier = trim($validated['identifier']);
            $type = $validated['type'];

            Log::info('Forgot password request', [
                'identifier' => $identifier,
                'type' => $type
            ]);

            if ($type === 'customer') {
                // Cari customer
                $user = Customer::where('email', $identifier)
                    ->orWhere('phone', $identifier)
                    ->orWhere('username', $identifier)
                    ->first();
            } else {
                // Cari user
                $user = User::where('email', $identifier)->first();
            }

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
                    'type' => $type
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
                'identifier' => $identifier,
                'type' => $type
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
     * Check if user has specific role
     */
    public function checkRole(Request $request, $role)
    {
        try {
            $hasRole = false;
            $userRole = null;

            if (Auth::guard('customer')->check()) {
                $userRole = 'customer';
                $hasRole = ($role === 'customer');
            } elseif (Auth::check()) {
                $user = Auth::user();
                $userRole = strtolower($user->role ?? 'user');
                $hasRole = ($userRole === strtolower($role));
            }

            return response()->json([
                'success' => true,
                'has_role' => $hasRole,
                'user_role' => $userRole,
                'requested_role' => $role
            ]);

        } catch (\Exception $e) {
            Log::error('Check role failed', [
                'error' => $e->getMessage(),
                'role' => $role
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Error checking role'
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