<?php

namespace App\Sale\Services;

use App\Sale\Models\Sale;
use App\Shared\Services\ModelService;

class SaleService
{
    protected ModelService $modelService;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public function create(array $newSale): Sale
    {
        return $this->modelService->create(new Sale(), $newSale);
    }

    public function delete(Sale $sale): void
    {
        $this->modelService->delete($sale);
    }

    public function update(Sale $sale, array $editSale): Sale
    {
        return $this->modelService->update($sale, $editSale);
    }

    public function validate(Sale $sale, string $modelName): Sale
    {
        return $this->modelService->validate($sale, $modelName);
    }
}
