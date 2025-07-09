<?php

namespace App\Order\Resources;

use App\Shared\Resources\BaseResource;
use Illuminate\Http\Request;

class OrderResource extends BaseResource
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
            'businessName' => $this->supplier->business_name,
            'manager' => $this->supplier->manager,
            'total' => $this->total,
            'status' => $this->status->label(),
            'supplierId' => $this->supplier_id,
            'products' => $this->parseProductData($this->products),
        ];
    }
}
