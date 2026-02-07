<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('carts', function (Blueprint $table) {
            if (!Schema::hasColumn('carts', 'user_id')) {
                $table->foreignId('user_id')->after('id')->constrained('users')->onDelete('cascade');
            }
            if (!Schema::hasColumn('carts', 'product_id')) {
                $table->foreignId('product_id')->after('user_id')->constrained('products')->onDelete('cascade');
            }
            if (!Schema::hasColumn('carts', 'quantity')) {
                $table->unsignedInteger('quantity')->default(1)->after('product_id');
            }
        });

        // Unique constraint: satu user hanya satu baris per product (bisa update qty)
        if (Schema::hasColumn('carts', 'user_id') && Schema::hasColumn('carts', 'product_id')) {
            try {
                Schema::table('carts', function (Blueprint $table) {
                    $table->unique(['user_id', 'product_id']);
                });
            } catch (\Throwable $e) {
                // Unique mungkin sudah ada
            }
        }
    }

    public function down(): void
    {
        if (!Schema::hasColumn('carts', 'user_id')) {
            return;
        }
        Schema::table('carts', function (Blueprint $table) {
            try {
                $table->dropUnique(['user_id', 'product_id']);
            } catch (\Throwable $e) {}
            $table->dropForeign(['user_id']);
            $table->dropForeign(['product_id']);
            $table->dropColumn(['user_id', 'product_id', 'quantity']);
        });
    }
};
