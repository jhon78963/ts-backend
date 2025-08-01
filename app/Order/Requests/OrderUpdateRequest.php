<?php

namespace App\Order\Requests;

use Illuminate\Foundation\Http\FormRequest;

class OrderUpdateRequest extends FormRequest
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
            'date' => 'sometimes',
            'subTotal' => 'nullable',
            'total' => 'nullable',
            'status' => 'nullable|string',
            'supplierId' => 'sometimes|integer',
        ];
    }
}
