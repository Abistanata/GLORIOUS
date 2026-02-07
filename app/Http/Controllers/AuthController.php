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

    /**
     * Tampilkan form login (untuk redirect guest)
     */
    public function showLoginForm(Request $request)
    {
        if (Auth::check()) {
            return $this->redirectByRole(Auth::user()->role);
        }
        return view('auth.login');
    }

    /**
     * Handle registration - buat User dengan role Customer (satu tabel users, auth() saja)
     */
    public function register(Request $request)
    {
        try {
            $validated = $request->validate([
                'name' => 'required|string|max:100',
                'username' => 'required|string|unique:users,username|min:3|max:50|regex:/^[a-zA-Z0-9_]+$/',
                'phone' => 'required|string|min:10|max:15',
                'password' => 'required|string|min:6|confirmed',
                'email' => 'nullable|email|unique:users,email',
                'terms' => 'accepted',
            ], [
                'username.regex' => 'Username hanya boleh mengandung huruf, angka, dan underscore',
                'terms.accepted' => 'Anda harus menyetujui syarat dan ketentuan',
            ]);

            $phone = $this->normalizePhone($validated['phone']);
            $email = $validated['email'] ?? null;
            if (!$email) {
                $email = $validated['username'] . '@customer.local';
                if (User::where('email', $email)->exists()) {
                    $email = $validated['username'] . '_' . time() . '@customer.local';
                }
            }

            $user = User::create([
                'name' => $validated['name'],
                'username' => $validated['username'],
                'email' => $email,
                'phone' => $phone,
                'whatsapp' => $phone,
                'password' => Hash::make($validated['password']),
                'role' => 'Customer',
            ]);

            Auth::login($user, $request->boolean('remember'));
            $request->session()->regenerate();

            Log::info('Customer registered', ['user_id' => $user->id, 'username' => $user->username]);

            $response = [
                'success' => true,
                'message' => 'Registrasi berhasil! Selamat bergabung.',
                'user' => $this->userResponse($user),
                'redirect' => null,
            ];

            if ($request->expectsJson()) {
                return response()->json($response);
            }
            return redirect()->intended('/')->with('success', 'Registrasi berhasil!');
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Registration failed', ['error' => $e->getMessage()]);
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan server.'], 500);
            }
            return back()->withErrors(['error' => 'Registrasi gagal. Silakan coba lagi.'])->withInput();
        }
    }

    /**
     * Login - SATU CEK: User table saja. Role Customer → tetap di halaman; Admin/Staff → redirect dashboard
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

            $user = User::where('email', $login)
                ->orWhere('username', $login)
                ->first();

            if (!$user && $this->looksLikePhone($login)) {
                $normalizedPhone = $this->normalizePhoneForLookup($login);
                $user = User::where('phone', $normalizedPhone)
                    ->orWhere('whatsapp', $normalizedPhone)
                    ->first();
            }

            if (!$user || !Hash::check($password, $user->password)) {
                if ($request->expectsJson()) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Username/Email/Phone atau password salah.',
                    ], 401);
                }
                return back()->withErrors(['login' => 'Kredensial tidak valid.'])->withInput();
            }

            Auth::login($user, $remember);
            $request->session()->regenerate();

            $role = $user->role ?? 'Customer';
            $redirectUrl = $this->redirectByRole($role, true);
            $isCustomer = ($role === 'Customer');

            $response = [
                'success' => true,
                'message' => 'Login berhasil! Selamat datang, ' . $user->name,
                'user' => $this->userResponse($user),
                'user_type' => $isCustomer ? 'customer' : strtolower(str_replace(' ', '_', $role)),
                'redirect' => $isCustomer ? null : $redirectUrl,
            ];

            if ($request->expectsJson()) {
                return response()->json($response);
            }
            return redirect()->intended($redirectUrl);
        } catch (\Illuminate\Validation\ValidationException $e) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Validasi gagal', 'errors' => $e->errors()], 422);
            }
            return back()->withErrors($e->errors())->withInput();
        } catch (\Exception $e) {
            Log::error('Login failed', ['error' => $e->getMessage()]);
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Terjadi kesalahan server.'], 500);
            }
            return back()->withErrors(['error' => 'Login gagal.'])->withInput();
        }
    }

    /**
     * Redirect berdasarkan role: Customer tetap (null/back), Admin/Staff ke dashboard
     */
    protected function redirectByRole($role, $returnUrl = false)
    {
        $role = is_string($role) ? trim($role) : 'Customer';
        $map = [
            'Admin' => '/admin/dashboard',
            'Manajer Gudang' => '/manajergudang/dashboard',
            'Staff Gudang' => '/staff/dashboard',
        ];
        $url = $map[$role] ?? null;
        if ($returnUrl) {
            return $url ?? url()->previous('/');
        }
        if ($url) {
            return redirect($url);
        }
        return redirect('/');
    }

    private function userResponse(User $user): array
    {
        $base = [
            'id' => $user->id,
            'name' => $user->name,
            'role' => $user->role ?? 'Customer',
            'email' => $user->email,
            'username' => $user->username,
            'phone' => $user->phone,
            'whatsapp' => $user->whatsapp,
        ];
        return $base;
    }

    private function normalizePhone(string $phone): string
    {
        $phone = preg_replace('/\D/', '', $phone);
        if (Str::startsWith($phone, '62')) {
            $phone = '0' . substr($phone, 2);
        } elseif (!Str::startsWith($phone, '0')) {
            $phone = '0' . $phone;
        }
        return $phone;
    }

    /** Normalize phone for login lookup so 62xxx / 08xxx / 8xxx all match stored 08xxx */
    private function normalizePhoneForLookup(string $value): string
    {
        return $this->normalizePhone($value);
    }

    private function looksLikePhone(string $value): bool
    {
        $digits = preg_replace('/\D/', '', $value);
        return strlen($digits) >= 9 && strlen($digits) <= 15;
    }

    public function logout(Request $request)
    {
        Auth::logout();
        $request->session()->invalidate();
        $request->session()->regenerateToken();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'message' => 'Logout berhasil.']);
        }
        return redirect('/')->with('success', 'Logout berhasil.');
    }

    public function me(Request $request)
    {
        if (!Auth::check()) {
            return response()->json([
                'success' => false,
                'authenticated' => false,
                'message' => 'Tidak terautentikasi',
            ], 401);
        }
        return response()->json([
            'success' => true,
            'authenticated' => true,
            'user' => $this->userResponse(Auth::user()),
        ]);
    }

    public function checkRole(Request $request, $role)
    {
        $userRole = Auth::check() ? (Auth::user()->role ?? null) : null;
        $hasRole = strtolower($userRole ?? '') === strtolower($role);
        return response()->json([
            'success' => true,
            'has_role' => $hasRole,
            'user_role' => $userRole,
        ]);
    }

    public function forgotPassword(Request $request)
    {
        $request->validate(['identifier' => 'required|string']);
        // Placeholder: bisa integrasi reset token nanti
        return response()->json([
            'success' => true,
            'message' => 'Instruksi reset password akan dikirim jika email/nomor terdaftar.',
        ]);
    }

    public function ping()
    {
        return response()->json([
            'success' => true,
            'message' => 'Auth API is working',
            'timestamp' => now()->format('Y-m-d H:i:s'),
        ]);
    }
}
