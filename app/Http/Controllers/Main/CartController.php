<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CartController extends Controller
{
    /**
     * Cart index - hanya untuk customer yang login.
     */
    public function index(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'Customer') {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Silakan login sebagai customer.'], 403);
            }
            return redirect()->route('main.dashboard.index')->with('error', 'Silakan login untuk mengakses keranjang.');
        }

        $cartItems = Cart::where('user_id', Auth::id())
            ->with('product.category')
            ->get();

        $total = 0;
        foreach ($cartItems as $item) {
            if ($item->product) {
                $price = $item->product->final_price ?? $item->product->selling_price ?? 0;
                $total += $price * $item->quantity;
            }
        }

        $categories = \App\Models\Category::orderBy('name')->get();

        return view('main.cart.index', [
            'cartItems' => $cartItems,
            'total' => $total,
            'categories' => $categories,
            'cartCount' => Cart::where('user_id', Auth::id())->sum('quantity'),
            'pageTitle' => 'Keranjang - Glorious Computer',
        ]);
    }

    /**
     * Add to cart - hanya jika login. Jika guest → redirect login.
     */
    public function store(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'Customer') {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => 'Silakan login untuk menambah ke keranjang.',
                    'redirect' => url('/'),
                ], 403);
            }
            return redirect()->back()->with('error', 'Silakan login untuk menambah ke keranjang.');
        }

        $validated = $request->validate([
            'product_id' => 'required|exists:products,id',
            'quantity' => 'nullable|integer|min:1|max:99',
        ]);

        $product = Product::findOrFail($validated['product_id']);
        $qty = (int) ($validated['quantity'] ?? 1);

        $cart = Cart::firstOrNew([
            'user_id' => Auth::id(),
            'product_id' => $product->id,
        ]);
        $cart->quantity = ($cart->quantity ?? 0) + $qty;
        $cart->save();

        $cartCount = Cart::where('user_id', Auth::id())->sum('quantity');

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'message' => 'Produk ditambah ke keranjang.',
                'cart_count' => $cartCount,
            ]);
        }

        return redirect()->back()->with('success', 'Produk ditambah ke keranjang.')->with('cart_count', $cartCount);
    }

    /**
     * Update quantity.
     */
    public function update(Request $request, Cart $cart)
    {
        if (!Auth::check() || Auth::user()->role !== 'Customer' || $cart->user_id !== Auth::id()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            return redirect()->route('cart.index');
        }

        $validated = $request->validate([
            'quantity' => 'required|integer|min:1|max:99',
        ]);

        $cart->update(['quantity' => $validated['quantity']]);

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'cart_count' => Cart::where('user_id', Auth::id())->sum('quantity'),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Keranjang diperbarui.');
    }

    /**
     * Remove item from cart.
     */
    public function destroy(Request $request, Cart $cart)
    {
        if (!Auth::check() || Auth::user()->role !== 'Customer' || $cart->user_id !== Auth::id()) {
            if ($request->expectsJson()) {
                return response()->json(['message' => 'Unauthorized'], 403);
            }
            return redirect()->route('cart.index');
        }

        $cart->delete();

        if ($request->expectsJson()) {
            return response()->json([
                'success' => true,
                'cart_count' => Cart::where('user_id', Auth::id())->sum('quantity'),
            ]);
        }

        return redirect()->route('cart.index')->with('success', 'Item dihapus dari keranjang.');
    }
}
