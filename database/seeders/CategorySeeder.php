<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Category;

use Illuminate\Support\Facades\DB;

class CategorySeeder extends Seeder
{
    public function run(): void
    {
        DB::table('categories')->delete(); // hapus semua isi tanpa truncate

        Category::create(['name' => 'Laptop', 'description' => 'Kategori untuk produk laptop']);
        Category::create(['name' => 'Printer', 'description' => 'Kategori untuk produk printer']);
        Category::create(['name' => 'Komputer', 'description' => 'Kategori untuk produk komputer']);
        Category::create(['name' => 'Lainnya', 'description' => 'Kategori untuk produk lainnya']);
    }
}
