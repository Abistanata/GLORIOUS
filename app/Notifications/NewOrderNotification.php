<?php

namespace App\Notifications;

use App\Models\Order;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class NewOrderNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        protected Order $order,
    ) {
    }

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toDatabase(object $notifiable): array
    {
        $order = $this->order->loadMissing('user', 'items.product');

        $customer = $order->user;
        $firstItem = $order->items->first();
        $itemsCount = $order->items->sum('quantity');

        $productSummary = null;
        if ($firstItem) {
            $name = $firstItem->product->name ?? ('Produk #'.$firstItem->product_id);
            $productSummary = $name.' x'.$itemsCount;
        }

        return [
            'customer_id'     => $customer?->id,
            'customer_name'   => $customer?->name,
            'customer_email'  => $customer?->email,
            'order_id'        => $order->id,
            'order_number'    => $order->order_number,
            'order_total'     => (float) $order->total,
            'order_status'    => $order->status,
            'shipping_status' => $order->shipping_status ?? null,
            'product_summary' => $productSummary,
            'created_at'      => $order->created_at,
        ];
    }
}

