<?php

namespace App\Order\Services;

use App\Order\Models\Order;
use App\Shared\Services\ModelService;

class OrderProductService
{
    protected ModelService $modelService;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public function add(Order $order, int $productId, array $product): void
    {
        $this->modelService->attach(
            $order,
            'products',
            $productId,
            [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]
        );
    }

    public function modify(Order $order,  int $productId, array $product): void
    {
        $this->modelService->attach(
            $order,
            'products',
            $productId,
            [
                'quantity' => $product['quantity'],
                'price' => $product['price'],
            ]
        );
    }

    public function remove(Order $order, int $productId): void
    {
        $this->modelService->detach(
            $order,
            'products',
            $productId,
        );
    }
}
