<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\StockTransaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    public function index()
    {
        $items = Cart::where('user_id', Auth::id())
            ->with('product')
            ->get();

        if ($items->isEmpty()) {
            return redirect()->route('main.cart.index')->with('error', 'Keranjang kosong.');
        }

        $user = Auth::user();
        $lines = [];
        $total = 0;

        foreach ($items as $cartItem) {
            $product = $cartItem->product;
            $price = $this->sellingPrice($product);
            $sub = $cartItem->qty * $price;
            $total += $sub;
            $lines[] = [
                'product' => $product,
                'qty' => $cartItem->qty,
                'price' => $price,
                'subtotal' => $sub,
            ];
        }

        return view('main.checkout.index', [
            'lines' => $lines,
            'total' => $total,
            'customerName' => $user->name,
            'customerWhatsapp' => $user->whatsapp ?? $user->phone ?? '',
        ]);
    }

    /**
     * Generate pesan WA dan redirect ke wa.me
     * Nomor admin dari config atau env: WHATSAPP_ADMIN=62xxx
     */
    public function sendToWhatsApp(Request $request)
    {
        $request->validate([
            'customer_name' => 'required|string|max:100',
            'customer_whatsapp' => 'required|string|max:15',
            'notes' => 'nullable|string|max:500',
        ]);

        $items = Cart::where('user_id', Auth::id())->with('product')->get();
        if ($items->isEmpty()) {
            return redirect()->route('main.cart.index')->with('error', 'Keranjang kosong.');
        }

        $lines = [];
        $total = 0;
        foreach ($items as $cartItem) {
            $product = $cartItem->product;
            $price = $this->sellingPrice($product);
            $sub = $cartItem->qty * $price;
            $total += $sub;
            $lines[] = "• {$product->name} x{$cartItem->qty} = Rp " . number_format($sub, 0, ',', '.');
        }

        $nama = $request->input('customer_name');
        $wa = $request->input('customer_whatsapp');
        $notes = $request->input('notes', '');
        $waNumber = preg_replace('/\D/', '', $wa);
        if (str_starts_with($waNumber, '0')) {
            $waNumber = '62' . substr($waNumber, 1);
        } elseif (!str_starts_with($waNumber, '62')) {
            $waNumber = '62' . $waNumber;
        }

        $message = "Halo Admin,\n\nSaya *{$nama}* ingin memesan:\n\n" . implode("\n", $lines) . "\n\n*Total: Rp " . number_format($total, 0, ',', '.') . "*";
        if ($notes !== '') {
            $message .= "\n\nCatatan: " . $notes;
        }
        $message .= "\n\n(Order dari website Glorious Computer)";

        $adminNumber = config('services.whatsapp.admin');
        $adminNumber = preg_replace('/\D/', '', $adminNumber);
        if (str_starts_with($adminNumber, '0')) {
            $adminNumber = '62' . substr($adminNumber, 1);
        }

        $url = 'https://wa.me/' . $adminNumber . '?text=' . rawurlencode($message);

        // Opsional: simpan order ke DB dengan status pending (agar customer bisa lihat di Pesanan Saya setelah admin konfirmasi)
        $order = Order::create([
            'user_id' => Auth::id(),
            'order_number' => Order::generateOrderNumber(),
            'total' => $total,
            'customer_name' => $nama,
            'customer_whatsapp' => $wa,
            'notes' => $notes,
            'status' => 'pending',
        ]);
        foreach ($items as $cartItem) {
            $product = $cartItem->product;
            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'qty' => $cartItem->qty,
                'price' => $this->sellingPrice($product),
                'product_name' => $product->name,
            ]);
        }
        Cart::where('user_id', Auth::id())->delete();

        return redirect()->away($url);
    }

    private function sellingPrice(Product $product): float
    {
        $price = (float) ($product->selling_price ?? 0);
        if ($product->discount_price > 0 && $product->discount_price < $price) {
            return (float) $product->discount_price;
        }
        return $price;
    }
}
