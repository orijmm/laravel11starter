<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMenuRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required',
            'description' => 'required',
            'items' => 'required|array', 
            'items.*.id' => 'nullable|integer|exists:menu_items,id',
            'items.*.label' => 'required|string',
            'items.*.url' => 'required|string',
            'items.*.description' => 'nullable|string',
            'items.*.order' => 'required|integer',
            'items.*.parent_id' => 'nullable|integer',
            'items.*.page_id' => 'nullable|integer|exists:pages,id',
        ];
    }
}
