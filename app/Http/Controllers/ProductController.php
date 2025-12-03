<?php

namespace App\Http\Controllers;

use App\Services\ProductService;
use Illuminate\Http\Request;
use App\Exports\ProductsExport;
use App\Exports\ProductsTemplateExport;

use App\Imports\ProductsImport;
use Maatwebsite\Excel\Facades\Excel;
use Maatwebsite\Excel\Validators\ValidationException;

class ProductController extends Controller
{
    protected ProductService $productService;

    public function __construct(ProductService $productService)
    {
        $this->productService = $productService;
    }

    public function index(Request $request)
    {
        try {
            $products = $this->productService->getAll($request);

            return response()->json([
                'success' => true,
                'message' => 'Data produk berhasil diambil',
                'data' => [
                    'products' => $products->items(),
                    'total_products' => $products->total(),
                    'current_page' => $products->currentPage(),
                    'last_page' => $products->lastPage(),
                    'per_page' => $products->perPage(),
                    'timestamp' => now()->format('Y-m-d H:i:s')
                ],
                'meta' => [
                    'endpoint' => '/api/products',
                    'method' => 'GET',
                    'description' => 'Menampilkan semua data produk',
                    'filters' => [
                        'search' => 'optional: string',
                        'category_id' => 'optional: integer',
                        'condition' => 'optional: new, used, refurbished',
                        'stock_status' => 'optional: in_stock, low_stock, out_of_stock, max_stock',
                        'has_discount' => 'optional: true, false',
                        'sort' => 'optional: name_asc, name_desc, stock_asc, stock_desc, price_asc, price_desc, margin_asc, margin_desc'
                    ]
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data produk',
                'error' => $e->getMessage(),
                'code' => 'FETCH_PRODUCTS_ERROR'
            ], 500);
        }
    }

    public function show($id)
    {
        try {
            $product = $this->productService->findById($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan',
                    'error' => "Produk dengan ID {$id} tidak ada dalam database",
                    'code' => 'PRODUCT_NOT_FOUND'
                ], 404);
            }

            return response()->json([
                'success' => true,
                'message' => 'Detail produk berhasil diambil',
                'data' => [
                    'product' => $product,
                    'calculated_fields' => [
                        'stock_status' => $product->stock_status,
                        'formatted_purchase_price' => $product->formatted_purchase_price,
                        'formatted_selling_price' => $product->formatted_selling_price,
                        'formatted_discount_price' => $product->formatted_discount_price,
                        'has_discount' => $product->has_discount,
                        'discount_percentage' => $product->discount_percentage,
                        'final_price' => $product->final_price,
                        'profit_margin' => $product->profit_margin,
                        'stock_percentage' => $product->stock_percentage,
                        'getStockStatusLabel' => $product->getStockStatusLabel(),
                        'getConditionLabel' => $product->getConditionLabel(),
                        'getShippingInfoLabel' => $product->getShippingInfoLabel(),
                        'getWarrantyLabel' => $product->getWarrantyLabel()
                    ],
                    'retrieved_at' => now()->format('Y-m-d H:i:s')
                ],
                'meta' => [
                    'endpoint' => "/api/products/{$id}",
                    'method' => 'GET',
                    'description' => 'Menampilkan detail produk berdasarkan ID'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil detail produk',
                'error' => $e->getMessage(),
                'code' => 'FETCH_PRODUCT_ERROR'
            ], 500);
        }
    }

