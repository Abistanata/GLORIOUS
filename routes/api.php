<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\CartController;
use App\Http\Controllers\Api\WishlistController;
use App\Http\Controllers\AuthController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::middleware('auth:sanctum')->get('/user', function (Request $request) {
    return $request->user();
});

// ===================================
// CART API ROUTES
// ===================================
Route::middleware(['auth:sanctum'])->prefix('cart')->name('api.cart.')->group(function () {
    Route::get('/', [CartController::class, 'index'])->name('index');
    Route::post('/add', [CartController::class, 'add'])->name('add');
    Route::put('/update/{cart}', [CartController::class, 'update'])->name('update');
    Route::delete('/remove/{cart}', [CartController::class, 'remove'])->name('remove');
    Route::delete('/clear', [CartController::class, 'clear'])->name('clear');
    Route::get('/count', [CartController::class, 'count'])->name('count');
    Route::get('/total', [CartController::class, 'total'])->name('total');
});

// ===================================
// WISHLIST API ROUTES
// ===================================
Route::middleware(['auth:sanctum'])->prefix('wishlist')->name('api.wishlist.')->group(function () {
    Route::get('/', [WishlistController::class, 'index'])->name('index');
    Route::post('/add/{product}', [WishlistController::class, 'add'])->name('add');
    Route::delete('/remove/{product}', [WishlistController::class, 'remove'])->name('remove');
    Route::get('/count', [WishlistController::class, 'count'])->name('count');
    Route::delete('/clear', [WishlistController::class, 'clear'])->name('clear');
    Route::get('/check/{product}', [WishlistController::class, 'check'])->name('check');
});

// ===================================
// AUTH API ROUTES
// ===================================
Route::prefix('auth')->name('api.auth.')->group(function () {
    Route::post('/login', [AuthController::class, 'apiLogin'])->name('login');
    Route::post('/register', [AuthController::class, 'apiRegister'])->name('register');
    Route::post('/logout', [AuthController::class, 'apiLogout'])->middleware('auth:sanctum')->name('logout');
    Route::get('/me', [AuthController::class, 'apiMe'])->middleware('auth:sanctum')->name('me');
    Route::get('/ping', [AuthController::class, 'ping'])->name('ping');
});
