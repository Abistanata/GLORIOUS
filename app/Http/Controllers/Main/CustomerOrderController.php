<?php

namespace App\Http\Controllers\Main;

use App\Http\Controllers\Controller;
use App\Models\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class CustomerOrderController extends Controller
{
    /**
     * Pesanan Saya - hanya order yang sudah dikonfirmasi admin (status: confirmed / processed).
     */
    public function index(Request $request)
    {
        if (!Auth::check() || Auth::user()->role !== 'Customer') {
            return redirect()->route('main.dashboard.index')->with('error', 'Silakan login sebagai customer.');
        }

        $orders = Order::where('user_id', Auth::id())
            ->confirmedOrProcessed()
            ->with('items.product')
            ->orderByDesc('confirmed_at')
            ->orderByDesc('created_at')
            ->paginate(10);

        $categories = \App\Models\Category::orderBy('name')->get();

        return view('main.customer.orders', [
            'orders' => $orders,
            'categories' => $categories,
            'pageTitle' => 'Pesanan Saya - Glorious Computer',
        ]);
    }
}
