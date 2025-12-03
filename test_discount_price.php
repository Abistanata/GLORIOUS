<?php

require_once 'vendor/autoload.php';

use Illuminate\Foundation\Application;
use Illuminate\Contracts\Console\Kernel;
use App\Models\Product;

$app = require_once 'bootstrap/app.php';
$app->make(Kernel::class)->bootstrap();

echo "=== TESTING DISCOUNT PRICE FUNCTIONALITY ===\n\n";

// Test 1: Check if discount_price column exists
echo "1. Checking Database Schema:\n";
try {
    $product = Product::first();
    if ($product) {
        echo "Product found: {$product->name}\n";
        echo "Has discount_price attribute: " . (isset($product->discount_price) ? "YES" : "NO") . "\n";
        echo "Current discount_price value: " . ($product->discount_price ?? 'NULL') . "\n";
        echo "Has is_on_sale attribute: " . (isset($product->is_on_sale) ? "YES" : "NO") . "\n";
        echo "Current is_on_sale value: " . ($product->is_on_sale ? 'TRUE' : 'FALSE') . "\n";
    } else {
        echo "No products found in database.\n";
    }
} catch (\Exception $e) {
    echo "Error checking schema: " . $e->getMessage() . "\n";
}

echo "\n";

// Test 2: Test updating discount price
echo "2. Testing Discount Price Update:\n";
if ($product) {
    $originalDiscount = $product->discount_price;
    $originalSaleStatus = $product->is_on_sale;

    echo "Original discount_price: " . ($originalDiscount ?? 'NULL') . "\n";
    echo "Original is_on_sale: " . ($originalSaleStatus ? 'TRUE' : 'FALSE') . "\n";

    // Test setting discount price
    $testDiscount = 50000; // Set discount to 50,000
    $product->update([
        'discount_price' => $testDiscount,
        'is_on_sale' => true
    ]);

    // Refresh from database
    $product->refresh();

    echo "After update - discount_price: " . ($product->discount_price ?? 'NULL') . "\n";
    echo "After update - is_on_sale: " . ($product->is_on_sale ? 'TRUE' : 'FALSE') . "\n";
    echo "Update successful: " . (($product->discount_price == $testDiscount && $product->is_on_sale) ? "YES" : "NO") . "\n";

    // Restore original values
    $product->update([
        'discount_price' => $originalDiscount,
        'is_on_sale' => $originalSaleStatus
    ]);

    echo "Restored original values.\n";
} else {
    echo "Cannot test update - no products found.\n";
}

echo "\n";

// Test 3: Check form population logic
echo "3. Testing Form Population Logic:\n";
if ($product) {
    // Simulate what happens in the edit form
    $oldDiscount = old('discount_price', $product->discount_price);
    $formattedDiscount = $product->discount_price ? number_format($product->discount_price, 0, ',', '.') : '';

    echo "Product discount_price from model: " . ($product->discount_price ?? 'NULL') . "\n";
    echo "Formatted for form input: '{$formattedDiscount}'\n";
    echo "old() helper simulation: " . ($oldDiscount ?? 'NULL') . "\n";

    // Test the condition used in the view
    $hasDiscount = $product->discount_price > 0;
    echo "Should show discount info: " . ($hasDiscount ? "YES" : "NO") . "\n";

    if ($hasDiscount) {
        $discountPercent = number_format((($product->selling_price - $product->discount_price) / $product->selling_price) * 100, 2);
        $discountAmount = number_format($product->selling_price - $product->discount_price, 0, ',', '.');

        echo "Calculated discount percentage: {$discountPercent}%\n";
        echo "Calculated discount amount: Rp{$discountAmount}\n";
    }
} else {
    echo "Cannot test form logic - no products found.\n";
}

echo "\n";

// Test 4: Check if discount_price is in fillable array
echo "4. Checking Model Configuration:\n";
$productInstance = new Product();
$fillable = $productInstance->getFillable();
echo "discount_price in fillable: " . (in_array('discount_price', $fillable) ? "YES" : "NO") . "\n";
echo "is_on_sale in fillable: " . (in_array('is_on_sale', $fillable) ? "YES" : "NO") . "\n";

$casts = $productInstance->getCasts();
echo "discount_price cast: " . ($casts['discount_price'] ?? 'NOT SET') . "\n";
echo "is_on_sale cast: " . ($casts['is_on_sale'] ?? 'NOT SET') . "\n";

// Check if attributes exist using array access
echo "Has discount_price via array access: " . (array_key_exists('discount_price', $product->getAttributes()) ? "YES" : "NO") . "\n";
echo "Has is_on_sale via array access: " . (array_key_exists('is_on_sale', $product->getAttributes()) ? "YES" : "NO") . "\n";

echo "\n=== TEST COMPLETED ===\n";

?>