    public function store(Request $request)
    {
        try {
            $validated = $request->validate([
                'category_id' => 'required|exists:categories,id',
                'supplier_id' => 'nullable|exists:suppliers,id',
                'name' => 'required|string|max:255',
                'sku' => 'required|string|max:100|unique:products',
                'description' => 'nullable|string',
                'purchase_price' => 'required|numeric|min:0',
                'selling_price' => 'required|numeric|min:0|gte:purchase_price',
                'discount_price' => 'nullable|numeric|min:0|lte:selling_price',
                'current_stock' => 'nullable|integer|min:0',
                'min_stock' => 'required|integer|min:0',
                'max_stock' => 'nullable|integer|min:0',
                'condition' => 'required|in:new,used,refurbished',
                'shipping_info' => 'nullable|in:free,calculated,flat_rate,pickup',
                'warranty' => 'nullable|in:no_warranty,1_month,3_months,6_months,1_year,2_years,lifetime',
                'unit' => 'required|string|max:20',
                'image' => 'nullable|string',
            ]);

            // Validasi stok
            if (isset($validated['max_stock']) && $validated['max_stock'] > 0) {
                if (isset($validated['current_stock']) && $validated['max_stock'] < $validated['current_stock']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validasi gagal',
                        'errors' => [
                            'max_stock' => ['Stok maksimum tidak boleh kurang dari stok terkini']
                        ],
                        'code' => 'VALIDATION_ERROR'
                    ], 422);
                }
                
                if ($validated['max_stock'] < $validated['min_stock']) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validasi gagal',
                        'errors' => [
                            'max_stock' => ['Stok maksimum tidak boleh kurang dari stok minimum']
                        ],
                        'code' => 'VALIDATION_ERROR'
                    ], 422);
                }
            }

            // Set default values
            $validated['current_stock'] = $validated['current_stock'] ?? 0;
            $validated['discount_price'] = $validated['discount_price'] ?? 0;

            $product = $this->productService->create($validated);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil ditambahkan ke sistem!',
                'data' => [
                    'product' => $product,
                    'created_at' => now()->format('Y-m-d H:i:s'),
                    'summary' => [
                        'product_name' => $product->name,
                        'sku' => $product->sku,
                        'category_id' => $validated['category_id'],
                        'supplier_id' => $validated['supplier_id'] ?? null,
                        'purchase_price' => number_format($validated['purchase_price'], 0, ',', '.'),
                        'selling_price' => number_format($validated['selling_price'], 0, ',', '.'),
                        'discount_price' => $validated['discount_price'] > 0 ? number_format($validated['discount_price'], 0, ',', '.') : null,
                        'current_stock' => $validated['current_stock'],
                        'min_stock' => $validated['min_stock'],
                        'max_stock' => $validated['max_stock'] ?? null,
                        'condition' => $product->getConditionLabel(),
                        'profit_margin' => $product->profit_margin . '%'
                    ]
                ],
                'meta' => [
                    'endpoint' => '/api/products',
                    'method' => 'POST',
                    'description' => 'Menambahkan produk baru ke database'
                ]
            ], 201);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang dikirim tidak valid',
                'errors' => $e->errors(),
                'code' => 'VALIDATION_ERROR'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menambahkan produk',
                'error' => $e->getMessage(),
                'code' => 'CREATE_PRODUCT_ERROR'
            ], 500);
        }
    }

    public function update(Request $request, $id)
    {
        try {
            $validated = $request->validate([
                'category_id' => 'sometimes|exists:categories,id',
                'supplier_id' => 'sometimes|exists:suppliers,id',
                'name' => 'sometimes|string|max:255',
                'sku' => 'sometimes|string|max:100|unique:products,sku,' . $id,
                'description' => 'nullable|string',
                'purchase_price' => 'sometimes|numeric|min:0',
                'selling_price' => 'sometimes|numeric|min:0|gte:purchase_price',
                'discount_price' => 'nullable|numeric|min:0|lte:selling_price',
                'current_stock' => 'sometimes|integer|min:0',
                'min_stock' => 'sometimes|integer|min:0',
                'max_stock' => 'nullable|integer|min:0',
                'condition' => 'sometimes|in:new,used,refurbished',
                'shipping_info' => 'nullable|in:free,calculated,flat_rate,pickup',
                'warranty' => 'nullable|in:no_warranty,1_month,3_months,6_months,1_year,2_years,lifetime',
                'unit' => 'sometimes|string|max:20',
                'image' => 'nullable|string',
            ]);

            // Cek apakah produk ada
            $existingProduct = $this->productService->findById($id);
            if (!$existingProduct) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan',
                    'error' => "Produk dengan ID {$id} tidak ada dalam database",
                    'code' => 'PRODUCT_NOT_FOUND'
                ], 404);
            }

            // Validasi stok jika max_stock diupdate
            if (isset($validated['max_stock']) && $validated['max_stock'] > 0) {
                $currentStock = $validated['current_stock'] ?? $existingProduct->current_stock;
                $minStock = $validated['min_stock'] ?? $existingProduct->min_stock;
                
                if ($validated['max_stock'] < $currentStock) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validasi gagal',
                        'errors' => [
                            'max_stock' => ['Stok maksimum tidak boleh kurang dari stok terkini']
                        ],
                        'code' => 'VALIDATION_ERROR'
                    ], 422);
                }
                
                if ($validated['max_stock'] < $minStock) {
                    return response()->json([
                        'success' => false,
                        'message' => 'Validasi gagal',
                        'errors' => [
                            'max_stock' => ['Stok maksimum tidak boleh kurang dari stok minimum']
                        ],
                        'code' => 'VALIDATION_ERROR'
                    ], 422);
                }
            }

            $product = $this->productService->update($id, $validated);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui!',
                'data' => [
                    'product' => $product,
                    'updated_at' => now()->format('Y-m-d H:i:s'),
                    'updated_fields' => array_keys($validated),
                    'total_updated_fields' => count($validated),
                    'summary' => [
                        'stock_status' => $product->getStockStatusLabel(),
                        'has_discount' => $product->has_discount,
                        'discount_percentage' => $product->discount_percentage . '%',
                        'profit_margin' => $product->profit_margin . '%'
                    ]
                ],
                'meta' => [
                    'endpoint' => "/api/products/{$id}",
                    'method' => 'PUT/PATCH',
                    'description' => 'Memperbarui data produk berdasarkan ID'
                ]
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang dikirim tidak valid',
                'errors' => $e->errors(),
                'code' => 'VALIDATION_ERROR'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui produk',
                'error' => $e->getMessage(),
                'code' => 'UPDATE_PRODUCT_ERROR'
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            // Coba ambil data produk dulu untuk konfirmasi
            $product = $this->productService->findById($id);

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Produk tidak ditemukan',
                    'error' => "Produk dengan ID {$id} tidak ada dalam database",
                    'code' => 'PRODUCT_NOT_FOUND'
                ], 404);
            }

            $productName = $product->name;
            $productSku = $product->sku;

            $this->productService->delete($id);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil dihapus dari sistem!',
                'data' => [
                    'deleted_product' => [
                        'id' => $id,
                        'name' => $productName,
                        'sku' => $productSku,
                        'category' => $product->category->name ?? 'Tidak Berkategori',
                        'condition' => $product->getConditionLabel()
                    ],
                    'deleted_at' => now()->format('Y-m-d H:i:s')
                ],
                'meta' => [
                    'endpoint' => "/api/products/{$id}",
                    'method' => 'DELETE',
                    'description' => 'Menghapus produk berdasarkan ID',
                    'warning' => 'Data yang dihapus tidak dapat dikembalikan'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal menghapus produk',
                'error' => $e->getMessage(),
                'code' => 'DELETE_PRODUCT_ERROR'
            ], 500);
        }
    }

    /**
     * Export products to Excel
     */
    public function export(Request $request)
    {
        $fileName = 'products-export-' . date('Ymd-His') . '.xlsx';
        return Excel::download(new ProductsExport($request), $fileName);
    }

    /**
     * Export template for import
     */
    public function exportTemplate()
    {
        $fileName = 'products-template-' . date('Ymd-His') . '.xlsx';
        return Excel::download(new ProductsTemplateExport(), $fileName);
    }

    /**
     * Import products from Excel
     */
    public function import(Request $request)
    {
        $request->validate([
            'file' => 'required|file|mimes:xlsx,xls|max:5120', // 5MB max
        ]);

        try {
            $import = new ProductsImport();
            Excel::import($import, $request->file('file'));

            $rowCount = $import->getRowCount();
            $errors = $import->getErrors();

            if (!empty($errors)) {
                return response()->json([
                    'success' => true,
                    'message' => "Berhasil mengimpor {$rowCount} produk, dengan beberapa error.",
                    'data' => [
                        'imported_count' => $rowCount,
                        'errors' => $errors,
                        'imported_at' => now()->format('Y-m-d H:i:s')
                    ],
                    'meta' => [
                        'endpoint' => '/api/products/import',
                        'method' => 'POST',
                        'description' => 'Mengimpor produk dari file Excel'
                    ]
                ], 200);
            }

            return response()->json([
                'success' => true,
                'message' => "Berhasil mengimpor {$rowCount} produk.",
                'data' => [
                    'imported_count' => $rowCount,
                    'imported_at' => now()->format('Y-m-d H:i:s')
                ],
                'meta' => [
                    'endpoint' => '/api/products/import',
                    'method' => 'POST',
                    'description' => 'Mengimpor produk dari file Excel'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengimpor produk',
                'error' => $e->getMessage(),
                'code' => 'IMPORT_PRODUCT_ERROR'
            ], 500);
        }
    }

    /**
     * Bulk update products
     */
    public function bulkUpdate(Request $request)
    {
        try {
            $validated = $request->validate([
                'product_ids' => 'required|array',
                'product_ids.*' => 'exists:products,id',
                'discount_price' => 'nullable|numeric|min:0',
                'discount_percentage' => 'nullable|numeric|min:0|max:100',
                'condition' => 'nullable|in:new,used,refurbished',
                'shipping_info' => 'nullable|in:free,calculated,flat_rate,pickup',
                'warranty' => 'nullable|in:no_warranty,1_month,3_months,6_months,1_year,2_years,lifetime',
            ]);

            $updatedProducts = $this->productService->bulkUpdate(
    $request->input('product_ids', []),
    $request->input('updates', [])
);

            return response()->json([
                'success' => true,
                'message' => 'Produk berhasil diperbarui secara massal',
                'data' => [
                    'updated_count' => $updatedProducts,
                    'updated_ids' => $validated['product_ids'],
                    'updated_fields' => array_keys(array_filter($validated, function($key) {
                        return !in_array($key, ['product_ids']);
                    }, ARRAY_FILTER_USE_KEY)),
                    'updated_at' => now()->format('Y-m-d H:i:s')
                ],
                'meta' => [
                    'endpoint' => '/api/products/bulk-update',
                    'method' => 'POST',
                    'description' => 'Memperbarui beberapa produk sekaligus'
                ]
            ], 200);

        } catch (\Illuminate\Validation\ValidationException $e) {
            return response()->json([
                'success' => false,
                'message' => 'Data yang dikirim tidak valid',
                'errors' => $e->errors(),
                'code' => 'VALIDATION_ERROR'
            ], 422);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal memperbarui produk',
                'error' => $e->getMessage(),
                'code' => 'BULK_UPDATE_ERROR'
            ], 500);
        }
    }

    /**
     * Get products by condition
     */
    public function byCondition($condition)
    {
        try {
            $validConditions = ['new', 'used', 'refurbished'];
            
            if (!in_array($condition, $validConditions)) {
                return response()->json([
                    'success' => false,
                    'message' => 'Kondisi tidak valid',
                    'error' => "Kondisi harus salah satu dari: " . implode(', ', $validConditions),
                    'code' => 'INVALID_CONDITION'
                ], 400);
            }

            $products = $this->productService->getByCondition($condition);

            return response()->json([
                'success' => true,
                'message' => 'Data produk berdasarkan kondisi berhasil diambil',
                'data' => [
                    'products' => $products,
                    'condition' => $condition,
                    'condition_label' => $this->productService->getConditionLabel($condition),
                    'total_products' => count($products),
                    'timestamp' => now()->format('Y-m-d H:i:s')
                ],
                'meta' => [
                    'endpoint' => "/api/products/condition/{$condition}",
                    'method' => 'GET',
                    'description' => 'Menampilkan produk berdasarkan kondisi'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data produk berdasarkan kondisi',
                'error' => $e->getMessage(),
                'code' => 'FETCH_PRODUCTS_BY_CONDITION_ERROR'
            ], 500);
        }
    }

    /**
     * Get products with discount
     */
    public function withDiscount()
    {
        try {
            $products = $this->productService->getWithDiscount();

            return response()->json([
                'success' => true,
                'message' => 'Data produk dengan diskon berhasil diambil',
                'data' => [
                    'products' => $products,
                    'total_products' => count($products),
                    'timestamp' => now()->format('Y-m-d H:i:s')
                ],
                'meta' => [
                    'endpoint' => '/api/products/with-discount',
                    'method' => 'GET',
                    'description' => 'Menampilkan produk yang memiliki diskon'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data produk dengan diskon',
                'error' => $e->getMessage(),
                'code' => 'FETCH_PRODUCTS_WITH_DISCOUNT_ERROR'
            ], 500);
        }
    }

    /**
     * Get low stock products
     */
    public function lowStock()
    {
        try {
            $products = $this->productService->getLowStock();

            return response()->json([
                'success' => true,
                'message' => 'Data produk dengan stok rendah berhasil diambil',
                'data' => [
                    'products' => $products,
                    'total_products' => count($products),
                    'timestamp' => now()->format('Y-m-d H:i:s')
                ],
                'meta' => [
                    'endpoint' => '/api/products/low-stock',
                    'method' => 'GET',
                    'description' => 'Menampilkan produk dengan stok rendah'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data produk dengan stok rendah',
                'error' => $e->getMessage(),
                'code' => 'FETCH_LOW_STOCK_PRODUCTS_ERROR'
            ], 500);
        }
    }

    /**
     * Get products at max stock
     */
    public function maxStock()
    {
        try {
            $products = $this->productService->getMaxStock();

            return response()->json([
                'success' => true,
                'message' => 'Data produk dengan stok maksimum berhasil diambil',
                'data' => [
                    'products' => $products,
                    'total_products' => count($products),
                    'timestamp' => now()->format('Y-m-d H:i:s')
                ],
                'meta' => [
                    'endpoint' => '/api/products/max-stock',
                    'method' => 'GET',
                    'description' => 'Menampilkan produk yang mencapai stok maksimum'
                ]
            ], 200);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal mengambil data produk dengan stok maksimum',
                'error' => $e->getMessage(),
                'code' => 'FETCH_MAX_STOCK_PRODUCTS_ERROR'
            ], 500);
        }
    }
}