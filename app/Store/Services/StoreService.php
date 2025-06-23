<?php

namespace App\Store\Services;

use App\Store\Models\Store;
use App\Shared\Services\ModelService;

class StoreService
{
    protected ModelService $modelService;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public function create(array $newStore): void
    {
        $this->modelService->create(new Store(), $newStore);
    }

    public function delete(Store $store): void
    {
        $this->modelService->delete($store);
    }

    public function update(Store $store, array $editStore): void
    {
        $this->modelService->update($store, $editStore);
    }

    public function validate(Store $store, string $modelName): Store
    {
        return $this->modelService->validate($store, $modelName);
    }
}
