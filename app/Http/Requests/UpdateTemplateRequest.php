<?php

namespace App\Http\Requests;

class UpdateTemplateRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'name' => 'required|alpha_dash|unique:templates,name,'.$this->route('template')->id,
            'filename' => 'required',
            'description' => 'required'
        ];
    }
}
