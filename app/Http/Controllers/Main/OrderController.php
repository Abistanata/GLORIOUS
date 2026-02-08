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
use Illuminate\Support\Facades\Log;

class OrderController extends Controller
{
    protected function getAdminWaNumber(): string
    {
        $num = config('app.wa_admin') ?: env('ADMIN_WHATSAPP_NUMBER') ?: env('WA_ADMIN') ?: '6282133803940';
        $num = (string) preg_replace('/[^0-9]/', '', (string) $num);
        if ($num === '' || strlen($num) < 10) {
            return '6282133803940';
        }
        if (str_starts_with($num, '0')) {
            $num = '62' . substr($num, 1);
        } elseif (!str_starts_with($num, '62')) {
            $num = '62' . $num;
        }
        return $num;
    }

    /** Generate unique order number (GC-YYYYMMDD-HHMMSS-XXXX). */
    protected function generateOrderNumber(): string
    {
        $maxAttempts = 10;
        for ($i = 0; $i < $maxAttempts; $i++) {
            try {
                $num = 'GC-' . date('Ymd-His') . '-' . strtoupper(substr(str_replace('.', '', uniqid('', true)), -8));
            } catch (\Throwable $e) {
                $num = 'GC-' . date('YmdHis') . '-' . mt_rand(100000, 999999);
            }
            if (!Order::where('order_number', $num)->exists()) {
                return $num;
            }
        }
        return 'GC-' . date('YmdHis') . '-' . uniqid();
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

        // Validasi profile lengkap (wajib untuk checkout)
        $phone = trim($user->phone ?? '');
        $address = trim($user->address ?? '');
        if (strlen($phone) < 10) {
            return redirect()->route('customer.profile.edit')
                ->with('error', 'Lengkapi nomor WhatsApp di profil Anda terlebih dahulu untuk checkout.');
        }
        if (strlen($address) < 10) {
            return redirect()->route('customer.profile.edit')
                ->with('error', 'Lengkapi alamat di profil Anda terlebih dahulu untuk checkout.');
        }

        $productId = $request->integer('product_id');
        $quantity = max(1, min(99, $request->integer('quantity', 1)));

        if ($productId) {
            return $this->createSingleProductOrderAndRedirect($user, $productId, $quantity);
        }

        $cartIds = $request->input('cart_ids', []);
        if (!is_array($cartIds)) {
            $cartIds = [];
        }
        $cartIds = array_filter(array_map('intval', $cartIds));
        if (empty($cartIds)) {
            return redirect()->route('cart.index')->with('error', 'Pilih minimal satu item untuk checkout.');
        }

        $quantities = $request->input('quantities', []);
        return $this->createCartOrderAndRedirect($user, $cartIds, $quantities);
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
        $unitPrice = (float) ($product->final_price ?? $product->selling_price ?? 0);
        $subtotal = $unitPrice * $quantity;
        $total = $subtotal;

        DB::beginTransaction();
        try {
            $order = Order::create([
                'user_id' => $user->id,
                'order_number' => $this->generateOrderNumber(),
                'status' => 'pending',
                'total' => round($total, 2),
                'customer_name' => (string) ($user->name ?? ''),
                'customer_phone' => (string) ($user->phone ?? ''),
                'notes' => null,
            ]);

            OrderItem::create([
                'order_id' => $order->id,
                'product_id' => $product->id,
                'quantity' => (int) $quantity,
                'unit_price' => round($unitPrice, 2),
                'subtotal' => round($subtotal, 2),
            ]);

            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order create single product failed: ' . $e->getMessage(), ['exception' => $e, 'user_id' => $user->id, 'product_id' => $productId]);
            return redirect()->back()->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
        }

        $message = $this->buildWhatsAppMessage($user, $order);
        $waUrl = 'https://wa.me/' . $this->getAdminWaNumber() . '?text=' . rawurlencode($message);
        return redirect()->away($waUrl);
    }

    protected function createCartOrderAndRedirect($user, array $cartIds = [], array $quantities = [])
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
            $requestQty = isset($quantities[$item->id]) ? max(1, min(99, (int) $quantities[$item->id])) : null;
            $qty = $requestQty ?? $item->quantity;
            $qty = min($qty, (int) ($item->product->current_stock ?? 0));
            if ($qty < 1) {
                continue;
            }
            $price = (float) ($item->product->final_price ?? $item->product->selling_price ?? 0);
            $price = max(0, $price);
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
                'order_number' => $this->generateOrderNumber(),
                'status' => 'pending',
                'total' => round((float) $total, 2),
                'customer_name' => (string) ($user->name ?? ''),
                'customer_phone' => (string) ($user->phone ?? ''),
                'notes' => null,
            ]);

            foreach ($itemsData as $row) {
                OrderItem::create([
                    'order_id' => $order->id,
                    'product_id' => $row['product']->id,
                    'quantity' => (int) $row['quantity'],
                    'unit_price' => round((float) $row['unit_price'], 2),
                    'subtotal' => round((float) $row['subtotal'], 2),
                ]);
            }

            Cart::whereIn('id', $cartIdsToDelete)->delete();
            DB::commit();
        } catch (\Exception $e) {
            DB::rollBack();
            Log::error('Order create from cart failed: ' . $e->getMessage(), ['exception' => $e, 'user_id' => $user->id, 'cart_ids' => $cartIds]);
            return redirect()->route('cart.index')->with('error', 'Gagal membuat pesanan: ' . $e->getMessage());
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
        $lines[] = '*Total: Rp ' . number_format((float) $order->total, 0, ',', '.') . '*';
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
