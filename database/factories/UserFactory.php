<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Str;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\User>
 */
class UserFactory extends Factory
{
    /**
     * The current password being used by the factory.
     */
    protected static ?string $password;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->name(),
            'username' => fake()->unique()->userName(),
            'email' => fake()->unique()->safeEmail(),
            'phone' => '62' . fake()->numerify('##########'), // Format +62
            'email_verified_at' => now(),
            'password' => static::$password ??= Hash::make('password'),
            'profile_photo_path' => null,
            'role' => fake()->randomElement(['Admin', 'Staff Gudang', 'Manajer Gudang', 'Customer']),
            'remember_token' => Str::random(10),
        ];
    
    }

    /**
     * Indicate that the model's email address should be unverified.
     */
    public function unverified(): static
    {
        return $this->state(fn (array $attributes) => [
            'email_verified_at' => null,
        ]);
    }

    /**
     * State untuk berbagai role
     */
    public function admin(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'Admin',
        ]);
    }

    public function staffGudang(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'Staff Gudang',
        ]);
    }

    public function manajerGudang(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'Manajer Gudang',
        ]);
    }

    public function customer(): static
    {
        return $this->state(fn (array $attributes) => [
            'role' => 'Customer',
        ]);
    }
}