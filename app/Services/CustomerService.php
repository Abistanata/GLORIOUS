<?php

namespace App\Services;

use App\Models\User;
use App\Repositories\CustomerRepository;
use Illuminate\Contracts\Pagination\LengthAwarePaginator;

class CustomerService
{
    public function __construct(
        protected CustomerRepository $repository,
    ) {
    }

    public function getCustomerList(?string $search): LengthAwarePaginator
    {
        return $this->repository->getPaginatedCustomers($search);
    }

    public function getCustomerDetailWithOrders(int $customerId): array
    {
        return $this->repository->getCustomerByIdWithOrders($customerId);
    }

    public function updateCustomer(User $customer, array $data): User
    {
        return $this->repository->updateCustomer($customer, $data);
    }

    public function deleteCustomer(User $customer): void
    {
        $this->repository->deleteCustomer($customer);
    }
}

