<?php

namespace App\Http\Requests;

class AbilityToRoleRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required',
        ];
    }
}
