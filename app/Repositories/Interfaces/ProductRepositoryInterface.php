<?php

namespace App\Repositories\Interfaces;

interface ProductRepositoryInterface
{
    public function getAll();
    public function findById($id); // Tambahkan ini
    public function create(array $data);
    public function update($id, array $data);
    public function delete($id);
    
    // Opsional: tambahkan method filter jika perlu
    public function getWithFilters(array $filters = []);
}