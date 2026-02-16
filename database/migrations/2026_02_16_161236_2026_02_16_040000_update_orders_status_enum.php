<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('orders')) {
            // Perluas ENUM agar mendukung semua status baru:
            DB::statement("
                ALTER TABLE `orders`
                MODIFY `status` ENUM(
                    'pending',
                    'confirmed',
                    'processed',
                    'shipping',
                    'completed',
                    'cancelled'
                ) NOT NULL DEFAULT 'pending'
            ");
        }
    }

    public function down(): void
    {
        if (Schema::hasTable('orders')) {
            // Kembalikan ke enum awal jika perlu rollback
            DB::statement("
                ALTER TABLE `orders`
                MODIFY `status` ENUM(
                    'pending',
                    'confirmed',
                    'processed',
                    'cancelled'
                ) NOT NULL DEFAULT 'pending'
            ");
        }
    }
};