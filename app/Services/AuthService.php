<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\AuthRepository;
use App\Repositories\Interfaces\UserRepositoryInterface;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;
use Illuminate\Validation\ValidationException;
use Laravel\Socialite\Facades\Socialite;

class AuthService
{
    protected UserRepositoryInterface $userRepo;

    public function __construct(
        UserRepositoryInterface $userRepo,
        protected AuthRepository $authRepository,
    ) {
        $this->userRepo = $userRepo;
    }

    /**
     * API registration helper (digunakan oleh layer lain).
     */
    public function register(array $data)
    {
        $data['password'] = Hash::make($data['password']);

        return $this->userRepo->create($data);
    }

    /**
     * API login helper (token-based, tidak dipakai untuk web guard).
     */
    public function login(array $credentials)
    {
        $user = $this->userRepo->findByEmail($credentials['email']);

        if (! $user || ! Hash::check($credentials['password'], $user->password)) {
            throw ValidationException::withMessages([
                'email' => ['Invalid credentials'],
            ]);
        }

        return $user->createToken('auth_token')->plainTextToken;
    }

    /**
     * Generate URL redirect ke Google (Socialite).
     */
    public function getGoogleRedirectUrl(): string
    {
        return Socialite::driver('google')
            ->redirect()
            ->getTargetUrl();
    }

    /**
     * Handle callback Google dan login via session (web guard).
     */
    public function handleGoogleCallback(): RedirectResponse
    {
       /** @var \Laravel\Socialite\Contracts\Provider $driver */
    $driver = Socialite::driver('google');

    $googleUser = $driver->stateless()->user();


    $email    = $googleUser->getEmail();
    $name     = $googleUser->getName() ?: $googleUser->getNickname() ?: ($email ?: 'User '.Str::random(6));
    $googleId = $googleUser->getId();

        // 1. Cari user berdasarkan email
        $user = $this->authRepository->findUserByEmail($email);

        if ($user instanceof User) {
            // Update google_id jika masih kosong
            $this->authRepository->updateGoogleIdIfEmpty($user, $googleId);
        } else {
            // 2. Jika belum ada, buat user baru dengan role HARUS Customer
            $user = $this->authRepository->createCustomerFromGoogle(
                name: $name,
                email: $email,
                googleId: $googleId,
            );
        }

        // 3. Login via session web guard
        Auth::login($user, remember: false);

        // 4. Redirect berdasarkan role (mengikuti pola existing app)
        $redirectUrl = $this->getRedirectUrlByRole($user);

        return redirect()->intended($redirectUrl);
    }

    /**
     * Mapping redirect berdasarkan role User (Admin/Manajer/Staff/Customer).
     */
    protected function getRedirectUrlByRole(User $user): string
    {
        $role = strtolower(trim($user->role ?? 'Customer'));

        $redirectMap = [
            'admin'           => '/admin/dashboard',
            'administrator'   => '/admin/dashboard',
            'manajer gudang'  => '/manajergudang/dashboard',
            'manager gudang'  => '/manajergudang/dashboard',
            'staff gudang'    => '/staff/dashboard',
            'staff'           => '/staff/dashboard',
            'customer'        => '/', // Customer tetap ke homepage utama
        ];

        if (isset($redirectMap[$role])) {
            return $redirectMap[$role];
        }

        foreach ($redirectMap as $key => $url) {
            if (str_contains($role, $key) || str_contains($key, $role)) {
                return $url;
            }
        }

        return '/';
    }
}

