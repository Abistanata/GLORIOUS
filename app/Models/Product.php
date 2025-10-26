<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'category_id',
        'supplier_id',
        'name',
        'sku',
        'description',
        'purchase_price',
        'selling_price',
        'image',
        'current_stock',
        'min_stock',
        'unit',
    ];

    protected $attributes = [
        'current_stock' => 0,
        'min_stock' => 0,
        'unit' => 'pcs',
    ];

    protected $appends = ['stock_status'];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    // Accessors
    protected function stockStatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                $currentStock = $this->current_stock;
                
                if ($currentStock <= 0) {
                    return 'out_of_stock';
                } elseif ($currentStock <= $this->min_stock) {
                    return 'low_stock';
                } else {
                    return 'in_stock';
                }
            }
        );
    }

    // Helper method for calculating available stock - SESUAIKAN DENGAN STRUCTURE ANDA
    public function availableStock()
    {
        // Jika menggunakan current_stock langsung dari database
        return $this->current_stock;
        
        // OPSI 2: Jika menggunakan perhitungan dari stockTransactions
        // if ($this->relationLoaded('stockTransactions')) {
        //     $stockIn = $this->stockTransactions->where('type', 'Masuk')->sum('quantity');
        //     $stockOut = $this->stockTransactions->where('type', 'Keluar')->sum('quantity');
        //     return $stockIn - $stockOut;
        // }
        
        // OPSI 3: Query langsung ke database
        // $stockIn = $this->stockTransactions()->where('type', 'Masuk')->sum('quantity');
        // $stockOut = $this->stockTransactions()->where('type', 'Keluar')->sum('quantity');
        // return $stockIn - $stockOut;
    }

    // Scope untuk filtering
    public function scopeInStock($query)
    {
        return $query->where('current_stock', '>', 0);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('current_stock <= min_stock')
                    ->where('current_stock', '>', 0);
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('current_stock', '<=', 0);
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    // Method untuk update stock
    public function updateStock($quantity, $type = 'in')
    {
        if ($type === 'in') {
            $this->current_stock += $quantity;
        } else {
            $this->current_stock -= $quantity;
        }
        
        $this->save();
    }
}