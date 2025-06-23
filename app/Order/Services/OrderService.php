<?php

namespace App\Order\Services;

use App\Order\Models\Order;
use App\Shared\Services\ModelService;

class OrderService
{
    protected ModelService $modelService;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public function create(array $newOrder): Order
    {
        return $this->modelService->create(new Order(), $newOrder);
    }

    public function delete(Order $order): void
    {
        $this->modelService->delete($order);
    }

    public function update(Order $order, array $editOrder): Order
    {
        return $this->modelService->update($order, $editOrder);
    }

    public function validate(Order $order, string $modelName): Order
    {
        return $this->modelService->validate($order, $modelName);
    }
}
