<?php

namespace App\Product\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ProductCreateRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:250',
            'salePrice' => 'nullable',
            'purchasePrice' => 'nullable',
            'stock' => 'nullable|integer',
            'image' => 'nullable',
            'status' => 'nullable|string',
            'categoryId' => 'nullable|integer',
            'brandId' => 'nullable|integer',
            'measurementId' => 'nullable|integer',
        ];
    }
}
