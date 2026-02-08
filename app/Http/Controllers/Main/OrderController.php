<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Cart;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class OrderController extends Controller
{
    protected function getAdminWaNumber(): string
    {
        $num = config('app.wa_admin', '6282133803940');
        $num = preg_replace('/[^0-9]/', '', $num);
        if (str_starts_with($num, '0')) {
            $num = '62' . substr($num, 1);
        } elseif (!str_starts_with($num, '62')) {
            $num = '62' . $num;
        }
        return $num;
    }

    /**
     * Create order (single product or from cart) and redirect to WhatsApp.
     * Requires auth + Customer.
     */
    public function createAndRedirectToWhatsApp(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'Customer') {
            if ($request->expectsJson()) {
                return response()->json(['success' => false, 'message' => 'Silakan login sebagai pelanggan.', 'redirect' => url('/')], 403);
            }
            return redirect()->route('main.dashboard.index')
                ->with('error', 'Silakan login untuk memesan via WhatsApp.');
        }

        $user = Auth::user();
        $productId = $request->integer('product_id');
        $quantity = max(1, min(99, $request->integer('quantity', 1)));

        if ($productId) {
            return $this->createSingleProductOrderAndRedirect($user, $productId, $quantity);
        }

        $cartIds = $request->input('cart_ids', []);
        return $this->createCartOrderAndRedirect($user, $cartIds);
    }

    protected function createSingleProductOrderAndRedirect($user, int $productId, int $quantity)
    {
        $product = Product::find($productId);
        if (!$product) {
            return redirect()->back()->with('error', 'Produk tidak ditemukan.');
        }

        $currentStock = $product->current_stock ?? 0;
        if ($currentStock < 1) {
            return redirect()->back()->with('error', 'Stok produk habis.');
        }

        $quantity = min($quantity, $currentStock);
        $unitPrice = $product->final_price ?? $product->selling_price ?? 0;
        $subtotal = $unitPrice * $quantity;
        $total = $subtotal;

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'GC-' . strtoupper(uniqid()),
                'status' => 'pending',
                'total' => $total,
                'customer_name' => $user->name,
                'customer_phone' => $user->phone,
                'notes' => null,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => $quantity,
                'unit_price' => $unitPrice,
                'subtotal' => $subtotal,
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->back()->with('error', 'Gagal membuat pesanan. Silakan coba lagi.');
        }

        $message = $this->buildWhatsAppMessage($user, $order);
        $waUrl = 'https://wa.me/' . $this->getAdminWaNumber() . '?text=' . rawurlencode($message);
        return redirect()->away($waUrl);
    }

    protected function createCartOrderAndRedirect($user, array $cartIds = [])
    {
        $query = Cart::where('user_id', $user->id)->with('product');
        if (!empty($cartIds)) {
            $query->whereIn('id', $cartIds);
        }
        $cartItems = $query->get();
        if ($cartItems->isEmpty()) {
            return redirect()->route('cart.index')->with('error', 'Pilih minimal satu item untuk checkout.');
        }

        $total = 0;
        $itemsData = [];
        $cartIdsToDelete = [];
        foreach ($cartItems as $item) {
            if (!$item->product || ($item->product->current_stock ?? 0) < 1) {
                continue;
            }
            $qty = min($item->quantity, (int) ($item->product->current_stock ?? 0));
            if ($qty < 1) {
                continue;
            }
            $price = $item->product->final_price ?? $item->product->selling_price ?? 0;
            $subtotal = $price * $qty;
            $total += $subtotal;
            $itemsData[] = [
                'product' => $item->product,
                'quantity' => $qty,
                'unit_price' => $price,
                'subtotal' => $subtotal,
            ];
            $cartIdsToDelete[] = $item->id;
        }

        if (empty($itemsData)) {
            return redirect()->route('cart.index')->with('error', 'Tidak ada item valid. Cek stok produk.');
        }

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => 'GC-' . strtoupper(uniqid()),
                'status' => 'pending',
                'total' => $total,
                'customer_name' => $user->name,
                'customer_phone' => $user->phone,
                'notes' => null,
            ]);

            foreach ($itemsData as $row) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $row['product']->id,
                    'quantity' => $row['quantity'],
                    'unit_price' => $row['unit_price'],
                    'subtotal' => $row['subtotal'],
                ]);
            }

            Cart::whereIn('id', $cartIdsToDelete)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            return redirect()->route('cart.index')->with('error', 'Gagal membuat pesanan.');
        }

        $message = $this->buildWhatsAppMessage($user, $order->load('items.product'));
        $waUrl = 'https://wa.me/' . $this->getAdminWaNumber() . '?text=' . rawurlencode($message);
        return redirect()->away($waUrl);
    }

    protected function buildWhatsAppMessage($user, Order $order): string
    {
        $lines = [
            'Halo Admin Glorious Computer,',
            '',
            'Saya *' . $user->name . '* ingin memesan:',
            '',
        ];

        foreach ($order->items as $idx => $item) {
            $product = $item->product;
            $name = $product ? $product->name : 'Produk #' . $item->product_id;
            $lines[] = ($idx + 1) . '. ' . $name . ' x' . $item->quantity . ' = Rp ' . number_format($item->subtotal, 0, ',', '.');
        }

        $lines[] = '';
        $lines[] = '*Total: Rp ' . number_format($order->total, 0, ',', '.') . '*';
        $lines[] = '';
        $lines[] = 'Data saya:';
        $lines[] = '• Nama: ' . $user->name;
        $lines[] = '• Username: ' . ($user->username ?? '-');
        $lines[] = '• WhatsApp: ' . ($user->phone ?? '-');
        $lines[] = '• Email: ' . ($user->email ?? '-');
        if (!empty(trim($user->address ?? ''))) {
            $lines[] = '• Alamat: ' . $user->address;
        }
        $lines[] = '';
        $lines[] = 'No. Pesanan: ' . ($order->order_number ?? '#' . $order->id);
        $lines[] = '';
        $lines[] = 'Terima kasih.';

        return implode("\n", $lines);
    }
}
