<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run(): void
    {
        User::create([
            'name' => 'Admin',
            'email' => 'admin@stockify.com',
            'password' => Hash::make('password'),
            'role' => 'Admin',
        ]);

        User::create([
            'name' => 'Manajer Gudang',
            'email' => 'manager@stockify.com',
            'password' => Hash::make('password'),
            'role' => 'Manajer Gudang',
        ]);

        User::create([
            'name' => 'Staff Gudang',
            'email' => 'staff@stockify.com',
            'password' => Hash::make('password'),
            'role' => 'Staff Gudang',
        ]);
    }
}
