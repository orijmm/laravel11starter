<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
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
            'title' => 'nullable|string',
            'type' => 'nullable|string',
            'value' => 'nullable|string',
            'start_at' => 'nullable|date_format:Y-m-d H:i:s',
            'end_at' => 'nullable|date_format:Y-m-d H:i:s',
            'is_active' => 'required|boolean',
            
        ];
    }
}
