<?php

namespace App\Customer\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CustomerUpdateRequest extends FormRequest
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
            'dni' => 'sometimes|string|min:8|max:8',
            'fullName' => 'sometimes|string',
            'name' => 'sometimes|string',
            'surname' => 'sometimes|string',
            'phone' => 'nullable|string|min:9|max:9',
        ];
    }
}
