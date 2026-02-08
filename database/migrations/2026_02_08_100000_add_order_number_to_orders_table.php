<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (!Schema::hasTable('orders')) {
            return;
        }

        Schema::table('orders', function (Blueprint $table) {
            if (!Schema::hasColumn('orders', 'order_number')) {
                $table->string('order_number')->unique()->nullable()->after('user_id');
            }
        });

        // Isi order_number untuk baris yang masih null (jika ada)
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            \Illuminate\Support\Facades\DB::statement(
                "UPDATE orders SET order_number = CONCAT('GC-', id, '-', DATE_FORMAT(created_at, '%Y%m%d')) WHERE order_number IS NULL OR order_number = ''"
            );
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('orders', 'order_number')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropUnique(['order_number']);
                $table->dropColumn('order_number');
            });
        }
    }
};
