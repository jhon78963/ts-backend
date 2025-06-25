<?php

namespace App\Sale\Services;

use App\Product\Models\Product;
use App\Sale\Models\Sale;
use App\Shared\Services\ModelService;
use Illuminate\Database\Eloquent\Relations\Pivot;

class SaleProductService
{
    protected ModelService $modelService;

    public function __construct(ModelService $modelService)
    {
        $this->modelService = $modelService;
    }

    public function add(Sale $sale, Product $product, array $attributes): void
    {
        $this->modelService->attach(
            $sale,
            'products',
            'product_id',
            $product->id,
            [
                'quantity' => $attributes['quantity'],
                'price' => $attributes['price'],
            ]
        );
        $product->decreaseStock($attributes['quantity']);
    }

    public function modify(Sale $sale, Product $product, array $attributes): void
    {
        $pivot = $sale->products()->where('product_id', $product->id)->first()?->pivot;
        if ($pivot) {
            $product->increaseStock($pivot->quantity);
        }
        $this->modelService->attach(
            $sale,
            'products',
            'product_id',
            $product->id,
            [
                'quantity' => $attributes['quantity'],
                'price' => $attributes['price'],
            ]
        );
        $product->decreaseStock($attributes['quantity']);
    }

    public function remove(Sale $sale, Product $product): void
    {
        $pivot = $sale->products()->where('product_id', $product->id)->first()?->pivot;
        if ($pivot) {
            $product->increaseStock($pivot->quantity);
        }
        $this->modelService->detach(
            $sale,
            'products',
            $product->id,
        );
    }
}
