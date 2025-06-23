<?php

namespace App\Shared\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class AutocompleteResource extends JsonResource
{
    private string $column;

    public function __construct($resource, string $column = 'description')
    {
        parent::__construct($resource);
        $this->column = $column;
    }
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return[
            'id' => $this->id,
            'value' => $this->{$this->column},
        ];
    }
}
