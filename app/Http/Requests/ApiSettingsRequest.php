<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ApiSettingsRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return match ($this->getMethod()) {
            "POST" => [
                'input-xml_address' => 'required|min:2|max:500',
                'input-api_key' => 'required|min:2|max:200',
                'input-api_password' => 'required|min:2|max:200',
            ],
            "PUT" => [
                'input-xml_address' => 'required|min:2|max:500',
                'input-api_address' => 'required|min:2|max:200',
                'input-api_password' => 'required|min:2|max:200'
            ],
            default => [],
        };
    }

    public function attributes()
    {
        return [
            'input-xml_address' => 'XML Adresi',
            'input-api_key' => 'KMK API Adresi',
            'input-api_password' => 'KMK API Parolası'
        ];
    }
}
