<?php

namespace App\Product\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProductResource extends JsonResource
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
            'description' => $this->name,
            'name' => $this->name,
            'salePrice' => $this->sale_price,
            'purchasePrice' => $this->purchase_price,
            'stock' => $this->stock,
            'status' => $this->status,
            'image' => $this->image,
            'categoryId' => $this->category_id,
            'brandId' => $this->brand_id,
            'measurementId' => $this->measurement_id,
        ];
    }
}
