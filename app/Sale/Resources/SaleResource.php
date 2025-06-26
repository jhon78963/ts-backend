<?php

namespace App\Sale\Resources;

use App\Shared\Resources\AutocompleteResource;
use App\Shared\Resources\BaseResource;
use Illuminate\Http\Request;

class SaleResource extends BaseResource
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
            'date' => $this->dateFormat($this->date),
            'customer' => $this->customer->full_name,
            'total' => $this->total,
            'status' => $this->status->label(),
            'customerId' => $this->customer_id,
            'products' => $this->parseProductData($this->products),
        ];
    }
}
