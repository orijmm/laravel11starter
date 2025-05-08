<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
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
            'img_alt' => 'nullable',
            'category' => 'nullable',
            'title' => 'required',
            'slug' => 'required|alpha_dash|unique:projects',
            'description' => 'nullable',
            'url' => 'nullable',
            'date' => 'nullable',
            'client_name' => 'nullable'
        ];
    }
}
