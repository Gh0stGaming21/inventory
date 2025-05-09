<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProductRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Allow all authenticated users to access this request
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        $productId = $this->route('product')?->id;

        return [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:3',
                Rule::unique('products', 'name')->ignore($productId)
            ],
            'description' => [
                'required',
                'string',
                'min:10',
                'max:2000'
            ],
            'price' => [
                'required',
                'numeric',
                'min:0.01',
                'max:9999999.99',
                'regex:/^\d+(\.\d{1,2})?$/'
            ],
            'quantity' => [
                'required',
                'integer',
                'min:0',
                'max:99999'
            ],
            'category_id' => [
                'required',
                'integer',
                'exists:categories,id'
            ],
            'sku' => [
                'nullable',
                'string',
                'max:50',
                'regex:/^[A-Za-z0-9-_.]+$/',
                Rule::unique('products', 'sku')->ignore($productId)
            ],
            'minimum_stock' => [
                'nullable',
                'integer',
                'min:0',
                'max:99999',
                'lte:quantity'
            ]
        ];
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The product name is required.',
            'name.min' => 'The product name must be at least 3 characters.',
            'name.unique' => 'This product name already exists in the inventory.',
            'description.required' => 'The product description is required.',
            'description.min' => 'The description must be at least 10 characters.',
            'price.required' => 'The product price is required.',
            'price.numeric' => 'The price must be a valid number.',
            'price.min' => 'The price must be at least 0.01.',
            'price.regex' => 'The price must have at most 2 decimal places.',
            'quantity.required' => 'The product quantity is required.',
            'quantity.integer' => 'The quantity must be a whole number.',
            'quantity.min' => 'The quantity cannot be negative.',
            'quantity.max' => 'The quantity cannot exceed 99,999 units.',
            'category_id.required' => 'Please select a category for this product.',
            'category_id.exists' => 'The selected category does not exist.',
            'sku.unique' => 'This SKU is already in use by another product.',
            'sku.regex' => 'The SKU may only contain letters, numbers, dashes, underscores, and periods.',
            'minimum_stock.lte' => 'The minimum stock level cannot be greater than the current quantity.'
        ];
    }

    /**
     * Get custom attributes for validator errors.
     *
     * @return array
     */
    public function attributes(): array
    {
        return [
            'name' => 'product name',
            'description' => 'product description',
            'price' => 'product price',
            'quantity' => 'product quantity',
            'category_id' => 'product category',
            'sku' => 'SKU',
            'minimum_stock' => 'minimum stock level'
        ];
    }

    /**
     * Prepare the data for validation.
     *
     * @return void
     */
    protected function prepareForValidation(): void
    {
        // Trim whitespace from string inputs
        $this->merge([
            'name' => $this->name ? trim($this->name) : null,
            'description' => $this->description ? trim($this->description) : null,
            'sku' => $this->sku ? trim($this->sku) : null,
        ]);
    }
}
