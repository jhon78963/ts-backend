<?php

namespace App\Product\Resources;

use App\Shared\Resources\BaseResource;
use Illuminate\Http\Request;

class ProductResource extends BaseResource
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
            'minStock' => $this->min_stock,
            'expirationDate' => $this->dateFormat($this->expiration_date),
            'status' => $this->status->label(),
            'image' => $this->image ? config('app.file_url') . '/' . ltrim($this->image, '/') : null,
            'categoryId' => $this->category_id,
            'brandId' => $this->brand_id,
            'measurementId' => $this->measurement_id,
        ];
    }
}
