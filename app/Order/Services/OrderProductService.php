<?php

namespace App\Order\Services;

use App\Order\Models\Order;
use App\Product\Models\Product;
use App\Shared\Services\ModelService;

class OrderProductService
{
    protected ModelService $modelService;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public function add(Order $order, Product $product, array $attributes): void
    {
        $this->modelService->attach(
            $order,
            'products',
            'product_id',
            $product->id,
            [
                'quantity' => $attributes['quantity'],
                'price' => $attributes['price'],
            ]
        );
    }

    public function modify(Order $order, Product $product, array $attributes): void
    {
        $this->modelService->attach(
            $order,
            'products',
            'product_id',
            $product->id,
            [
                'quantity' => $attributes['quantity'],
                'price' => $attributes['price'],
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
