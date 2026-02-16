<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Services\CustomerService;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class AdminCustomerController extends Controller
{
    public function __construct(
        protected CustomerService $service,
    ) {
    }

    public function index(Request $request): View
    {
        $search = trim((string) $request->input('search', ''));
        $customers = $this->service->getCustomerList($search);

        return view('pages.admin.customers.index', [
            'customers' => $customers,
            'search'    => $search,
        ]);
    }

    public function show(int $customer): View
    {
        [$customerModel, $orders] = $this->service->getCustomerDetailWithOrders($customer);

        return view('pages.admin.customers.show', [
            'customer' => $customerModel,
            'orders'   => $orders,
        ]);
    }

    public function edit(User $customer): View
    {
        // Pastikan hanya role Customer
        abort_unless($customer->isCustomer(), 404);

        return view('pages.admin.customers.edit', [
            'customer' => $customer,
        ]);
    }

    public function update(Request $request, User $customer): RedirectResponse
    {
        abort_unless($customer->isCustomer(), 404);

        $data = $request->validate([
            'name'  => ['required', 'string', 'max:255'],
            'email' => ['nullable', 'email', 'max:255', 'unique:users,email,'.$customer->id],
            'phone' => ['nullable', 'string', 'max:20'],
            'address' => ['nullable', 'string', 'max:500'],
        ]);

        $this->service->updateCustomer($customer, $data);

        return redirect()
            ->route('admin.customers.show', $customer->id)
            ->with('success', 'Data customer berhasil diperbarui.');
    }

    public function destroy(User $customer): RedirectResponse
    {
        abort_unless($customer->isCustomer(), 404);

        $this->service->deleteCustomer($customer);

        return redirect()
            ->route('admin.customers.index')
            ->with('success', 'Customer berhasil dihapus.');
    }
}

