<?php

namespace App\Brand\Services;

use App\Brand\Models\Brand;
use App\Shared\Services\ModelService;

class BrandService
{
    protected ModelService $modelService;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public function create(array $newBrand): Brand
    {
        return $this->modelService->create(new Brand(), $newBrand);
    }

    public function delete(Brand $brand): void
    {
        $this->modelService->delete($brand);
    }

    public function update(Brand $brand, array $editBrand): void
    {
        $this->modelService->update($brand, $editBrand);
    }

    public function validate(Brand $brand, string $modelName): Brand
    {
        return $this->modelService->validate($brand, $modelName);
    }
}
