<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->string('username')->nullable()->unique()->after('email');
            $table->string('phone')->nullable()->after('name');
            $table->string('whatsapp')->nullable()->after('phone');
        });

        // Ubah enum role agar bisa 'Customer' (MySQL only; SQLite pakai string)
        $driver = Schema::getConnection()->getDriverName();
        if ($driver === 'mysql') {
            \DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Staff Gudang', 'Manajer Gudang', 'Customer') DEFAULT 'Customer'");
        }
    }

    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn(['username', 'phone', 'whatsapp']);
        });
        if (Schema::getConnection()->getDriverName() === 'mysql') {
            \DB::statement("ALTER TABLE users MODIFY COLUMN role ENUM('Admin', 'Staff Gudang', 'Manajer Gudang') DEFAULT 'Staff Gudang'");
        }
    }
};
