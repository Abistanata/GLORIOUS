<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use App\Models\User;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // User default
        $defaultUsers = [
            [
                'name' => 'Administrator',
                'username' => 'admin',
                'email' => 'admin@stockify.com',
                'phone' => '6281234567890', // Format: 62 + nomor
                'password' => Hash::make('password123'),
                'role' => 'Admin',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Staff Gudang',
                'username' => 'staff_gudang',
                'email' => 'staff@stockify.com',
                'phone' => '6281234567891',
                'password' => Hash::make('password123'),
                'role' => 'Staff Gudang',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Manajer Gudang',
                'username' => 'manajer_gudang',
                'email' => 'manager@stockify.com',
                'phone' => '6281234567892',
                'password' => Hash::make('password123'),
                'role' => 'Manajer Gudang',
                'email_verified_at' => now(),
            ],
            [
                'name' => 'Customer Contoh',
                'username' => 'customer_demo',
                'email' => 'customer@stockify.com',
                'phone' => '6281234567893',
                'password' => Hash::make('password123'),
                'role' => 'Customer',
                'email_verified_at' => now(),
            ],
        ];

        foreach ($defaultUsers as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']],
                $userData
            );
        }

        // Buat customer dummy
        $existingCustomers = User::where('role', 'Customer')->count();
        if ($existingCustomers < 10) {
            $needed = 10 - $existingCustomers;
            \App\Models\User::factory()
                ->count($needed)
                ->create(['role' => 'Customer']);
        }
    }
}