<?php

namespace App\Repositories;

use App\Models\User;
use Illuminate\Support\Str;

class AuthRepository
{
    public function findUserByEmail(?string $email): ?User
    {
        if ($email === null || $email === '') {
            return null;
        }

        return User::where('email', $email)->first();
    }

    public function updateGoogleIdIfEmpty(User $user, string $googleId): User
    {
        if (empty($user->google_id)) {
            $user->google_id = $googleId;
            $user->save();
        }

        return $user;
    }

    public function createCustomerFromGoogle(string $name, ?string $email, string $googleId): User
    {
        return User::create([
            'name'      => $name,
            'email'     => $email,
            'role'      => 'Customer', // hard-coded, tidak bisa diubah dari input
            'password'  => bcrypt(Str::random(40)),
            'google_id' => $googleId,
        ]);
    }
}

