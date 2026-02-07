<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    /**
     * Pesanan Saya - hanya tampilkan yang status confirmed / processed
     */
    public function index()
    {
        $orders = Order::where('user_id', Auth::id())
            ->whereIn('status', ['confirmed', 'processed'])
            ->with('items.product')
            ->orderByDesc('updated_at')
            ->paginate(10);

        return view('main.orders.index', ['orders' => $orders]);
    }

    public function show(Order $order)
    {
        if ($order->user_id !== Auth::id()) {
            abort(403);
        }
        if (!in_array($order->status, ['confirmed', 'processed'], true)) {
            return redirect()->route('customer.orders.index')
                ->with('info', 'Detail pesanan hanya tersedia untuk pesanan yang sudah dikonfirmasi.');
        }
        $order->load('items.product');
        return view('main.orders.show', ['order' => $order]);
    }
}
