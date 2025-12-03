<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use App\Models\Product;
use App\Models\StockTransaction;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== TESTING STOCK SYNCHRONIZATION ===\n\n";

// Test 1: Check stock calculation from transactions
echo "1. Testing Stock Calculation from Transactions:\n";
$products = Product::with(['stockTransactions'])->take(3)->get();

foreach ($products as $product) {
    // Calculate current stock from transactions
    $calculatedStock = $product->stockTransactions()
        ->selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
        ->value('stock') ?? 0;

    echo "Product: {$product->name}\n";
    echo "  Calculated Stock from Transactions: {$calculatedStock}\n";
    echo "  Stock from current_stock field: {$product->current_stock}\n";
    echo "  Match: " . ($calculatedStock == $product->current_stock ? "YES" : "NO - ISSUE DETECTED!") . "\n";
    echo "\n";
}

// Test 2: Check total stock calculation
echo "2. Testing Total Stock Calculation:\n";
$totalStockFromField = Product::sum('current_stock');
$totalStockFromTransactions = StockTransaction::selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as total_stock')
    ->value('total_stock') ?? 0;

echo "Total Stock from current_stock field: {$totalStockFromField}\n";
echo "Total Stock from transactions: {$totalStockFromTransactions}\n";
echo "Match: " . ($totalStockFromField == $totalStockFromTransactions ? "YES" : "NO - ISSUE DETECTED!") . "\n\n";

// Test 3: Simulate stock transaction and verify sync
echo "3. Testing Stock Transaction Simulation:\n";
$testProduct = Product::first();
if ($testProduct) {
    echo "Testing with product: {$testProduct->name}\n";

    // Get stock before transaction
    $stockBefore = $testProduct->stockTransactions()
        ->selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
        ->value('stock') ?? 0;

    echo "Stock before transaction: {$stockBefore}\n";

    // Create a test transaction (add 5 items)
    StockTransaction::create([
        'product_id' => $testProduct->id,
        'user_id' => 1, // Use first user (admin)
        'type' => 'Masuk',
        'quantity' => 5,
        'date' => now()->toDateString(),
        'notes' => 'Test transaction for stock sync verification',
    ]);

    // Get stock after transaction
    $stockAfter = $testProduct->stockTransactions()
        ->selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as stock')
        ->value('stock') ?? 0;

    echo "Stock after adding 5 items: {$stockAfter}\n";
    echo "Stock increase: " . ($stockAfter - $stockBefore) . " (should be 5)\n";
    echo "Sync working: " . (($stockAfter - $stockBefore) == 5 ? "YES" : "NO - ISSUE DETECTED!") . "\n";

    // Clean up test transaction
    StockTransaction::where('notes', 'Test transaction for stock sync verification')->delete();
    echo "Test transaction cleaned up.\n";
} else {
    echo "No products found for testing.\n";
}

echo "\n=== TEST COMPLETED ===\n";

?>
