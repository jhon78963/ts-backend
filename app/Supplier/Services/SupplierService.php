<?php

namespace App\Supplier\Services;

use App\Supplier\Models\Supplier;
use App\Shared\Services\ModelService;

class SupplierService
{
    protected ModelService $modelService;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public function create(array $newSupplier): Supplier
    {
        return $this->modelService->create(new Supplier(), $newSupplier);
    }

    public function delete(Supplier $supplier): void
    {
        $this->modelService->delete($supplier);
    }

    public function update(Supplier $supplier, array $editSupplier): void
    {
        $this->modelService->update($supplier, $editSupplier);
    }

    public function validate(Supplier $supplier, string $modelName): Supplier
    {
        return $this->modelService->validate($supplier, $modelName);
    }
}
