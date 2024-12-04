<?php

namespace App\Http\Requests;

use App\Rules\ValidContract;
use Illuminate\Foundation\Http\FormRequest;

class StoreUnit extends FormRequest
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
            'name' => 'required|string',
            'unit_type' => 'required|in:apartment,villa,twinhouse,penthouse,townhouse,duplex',
            'area' => 'required|string',
            'address'=> 'required|string',
            'rooms' => 'required|integer',
            'bathrooms' => 'required|integer',
            'is_finished' => 'required|boolean',
            'images' => 'required|array|max:10',
            'images.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:4096',
            'contract' => ['required', 'file', new ValidContract],
        ];
    }
}
