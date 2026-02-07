<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable
{
    use HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'username',
        'email',    // Opsional
        'phone',    // Wajib (WhatsApp)
        'password',
        'profile_photo_path',
        'role',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $attributes = [
        'role' => 'Customer',
    ];

    /**
     * Accessor yang akan di-append ke model
     * Ini membuat $user->whatsapp_link bisa diakses
     */
    protected $appends = [
        'formatted_phone',
        'whatsapp_link',
    ];

    protected function casts(): array
    {
        return [
            'email_verified_at' => 'datetime',
            'password' => 'hashed',
        ];
    }

    /**
     * Untuk login bisa menggunakan username ATAU phone
     * Default: login dengan username
     */
    public function username()
    {
        return 'username';
    }
    
    // Alternatif: login dengan phone (WhatsApp)
    // public function username()
    // {
    //     return 'phone';
    // }

    // =========== SCOPES UNTUK ROLE ===========
    
    public function scopeAdmin($query)
    {
        return $query->where('role', 'Admin');
    }

    public function scopeStaffGudang($query)
    {
        return $query->where('role', 'Staff Gudang');
    }

    public function scopeManajerGudang($query)
    {
        return $query->where('role', 'Manajer Gudang');
    }

    public function scopeCustomer($query)
    {
        return $query->where('role', 'Customer');
    }

    // =========== HELPER METHODS CEK ROLE ===========
    
    public function isAdmin(): bool
    {
        return $this->role === 'Admin';
    }

    public function isStaffGudang(): bool
    {
        return $this->role === 'Staff Gudang';
    }

    public function isManajerGudang(): bool
    {
        return $this->role === 'Manajer Gudang';
    }

    public function isCustomer(): bool
    {
        return $this->role === 'Customer';
    }

    // =========== RELATIONSHIPS (Customer) ===========

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // =========== MUTATORS & ACCESSORS ===========
    
    /**
     * Mutator untuk format phone
     * Otomatis membersihkan format nomor
     */
    public function setPhoneAttribute($value)
    {
        // Format nomor telepon: hapus semua karakter non-digit
        $cleaned = preg_replace('/[^0-9]/', '', $value);
        
        // Pastikan format diawali 62
        if (strlen($cleaned) > 0) {
            if (substr($cleaned, 0, 1) === '0') {
                // Ubah 0xxxx menjadi 62xxxx
                $cleaned = '62' . substr($cleaned, 1);
            } elseif (substr($cleaned, 0, 2) !== '62') {
                // Jika tidak diawali 0 atau 62, tambahkan 62
                $cleaned = '62' . $cleaned;
            }
        }
        
        $this->attributes['phone'] = $cleaned;
    }
    
    /**
     * Accessor untuk format phone yang rapih
     */
    public function getFormattedPhoneAttribute()
    {
        $phone = $this->phone;
        
        if (empty($phone)) {
            return '-';
        }
        
        // Format: +62 812-3456-7890
        if (strlen($phone) >= 10) {
            if (substr($phone, 0, 2) === '62') {
                $phone = '62' . substr($phone, 2); // Pastikan tetap 62
            }
            
            // Format: +62 812-3456-7890
            if (strlen($phone) === 12) { // 628123456789
                return '+62 ' . substr($phone, 2, 3) . '-' . 
                       substr($phone, 5, 4) . '-' . 
                       substr($phone, 9);
            } elseif (strlen($phone) === 13) { // 6281234567890
                return '+62 ' . substr($phone, 2, 4) . '-' . 
                       substr($phone, 6, 4) . '-' . 
                       substr($phone, 10);
            }
        }
        
        return $phone;
    }
    
    /**
     * Accessor untuk WhatsApp link
     */
    public function getWhatsappLinkAttribute()
    {
        if (empty($this->phone)) {
            return '#';
        }
        
        return 'https://wa.me/' . $this->phone;
    }
    
    /**
     * Accessor untuk menampilkan nomor dengan format internasional
     */
    public function getInternationalPhoneAttribute()
    {
        if (empty($this->phone)) {
            return '-';
        }
        
        // Jika sudah diawali 62, tambahkan +
        if (substr($this->phone, 0, 2) === '62') {
            return '+' . $this->phone;
        }
        
        return $this->phone;
    }
}