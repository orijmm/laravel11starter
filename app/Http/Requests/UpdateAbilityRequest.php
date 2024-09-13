<?php

namespace App\Http\Requests;

class UpdateAbilityRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|alpha_dash|unique:abilities,name,'.$this->route('ability')->id,
            'title' => 'required',
        ];
    }
}
