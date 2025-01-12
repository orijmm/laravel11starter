<?php

namespace App\Http\Requests;

class UpdatePageRequest extends BaseRequest
{
    public function rules(): array
    {
        return [
            'title' => 'required',
            'description' => 'required',
            'slug' => 'required|alpha_dash|unique:pages,slug,'.$this->route('page')->id, 
            'template_id' => 'required',
        ];
    }
}
