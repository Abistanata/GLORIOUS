<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Product;

class ProductSeeder extends Seeder
{
    public function run(): void
    {
        Product::create([
            'name'           => 'Laptop Pro 14 inch',
            'sku'            => 'LP-14-2024',
            'category_id'    => 1, // Laptop
            'supplier_id'    => 1,
            'unit'           => 'pcs',
            'purchase_price' => 15000000,
            'selling_price'  => 17500000,
            'current_stock'  => 10,
            'min_stock'      => 5,
        ]);

        Product::create([
            'name'           => 'Printer Jet 2000',
            'sku'            => 'PR-2000',
            'category_id'    => 2, // Printer
            'supplier_id'    => 1,
            'unit'           => 'pcs',
            'purchase_price' => 2000000,
            'selling_price'  => 2500000,
            'current_stock'  => 15,
            'min_stock'      => 3,
        ]);

        Product::create([
            'name'           => 'PC Gaming Ultimate',
            'sku'            => 'PC-ULT-2024',
            'category_id'    => 3, // Komputer
            'supplier_id'    => 2,
            'unit'           => 'pcs',
            'purchase_price' => 12000000,
            'selling_price'  => 15000000,
            'current_stock'  => 5,
            'min_stock'      => 2,
        ]);

        Product::create([
            'name'           => 'Keyboard Mechanical RGB',
            'sku'            => 'KB-RGB-2024',
            'category_id'    => 4, // Lainnya
            'supplier_id'    => 2,
            'unit'           => 'pcs',
            'purchase_price' => 800000,
            'selling_price'  => 1200000,
            'current_stock'  => 20,
            'min_stock'      => 5,
        ]);
    }
}
