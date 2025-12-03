<?php

namespace App\Imports;

use App\Models\Product;
use Maatwebsite\Excel\Concerns\ToModel;
use Maatwebsite\Excel\Concerns\WithHeadingRow;

class ProductsImport implements ToModel, WithHeadingRow
{
    public function model(array $row)
    {
        return new Product([
            'name'        => $row['name'],
            'description' => $row['description'] ?? null,
            'price'       => $row['price'],
            'stock'       => $row['stock'] ?? 0,
            'condition'   => $row['condition'] ?? 'new',
            'discount'    => $row['discount'] ?? 0,
            // tambahkan field lain sesuai kebutuhan
        ]);
    }
}