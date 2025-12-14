<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\CategoryController;
use App\Http\Controllers\SupplierController;
use App\Http\Controllers\UserManagementController;
use App\Http\Controllers\ProductAttributeController;
use App\Http\Controllers\StockTransactionController;


/*
|--------------------------------------------------------------------------
| API Routes - For Mobile Apps, External Clients (Sanctum)
|--------------------------------------------------------------------------
*/

Route::prefix('auth')->group(function () {
    // API Login dengan Sanctum
    Route::post('login', [AuthController::class, 'apiLogin'])->name('api.auth.login');
    Route::post('register', [AuthController::class, 'apiRegister'])->name('api.auth.register');
    Route::post('logout', [AuthController::class, 'apiLogout'])->middleware('auth:sanctum');
    Route::get('me', [AuthController::class, 'apiMe'])->middleware('auth:sanctum');
});

// ================================
// PROTECTED ROUTES (Requires Authentication)
// ================================
Route::middleware('auth:sanctum')->group(function () {

    // Profile - All authenticated users
    Route::get('profile', [ProfileController::class, 'me']);

    // ================================
    // CUSTOMER ROUTES
    // ================================
    Route::prefix('customer')->middleware('role:customer')->group(function () {
        Route::get('profile', [AuthController::class, 'customerProfile']);
        Route::put('profile', [AuthController::class, 'updateCustomerProfile']);
        Route::get('orders', [AuthController::class, 'customerOrders']);
        Route::get('wishlist', [AuthController::class, 'customerWishlist']);
    });

    // ================================
    // ADMIN ONLY ROUTES
    // ================================
    Route::prefix('admin')->middleware('role:Admin')->group(function () {

        // Full CRUD for all resources
        Route::apiResource('categories', CategoryController::class);
        Route::apiResource('suppliers', SupplierController::class);
        Route::apiResource('products', ProductController::class);
        Route::apiResource('product_attributes', ProductAttributeController::class);
        Route::apiResource('stock-transactions', StockTransactionController::class);

        // Stock operations
        Route::get('stock-transactions/type/{type}', [StockTransactionController::class, 'filterByType']);
        Route::patch('stock-transactions/{id}/approve', [StockTransactionController::class, 'approve']);
        Route::post('stock-transactions/{id}/confirm', [StockTransactionController::class, 'confirm']);

        // Stock views
        Route::get('stock/in', [StockTransactionController::class, 'in']);
        Route::get('stock/out', [StockTransactionController::class, 'out']);
        Route::get('stock/opname', [StockTransactionController::class, 'opname']);

        // Dashboard & Reports
        Route::get('dashboard-summary', [StockTransactionController::class, 'dashboardSummary']);
        Route::post('reports/stock', [StockTransactionController::class, 'reportStock']);
        Route::post('reports/transactions', [StockTransactionController::class, 'reportTransactions']);

        // User Management
        Route::prefix('users')->group(function () {
            Route::get('/', [UserManagementController::class, 'index']);
            Route::get('/statistics', [UserManagementController::class, 'statistics']);
            Route::get('/{id}', [UserManagementController::class, 'show']);
            Route::put('/{id}/role', [UserManagementController::class, 'updateRole']);
            Route::put('/{id}/info', [UserManagementController::class, 'updateInfo']);
            Route::delete('/{id}', [UserManagementController::class, 'destroy']);
        });
    });

    // ================================
    // MANAJER GUDANG ROUTES
    // ================================
    Route::prefix('manager')->middleware('role:Manajer Gudang')->group(function () {

        // Dashboard
        Route::get('dashboard-summary', [StockTransactionController::class, 'dashboardSummary']);

        // Products - Read + Create new products from incoming goods
        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/{id}', [ProductController::class, 'show']);
        Route::post('products', [ProductController::class, 'store']);

        // Categories - Read Only
        Route::get('categories', [CategoryController::class, 'index']);
        Route::get('categories/{id}', [CategoryController::class, 'show']);

        // Suppliers - Read Only
        Route::get('suppliers', [SupplierController::class, 'index']);
        Route::get('suppliers/{id}', [SupplierController::class, 'show']);

        // Stock Management - Full CRUD (main responsibility)
        Route::apiResource('stock-transactions', StockTransactionController::class);
        Route::get('stock-transactions/type/{type}', [StockTransactionController::class, 'filterByType']);
        Route::patch('stock-transactions/{id}/approve', [StockTransactionController::class, 'approve']);
        Route::post('stock-transactions/{id}/confirm', [StockTransactionController::class, 'confirm']);

        // Stock views
        Route::get('stock/in', [StockTransactionController::class, 'in']);
        Route::get('stock/out', [StockTransactionController::class, 'out']);
        Route::get('stock/opname', [StockTransactionController::class, 'opname']);

        // Reports
        Route::post('reports/stock', [StockTransactionController::class, 'reportStock']);
        Route::post('reports/transactions', [StockTransactionController::class, 'reportTransactions']);
    });

    // ================================
    // STAFF GUDANG ROUTES
    // ================================
    Route::prefix('staff')->middleware('role:Staff Gudang')->group(function () {

        // Products - Read Only (for operational reference)
        Route::get('products', [ProductController::class, 'index']);
        Route::get('products/{id}', [ProductController::class, 'show']);

        // Categories - Read Only (for reference)
        Route::get('categories', [CategoryController::class, 'index']);
        Route::get('categories/{id}', [CategoryController::class, 'show']);

        // Suppliers - Read Only (for reference)
        Route::get('suppliers', [SupplierController::class, 'index']);
        Route::get('suppliers/{id}', [SupplierController::class, 'show']);

        // Stock Transactions - Limited operations
        Route::get('stock-transactions', [StockTransactionController::class, 'index']);
        Route::get('stock-transactions/{id}', [StockTransactionController::class, 'show']);
        Route::post('stock-transactions', [StockTransactionController::class, 'store']); // Create for receiving/sending

        // Stock operations - Operational level
        Route::get('stock/in', [StockTransactionController::class, 'in']);
        Route::get('stock/out', [StockTransactionController::class, 'out']);
        Route::get('stock/opname', [StockTransactionController::class, 'opname']);
        Route::post('stock-transactions/{id}/confirm', [StockTransactionController::class, 'confirm']);
    });


});