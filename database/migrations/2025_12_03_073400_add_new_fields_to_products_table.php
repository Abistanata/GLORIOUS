<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // 1. Harga Diskon
            if (!Schema::hasColumn('products', 'discount_price')) {
                $table->decimal('discount_price', 12, 2)->nullable()->default(0)->after('selling_price');
            }

            // 2. Informasi Pengiriman
            if (!Schema::hasColumn('products', 'shipping_info')) {
                $table->enum('shipping_info', ['free', 'calculated', 'flat_rate', 'pickup'])
                      ->nullable()
                      ->after('discount_price');
            }

            // 3. Kondisi Produk
            if (!Schema::hasColumn('products', 'condition')) {
                $table->enum('condition', ['new', 'used', 'refurbished'])
                      ->default('new')
                      ->after('shipping_info');
            }

            // 4. Garansi
            if (!Schema::hasColumn('products', 'warranty')) {
                $table->enum('warranty', [
                    'no_warranty', 
                    '1_month', 
                    '3_months', 
                    '6_months', 
                    '1_year', 
                    '2_years', 
                    'lifetime'
                ])->nullable()->after('condition');
            }

            // 5. Stok Maksimum
            if (!Schema::hasColumn('products', 'max_stock')) {
                $table->integer('max_stock')->nullable()->after('min_stock');
            }
        });

        // Tambahkan indeks untuk field yang sering difilter
        Schema::table('products', function (Blueprint $table) {
            $table->index(['condition']);
            $table->index(['shipping_info']);
            $table->index(['warranty']);
            $table->index(['discount_price']);
        });
    }

    public function down(): void
    {
        Schema::table('products', function (Blueprint $table) {
            // Hapus indeks terlebih dahulu
            $table->dropIndex(['condition']);
            $table->dropIndex(['shipping_info']);
            $table->dropIndex(['warranty']);
            $table->dropIndex(['discount_price']);

            // Hapus kolom jika ada
            if (Schema::hasColumn('products', 'max_stock')) {
                $table->dropColumn('max_stock');
            }
            
            if (Schema::hasColumn('products', 'warranty')) {
                $table->dropColumn('warranty');
            }
            
            if (Schema::hasColumn('products', 'condition')) {
                $table->dropColumn('condition');
            }
            
            if (Schema::hasColumn('products', 'shipping_info')) {
                $table->dropColumn('shipping_info');
            }
            
            if (Schema::hasColumn('products', 'discount_price')) {
                $table->dropColumn('discount_price');
            }
        });
    }
};