<?php

namespace App\Http\Requests;

class UpdateLogoRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'logo_url' => 'image|nullable',
            'logo_url2' => 'image|nullable',
        ];
    }
}
