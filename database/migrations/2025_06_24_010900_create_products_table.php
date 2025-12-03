<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->nullable()->constrained('categories')->onDelete('set null');
            $table->foreignId('supplier_id')->nullable()->constrained('suppliers')->onDelete('set null');
            $table->string('name');
            $table->string('sku')->unique();
            $table->text('description')->nullable();
            
            // HARGA - PERBAIKAN
            $table->decimal('purchase_price', 12, 2)->default(0); // Harga beli
            $table->decimal('original_price', 12, 2)->default(0); // Harga normal/asli
            $table->decimal('discount_price', 12, 2)->nullable()->default(0); // Harga diskon - DIPERBAIKI
            $table->decimal('selling_price', 12, 2)->default(0); // Harga jual (harga aktif)
            
            // STATUS DISKON - FIELD BARU
            $table->boolean('is_on_sale')->default(false); // Status diskon aktif/tidak
            
            $table->string('image')->nullable();
            
            // STOK - PERBAIKAN (current_stock sebaiknya dihitung dari stock_transactions)
            $table->integer('current_stock')->default(0);
            
            $table->text('specification')->nullable();
            $table->integer('min_stock')->default(0);
            $table->string('unit')->default('pcs');
            
            // FIELD TAMBAHAN YANG DIBUTUHKAN
            $table->decimal('weight', 8, 2)->nullable()->default(0); // Berat produk
            $table->string('dimensions')->nullable(); // Dimensi produk
            $table->boolean('is_active')->default(true); // Status aktif/tidak aktif produk
            
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};