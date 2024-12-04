<?php

namespace App\Http\Requests;

use App\Rules\ValidContract;
use Illuminate\Foundation\Http\FormRequest;

class UpdateUnit extends FormRequest
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
            'name' => 'sometimes|string',
            'unit_type' => 'sometimes|in:apartment,villa,twinhouse,penthouse,townhouse,duplex',
            'area' => 'sometimes|string',
            'address' => 'sometimes|string',
            'rooms' => 'sometimes|integer',
            'bathrooms' => 'sometimes|integer',
            'is_finished' => 'sometimes|boolean',
            'images' => 'sometimes|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'contract' => ['nullable', 'file', new ValidContract],
        ];
    }
}
