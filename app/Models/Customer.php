<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Database\Eloquent\SoftDeletes;
use Laravel\Sanctum\HasApiTokens;  // TAMBAHKAN INI

class Customer extends Authenticatable
{
    use HasFactory, Notifiable, SoftDeletes, HasApiTokens;  // TAMBAHKAN HasApiTokens

    protected $guard = 'customer';

    protected $fillable = [
        'username',
        'name',
        'email',
        'phone',
        'whatsapp',
        'address',
        'password',
        'status',
        'reset_token',
        'reset_token_expires',
        'last_login_at',
    ];

    protected $hidden = [
        'password',
        'remember_token',
        'reset_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
        'reset_token_expires' => 'datetime',
        'last_login_at' => 'datetime',
    ];

    public function isActive()
    {
        return $this->status === 'active';
    }

    /**
     * Get the unique identifier for authentication.
     */
    public function getAuthIdentifierName()
    {
        return 'username';
    }

    /**
     * Check if customer can login.
     */
    public function canLogin()
    {
        return $this->isActive();
    }

    /**
     * Update last login timestamp.
     */
    public function recordLogin()
    {
        $this->update(['last_login_at' => now()]);
    }

    /**
     * Create a new API token for the user.
     */
    public function createApiToken()
    {
        return $this->createToken('customer-api-token', ['customer'])->plainTextToken;
    }
}