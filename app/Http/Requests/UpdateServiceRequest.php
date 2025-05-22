<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateServiceRequest extends FormRequest
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
            'icon_color_class' => 'nullable',
            'icon' => 'nullable',
            'title' => 'required',
            'component_type_id' => 'required',
            'description' => 'nullable',
            'link' => 'nullable',
            'link_color_class' => 'nullable',
        ];
    }
}
