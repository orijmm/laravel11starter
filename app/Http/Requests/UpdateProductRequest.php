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
            'title' => 'required|string',
            'slug' => 'required|alpha_dash|unique:products,slug,' . $this->route('product')->id,
            'slug' => 'required|string',
            'short_description' => 'nullable|string',
            'description' => 'nullable|string',
            'sku' => 'nullable|string',
            'brand' => 'nullable|string',
            'model' => 'nullable|string',
            'is_featured' => 'required|string',
            'is_active' => 'required|string',
            'has_stock' => 'required|string',
            'is_on_sale' => 'required|string',
            'sale_percentage' => 'nullable|string',
            'rating_avg' => 'required|string',
            'rating_count' => 'required|integer',
            'specs' => 'nullable|string',
            'metadata' => 'nullable|string',
            'color' => 'nullable|string',
            'size' => 'nullable|string',
            'brand_name' => 'nullable|string',
            
        ];
    }
}
