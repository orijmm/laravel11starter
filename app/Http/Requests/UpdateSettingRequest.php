<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSettingRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name_company' => 'required',
            'description' => 'nullable',
            'address' => 'nullable',
            'phone' => 'nullable',
            'email' => 'nullable',
            'locale' => 'required',
            'timezone' => 'required',
            'state_id' => 'required',
            'city_id' => 'required',
            'country_id' => 'required',
            'currency_id' => 'required'
        ];
    }
}
