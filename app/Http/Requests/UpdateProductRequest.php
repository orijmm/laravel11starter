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
            'category_id' => 'nullable|integer',
            'title' => 'required',
            'slug' => 'required|alpha_dash|unique:products,slug,' . $this->route('product')->id,
            'short_description' => 'nullable|string',
            'description' => 'nullable',
            'brand' => 'nullable',
            'model' => 'nullable',
            'is_featured' => 'required|boolean',
            'is_active' => 'required|boolean',
            'has_stock' => 'nullable|boolean',
            'is_on_sale' => 'required|boolean',
            'sale_percentage' => 'nullable',
            'rating_avg' => 'nullable',
            'rating_count' => 'nullable|integer',
            'metadata' => 'nullable',
            'attributes' => 'nullable|array',
            'variants' => 'nullable|array'
        ];
    }
}
