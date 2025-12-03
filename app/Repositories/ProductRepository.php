<?php

namespace App\Repositories;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;

class ProductRepository implements ProductRepositoryInterface
{
    public function getAll()
    {
        return Product::all();
    }
    
    public function findById($id)
    {
        return Product::find($id);
    }
    
    public function create(array $data)
    {
        return Product::create($data);
    }
    
    public function update($id, array $data)
    {
        $product = Product::find($id);
        if ($product) {
            $product->update($data);
            return $product;
        }
        return null;
    }
    
    public function delete($id)
    {
        return Product::destroy($id);
    }
    
    // Opsional
    public function getWithFilters(array $filters = [])
    {
        $query = Product::query();
        
        if (isset($filters['search'])) {
            $query->where('name', 'like', '%' . $filters['search'] . '%');
        }
        
        // Tambahkan filter lain sesuai kebutuhan
        
        return $query->get();
    }
}