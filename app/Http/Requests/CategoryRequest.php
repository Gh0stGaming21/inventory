<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CategoryRequest extends FormRequest
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
        $rules = [
            'name' => [
                'required',
                'string',
                'max:255',
                'min:2',
                Rule::unique('categories')->ignore($this->category)
            ],
            'description' => [
                'required',
                'string',
                'min:5',
                'max:1000'
            ]
        ];

        return $rules;
    }

    /**
     * Get custom messages for validator errors.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'name.required' => 'The category name is required.',
            'name.min' => 'The category name must be at least 2 characters.',
            'name.unique' => 'This category name already exists.',
            'description.required' => 'The category description is required.',
            'description.min' => 'The description must be at least 5 characters.'
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
            'name' => 'category name',
            'description' => 'category description'
        ];
    }
}
