<?php

namespace App\Http\Requests;

class StoreTemplateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|alpha_dash|unique:templates',
            'filename' => 'required',
            'description' => 'required'
        ];
    }
}
