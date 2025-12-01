<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProductRequest extends FormRequest
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
            'name' => 'required|min:3',
            'description' => 'nullable|string',
            'rules' => 'nullable|string',
            'price' => 'required|numeric|min:0',
            'sku' => 'required|string|unique:products,sku,' . $this->product, // Assuming route parameter is 'product' (resource controller default) or 'id'
            'stock' => 'required|integer',
            'category' => 'required|in:food,drink,snack',
            'image' => 'nullable|image|mimes:png,jpg,jpeg',
            'is_favorite' => 'boolean',
        ];
    }
}
