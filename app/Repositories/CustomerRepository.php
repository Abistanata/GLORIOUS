<?php

namespace App\Repositories;

use App\Models\Order;
use App\Models\User;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerRepository
{
    public function getPaginatedCustomers(?string $search, int $perPage = 15): LengthAwarePaginator
    {
        $query = User::customer()
            ->with([
                'latestOrder' => function ($q) {
                    $q->select('orders.id', 'orders.user_id', 'orders.status', 'orders.total', 'orders.created_at');
                },
            ])
            ->orderByDesc('created_at');

        if ($search !== null && $search !== '') {
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        return $query->paginate($perPage)->withQueryString();
    }

    public function getCustomerByIdWithOrders(int $customerId, int $perPage = 10): array
    {
        $customer = User::customer()->findOrFail($customerId);

        $orders = Order::where('user_id', $customer->id)
            ->with('items.product')
            ->orderByDesc('created_at')
            ->paginate($perPage)
            ->withQueryString();

        return [$customer, $orders];
    }

    public function updateCustomer(User $customer, array $data): User
    {
        $customer->update($data);

        return $customer;
    }

    public function deleteCustomer(User $customer): void
    {
        // Soft delete / hard delete sesuai kebutuhan (saat ini langsung delete)
        $customer->delete();
    }
}

