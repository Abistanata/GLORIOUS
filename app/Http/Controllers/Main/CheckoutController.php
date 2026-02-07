<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CheckoutController extends Controller
{
    /**
     * Nomor WhatsApp Admin (untuk redirect wa.me).
     */
    protected function getAdminWhatsAppNumber(): string
    {
        return config('app.wa_admin', '6282133803940');
    }

    /**
     * Halaman checkout - tampilkan ringkasan & tombol kirim ke WA.
     */
    public function index(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'Customer') {
            return redirect()->route('main.dashboard.index')->with('error', 'Silakan login untuk checkout.');
        }

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong. Tambah produk dulu.');
        }

        $total = 0;
        foreach ($cartItems as $item) {
            if ($item->product) {
                $price = $item->product->final_price ?? $item->product->selling_price ?? 0;
                $total += $price * $item->quantity;
            }
        }

        $user = Auth::user();
        $categories = \App\Models\Category::orderBy('name')->get();

        return view('main.checkout.index', [
            'cartItems' => $cartItems,
            'total' => $total,
            'user' => $user,
            'categories' => $categories,
            'waNumber' => $this->getAdminWhatsAppNumber(),
            'pageTitle' => 'Checkout - Glorious Computer',
        ]);
    }

    /**
     * Generate pesan WhatsApp dan redirect ke wa.me.
     * POST dari form checkout (nama, no WA, daftar produk, total).
     */
    public function sendToWhatsApp(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'Customer') {
            return redirect()->route('main.dashboard.index')->with('error', 'Silakan login.');
        }

        $cartItems = Cart::where('user_id', Auth::id())->with('product')->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Keranjang kosong.');
        }

        $name = $request->input('customer_name', Auth::user()->name);
        $phone = $request->input('customer_phone', Auth::user()->phone ?? Auth::user()->whatsapp ?? '');

        $lines = [];
        $lines[] = "Halo Admin,";
        $lines[] = "Saya *" . $name . "* ingin memesan:";
        $lines[] = "";

        $total = 0;
        $num = 1;
        foreach ($cartItems as $item) {
            if (!$item->product) {
                continue;
            }
            $price = $item->product->final_price ?? $item->product->selling_price ?? 0;
            $subtotal = $price * $item->quantity;
            $total += $subtotal;
            $lines[] = $num . ". " . $item->product->name . " x" . $item->quantity . " (Rp " . number_format($subtotal, 0, ',', '.') . ")";
            $num++;
        }

        $lines[] = "";
        $lines[] = "*Total: Rp " . number_format($total, 0, ',', '.') . "*";
        $lines[] = "";
        $lines[] = "No. WhatsApp saya: " . $phone;

        $text = implode("\n", $lines);
        $waNumber = $this->getAdminWhatsAppNumber();
        $waNumber = preg_replace('/[^0-9]/', '', $waNumber);
        if (substr($waNumber, 0, 1) === '0') {
            $waNumber = '62' . substr($waNumber, 1);
        } elseif (substr($waNumber, 0, 2) !== '62') {
            $waNumber = '62' . $waNumber;
        }

        $url = 'https://wa.me/' . $waNumber . '?text=' . rawurlencode($text);

        return redirect()->away($url);
    }
}
