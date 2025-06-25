<?php

namespace App\Sale\Services;

use App\Sale\Models\Sale;
use App\Shared\Services\ModelService;

class SaleProductService
{
    protected ModelService $modelService;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public function add(Sale $sale, int $productId, array $product): void
    {
        $this->modelService->attach(
            $sale,
            'products',
            $productId,
            [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]
        );
    }

    public function modify(Sale $sale,  int $productId, array $product): void
    {
        $this->modelService->attach(
            $sale,
            'products',
            $productId,
            [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]
        );
    }

    public function remove(Sale $sale, int $productId): void
    {
        $this->modelService->detach(
            $sale,
            'products',
            $productId,
        );
    }
}
