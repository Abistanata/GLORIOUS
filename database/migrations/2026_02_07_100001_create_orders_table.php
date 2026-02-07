<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            Schema::create('orders', function (Blueprint $table) {
                $table->id();
                $table->foreignId('user_id')->constrained('users')->onDelete('cascade');
                $table->string('order_number')->unique()->nullable();
                $table->enum('status', ['pending', 'confirmed', 'processed', 'cancelled'])->default('pending');
                $table->decimal('total', 14, 2)->default(0);
                $table->string('customer_name')->nullable();
                $table->string('customer_phone')->nullable();
                $table->text('notes')->nullable();
                $table->timestamp('confirmed_at')->nullable();
                $table->timestamps();
            });
        }

        if (!Schema::hasTable('order_items')) {
            Schema::create('order_items', function (Blueprint $table) {
                $table->id();
                $table->foreignId('order_id')->constrained('orders')->onDelete('cascade');
                $table->foreignId('product_id')->constrained('products')->onDelete('cascade');
                $table->unsignedInteger('quantity')->default(1);
                $table->decimal('unit_price', 12, 2)->default(0);
                $table->decimal('subtotal', 14, 2)->default(0);
                $table->timestamps();
            });
        }
    }

    public function down(): void
    {
        Schema::dropIfExists('order_items');
        Schema::dropIfExists('orders');
    }
};
