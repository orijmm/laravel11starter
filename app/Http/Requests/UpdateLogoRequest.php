<?php

namespace App\Http\Requests;

class UpdateLogoRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'logo' => 'required|image',
        ];
    }
}
