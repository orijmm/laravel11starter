<?php

namespace App\Http\Requests;

class Template extends BaseRequest
{

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'name' => 'required|unique:templates,name,'.$this->request->get('name'),
            'filename' => 'required|unique:templates,filename,'.$this->request->get('filename'),
            'description' => 'required',
        ];
    }
}
