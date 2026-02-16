<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasTable('orders')) {
            Schema::table('orders', function (Blueprint $table): void {
                // Struktur tabel tetap, hanya makna/daftar status yang diperluas secara aplikasi:
                // menunggu, dikonfirmasi, diproses, pengiriman, selesai, dibatalkan
                // Tidak perlu perubahan skema fisik (enum) karena kolom 'status' sudah string.
            });
        }
    }

    public function down(): void
    {
        // Tidak ada perubahan skema fisik yang perlu di-rollback
    }
};

