<?php

namespace App\Sale\Resources;

use App\Shared\Resources\AutocompleteResource;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SaleResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'id' => $this->id,
            'date' => $this->date,
            'customer' => $this->customer->full_name,
            'total' => $this->total,
            'status' => $this->status->label(),
            'customerId' => $this->customer_id,
            'products' => $this->parseProductData($this->products),
        ];
    }

    private function parseProductData($products): array
    {
        return $products->map(fn($product) => [
            'product' => new AutocompleteResource($product, 'name'),
            'quantity' => $product->pivot->quantity ?? 0,
            'price' => $product->pivot->price ?? 0,
        ])->values()->all();
    }
}
