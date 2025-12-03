<?php


namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ProductAdditionalInfo extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'warranty_period',
        'shipping_time',
        'condition'
    ];

    protected $attributes = [
        'warranty_period' => '1 Tahun',
        'shipping_time' => '1-3 Hari',
        'condition' => 'Baru'
    ];

    // Relationship
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
