<?php

namespace App\Http\Requests;

class StoreAbilityRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|alpha_dash|unique:abilities',
            'title' => 'required',
        ];
    }
}
