<?php

namespace App\Services;

use App\Models\Product;
use App\Repositories\Interfaces\ProductRepositoryInterface;
use Illuminate\Http\Request;

class ProductService
{
    protected ProductRepositoryInterface $productRepo;

    public function __construct(ProductRepositoryInterface $productRepo)
    {
        $this->productRepo = $productRepo;
    }
public function getAll(Request $request = null)
{
    // Jika menggunakan repository tanpa filter khusus
    return $this->productRepo->getAll();
    
    // ATAU jika ingin filter langsung:
    if ($request && ($request->has('search') || $request->has('category'))) {
        // Implement filter manual
        $query = Product::query();
        
        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }
        
        if ($request->has('category')) {
            $query->where('category_id', $request->category);
        }
        
        return $query->get();
    }
    
    return $this->productRepo->getAll();
}

    public function findById($id)
{
    // Ganti dengan method yang ada di repository
    // Biasanya repository punya method find() atau findById()
    return $this->productRepo->findById($id); // atau $this->productRepo->getById($id)
}

    public function create(array $data)
    {
        return $this->productRepo->create($data);
    }

    public function update($id, array $data)
    {
        return $this->productRepo->update($id, $data);
    }

    public function delete($id)
    {
        return $this->productRepo->delete($id);
    }

    // ===== METHOD BARU UNTUK MEMENUHI ERROR DI CONTROLLER =====

    public function bulkUpdate(array $productIds, array $updates)
{
    // Parameter 1: array ID produk
    // Parameter 2: array data untuk diupdate
    return Product::whereIn('id', $productIds)->update($updates);
}
    public function getByCondition($condition)
    {
        // Ambil produk berdasarkan kondisi tertentu
        // $condition bisa berupa: 'new', 'used', 'refurbished', dll.
        return Product::where('condition', $condition)->get();
    }

    public function getConditionLabel($condition)
    {
        // Kembalikan label untuk kondisi produk
        $labels = [
            'new' => 'Baru',
            'used' => 'Bekas',
            'refurbished' => 'Rekondisi',
        ];
        
        return $labels[$condition] ?? 'Tidak Diketahui';
    }

    public function getWithDiscount()
    {
        // Ambil produk yang memiliki diskon (diskon > 0)
        return Product::where('discount', '>', 0)->get();
    }

    public function getLowStock($threshold = 10)
    {
        // Ambil produk dengan stok rendah (kurang dari threshold)
        return Product::where('stock', '<=', $threshold)->get();
    }

    public function getMaxStock($threshold = 100)
    {
        // Ambil produk dengan stok tinggi (lebih dari threshold)
        return Product::where('stock', '>=', $threshold)->get();
    }

    // ===== METHOD TAMBAHAN YANG MUNGKIN DIPERLUKAN =====

    public function search($keyword)
    {
        return Product::where('name', 'like', "%{$keyword}%")
            ->orWhere('description', 'like', "%{$keyword}%")
            ->get();
    }

    public function getPaginated($perPage = 15)
    {
        return Product::paginate($perPage);
    }

    public function updateStock($id, $quantity, $operation = 'increase')
    {
        $product = $this->findById($id);
        
        if (!$product) {
            return null;
        }

        if ($operation === 'increase') {
            $product->stock += $quantity;
        } elseif ($operation === 'decrease') {
            $product->stock = max(0, $product->stock - $quantity);
        } elseif ($operation === 'set') {
            $product->stock = $quantity;
        }

        $product->save();
        return $product;
    }
}