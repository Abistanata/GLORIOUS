<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    public function index()
    {
        $items = Cart::where('user_id', Auth::id())
            ->with('product.category')
            ->get();

        foreach ($items as $item) {
            $item->product->current_stock = $this->productStock($item->product_id);
        }

        $subtotal = $items->sum(fn ($i) => $i->qty * $this->linePrice($i->product));
        $cartCount = $items->sum('qty');

        return view('main.cart.index', [
            'items' => $items,
            'subtotal' => $subtotal,
            'cartCount' => $cartCount,
        ]);
    }

    public function add(Request $request, $productId)
    {
        $request->validate(['qty' => 'nullable|integer|min:1|max:999']);
        $qty = (int) ($request->input('qty') ?? 1);

        $product = Product::findOrFail($productId);
        $stock = $this->productStock($product->id);
        if ($stock < 1) {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Stok tidak tersedia.'], 422);
            }
            return back()->with('error', 'Stok tidak tersedia.');
        }
        if ($qty > $stock) {
            $qty = $stock;
        }

        $cart = Cart::firstOrCreate(
            ['user_id' => Auth::id(), 'product_id' => $product->id],
            ['qty' => 0]
        );
        $cart->qty = min($cart->qty + $qty, $stock);
        $cart->save();

        $message = 'Produk ditambahkan ke keranjang.';
        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => $message,
                'cart_count' => $this->cartCount(),
            ]);
        }
        return back()->with('success', $message);
    }

    public function update(Request $request, $productId)
    {
        $request->validate(['qty' => 'required|integer|min:0|max:999']);
        $qty = (int) $request->input('qty');

        $cart = Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->firstOrFail();

        if ($qty <= 0) {
            $cart->delete();
            if ($request->expectsJson()) {
                return response()->json(['success' => true, 'message' => 'Item dihapus.', 'cart_count' => $this->cartCount()]);
            }
            return back()->with('success', 'Item dihapus dari keranjang.');
        }

        $stock = $this->productStock($cart->product_id);
        $cart->qty = min($qty, $stock);
        $cart->save();

        if ($request->expectsJson()) {
            return response()->json(['success' => true, 'cart_count' => $this->cartCount()]);
        }
        return back()->with('success', 'Keranjang diperbarui.');
    }

    public function remove($productId)
    {
        Cart::where('user_id', Auth::id())
            ->where('product_id', $productId)
            ->delete();

        if (request()->expectsJson()) {
            return response()->json(['success' => true, 'cart_count' => $this->cartCount()]);
        }
        return back()->with('success', 'Item dihapus dari keranjang.');
    }

    public function count()
    {
        return response()->json(['count' => $this->cartCount()]);
    }

    private function cartCount(): int
    {
        return (int) Cart::where('user_id', Auth::id())->sum('qty');
    }

    private function productStock(int $productId): int
    {
        return (int) StockTransaction::where('product_id', $productId)
            ->selectRaw('COALESCE(SUM(CASE WHEN type = "Masuk" THEN quantity ELSE -quantity END), 0) as s')
            ->value('s');
    }

    private function linePrice(Product $product): float
    {
        $price = $product->selling_price ?? 0;
        if ($product->discount_price > 0 && $product->discount_price < $price) {
            $price = $product->discount_price;
        }
        return (float) $price;
    }
}
