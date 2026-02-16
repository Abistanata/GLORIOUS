<?php

namespace App\Http\Controllers;

use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminNotificationController extends Controller
{
    public function markAsRead(Request $request, string $notification): RedirectResponse
    {
        $user = $request->user();

        abort_unless($user && $user->role === 'Admin', 403);

        $notif = $user->notifications()->where('id', $notification)->firstOrFail();
        $notif->markAsRead();

        $customerId = $notif->data['customer_id'] ?? null;

        if ($customerId) {
            return redirect()->route('admin.customers.show', $customerId);
        }

        return redirect()->route('admin.dashboard');
    }
}

