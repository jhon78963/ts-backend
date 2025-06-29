<?php

namespace App\Customer\Services;

use App\Customer\Models\Customer;
use App\Shared\Services\ModelService;

class CustomerService
{
    protected ModelService $modelService;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public function create(array $newCustomer): Customer
    {
        return $this->modelService->create(new Customer(), $newCustomer);
    }

    public function delete(Customer $customer): void
    {
        $this->modelService->delete($customer);
    }

    public function update(Customer $customer, array $editSupplier): void
    {
        $this->modelService->update($customer, $editSupplier);
    }

    public function validate(Customer $customer, string $modelName): Customer
    {
        return $this->modelService->validate($customer, $modelName);
    }
}
