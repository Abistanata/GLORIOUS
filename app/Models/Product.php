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
        'discount_price', // baru
        'image',
        'current_stock',
        'min_stock',
        'max_stock', // baru
        'condition', // baru
        'shipping_info', // baru
        'warranty', // baru
        'unit',
    ];

    protected $attributes = [
        'current_stock' => 0,
        'min_stock' => 0,
        'discount_price' => 0,
        'condition' => 'new',
        'unit' => 'pcs',
    ];

    protected $appends = [
        'stock_status', 
        'formatted_purchase_price', 
        'formatted_selling_price',
        'formatted_discount_price', // baru
        'has_discount', // baru
        'discount_percentage', // baru
        'final_price', // baru
        'profit_margin', // baru
        'stock_percentage', // baru
        'average_rating', // review
        'review_count', // review
    ];

    protected $casts = [
        'purchase_price' => 'decimal:2',
        'selling_price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'current_stock' => 'integer',
        'min_stock' => 'integer',
        'max_stock' => 'integer',
    ];

    // Relationships
    public function category()
    {
        return $this->belongsTo(Category::class)->withDefault([
            'name' => 'Tidak Berkategori'
        ]);
    }

    public function supplier()
    {
        return $this->belongsTo(Supplier::class)->withDefault([
            'name' => 'Tidak Ada Supplier'
        ]);
    }

    public function attributes()
    {
        return $this->hasMany(ProductAttribute::class);
    }

    public function stockTransactions()
    {
        return $this->hasMany(StockTransaction::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // Accessors
    protected function stockStatus(): Attribute
    {
        return Attribute::make(
            get: function () {
                $currentStock = $this->current_stock;

                if ($currentStock <= 0) {
                    return 'out_of_stock';
                }

                if ($currentStock <= $this->min_stock) {
                    return 'low_stock';
                }

                if ($this->max_stock && $currentStock >= $this->max_stock) {
                    return 'max_stock';
                }

                return 'in_stock';
            }
        );
    }

    protected function currentStock(): Attribute
    {
        return Attribute::make(
            get: function ($value) {
                // Selalu kembalikan value langsung dari database saat import
                return $value;
            },
            set: fn ($value) => $value
        );
    }

    protected function formattedPurchasePrice(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp' . number_format($this->purchase_price, 0, ',', '.')
        );
    }

    protected function formattedSellingPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => 'Rp' . number_format($this->selling_price, 0, ',', '.')
        );
    }

    protected function formattedDiscountPrice(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->discount_price > 0 
                ? 'Rp' . number_format($this->discount_price, 0, ',', '.') 
                : null
        );
    }

    protected function hasDiscount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->discount_price > 0 && $this->discount_price < $this->selling_price
        );
    }

    protected function discountPercentage(): Attribute
    {
        return Attribute::make(
            get: function () {
                if (!$this->has_discount || $this->selling_price <= 0) {
                    return 0;
                }

                return round((($this->selling_price - $this->discount_price) / $this->selling_price) * 100, 2);
            }
        );
    }

    protected function finalPrice(): Attribute
    {
        return Attribute::make(
            get: function () {
                if ($this->has_discount) {
                    return $this->discount_price;
                }
                return $this->selling_price;
            }
        );
    }

    protected function profitMargin(): Attribute
    {
        return Attribute::make(
            get: function () {
                $cost = $this->purchase_price;
                $selling = $this->final_price;

                if ($cost <= 0 || $selling <= 0) {
                    return 0;
                }

                return round((($selling - $cost) / $cost) * 100, 2);
            }
        );
    }

    protected function stockPercentage(): Attribute
    {
        return Attribute::make(
            get: function () {
                $current = $this->current_stock;
                $max = $this->max_stock;

                if ($max <= 0 || $current <= 0) {
                    return 0;
                }

                return min(100, round(($current / $max) * 100, 2));
            }
        );
    }

    // Scopes
    public function scopeInStock($query)
    {
        return $query->where('current_stock', '>', 0);
    }

    public function scopeLowStock($query)
    {
        return $query->whereRaw('current_stock <= min_stock AND current_stock > 0');
    }

    public function scopeOutOfStock($query)
    {
        return $query->where('current_stock', '<=', 0);
    }

    public function scopeWithDiscount($query)
    {
        return $query->where('discount_price', '>', 0)
                    ->whereColumn('discount_price', '<', 'selling_price');
    }

    public function scopeNewCondition($query)
    {
        return $query->where('condition', 'new');
    }

    public function scopeUsedCondition($query)
    {
        return $query->where('condition', 'used');
    }

    public function scopeRefurbishedCondition($query)
    {
        return $query->where('condition', 'refurbished');
    }

    // Helper methods
    public function updateStockFromTransactions()
    {
        $this->current_stock = $this->stockTransactions()
            ->selectRaw('SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END) as stock')
            ->value('stock') ?? 0;

        $this->save();
    }

    public function getStockStatusLabel()
    {
        return match($this->stock_status) {
            'out_of_stock' => 'Stok Habis',
            'low_stock' => 'Stok Menipis',
            'max_stock' => 'Stok Maksimum',
            default => 'Stok Aman'
        };
    }

    public function getStockStatusColor()
    {
        return match($this->stock_status) {
            'out_of_stock' => 'danger',
            'low_stock' => 'warning',
            'max_stock' => 'info',
            default => 'success'
        };
    }

    public function getConditionLabel()
    {
        return match($this->condition) {
            'new' => 'Baru',
            'used' => 'Bekas',
            'refurbished' => 'Rekondisi',
            default => 'Tidak Diketahui'
        };
    }

    public function getShippingInfoLabel()
    {
        return match($this->shipping_info) {
            'free' => 'Gratis Ongkir',
            'calculated' => 'Dihitung Otomatis',
            'flat_rate' => 'Tarif Flat',
            'pickup' => 'Ambil di Tempat',
            default => 'Belum Ditentukan'
        };
    }

    public function getWarrantyLabel()
    {
        return match($this->warranty) {
            'no_warranty' => 'Tidak Ada Garansi',
            '1_month' => '1 Bulan',
            '3_months' => '3 Bulan',
            '6_months' => '6 Bulan',
            '1_year' => '1 Tahun',
            '2_years' => '2 Tahun',
            'lifetime' => 'Seumur Hidup',
            default => 'Belum Ditentukan'
        };
    }

    public function isStockCritical()
    {
        return $this->current_stock <= $this->min_stock;
    }

    public function getStockWarningMessage()
    {
        if ($this->current_stock <= 0) {
            return 'Stok produk habis. Segera lakukan restock.';
        }

        if ($this->isStockCritical()) {
            return 'Stok produk menipis. Stok tersisa: ' . $this->current_stock;
        }

        if ($this->max_stock && $this->current_stock >= $this->max_stock) {
            return 'Stok telah mencapai batas maksimum.';
        }

        return null;
    }

    public function getFormattedFinalPrice()
    {
        return 'Rp' . number_format($this->final_price, 0, ',', '.');
    }

    public function getDiscountAmount()
    {
        if ($this->has_discount) {
            return $this->selling_price - $this->discount_price;
        }
        return 0;
    }

    public function getFormattedDiscountAmount()
    {
        $amount = $this->getDiscountAmount();
        return $amount > 0 ? 'Rp' . number_format($amount, 0, ',', '.') : null;
    }

    public function getMarginAmount()
    {
        return $this->final_price - $this->purchase_price;
    }

    public function getFormattedMarginAmount()
    {
        $amount = $this->getMarginAmount();
        return 'Rp' . number_format($amount, 0, ',', '.');
    }

    protected function averageRating(): Attribute
    {
        return Attribute::make(
            get: function () {
                return round($this->reviews()->avg('rating') ?? 0, 1);
            }
        );
    }

    protected function reviewCount(): Attribute
    {
        return Attribute::make(
            get: fn () => $this->reviews()->count()
        );
    }
}