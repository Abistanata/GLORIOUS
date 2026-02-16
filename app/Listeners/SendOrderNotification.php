<?php

namespace App\Listeners;

use App\Events\OrderCreated;
use App\Models\User;
use App\Notifications\NewOrderNotification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Support\Facades\Notification;

class SendOrderNotification implements ShouldQueue
{
    public function handle(OrderCreated $event): void
    {
        $order = $event->order;

        $admins = User::where('role', 'Admin')->get();
        if ($admins->isEmpty()) {
            return;
        }

        Notification::send($admins, new NewOrderNotification($order));
    }
}

