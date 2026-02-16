<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'order_number',
        'status',
        'shipping_status',
        'total',
        'customer_name',
        'customer_phone',
        'notes',
        'confirmed_at',
    ];

    protected $casts = [
        'total' => 'decimal:2',
        'confirmed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function scopeConfirmedOrProcessed($query)
    {
        return $query->whereIn('status', ['confirmed', 'processed']);
    }
}
