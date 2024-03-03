<?php

namespace App\Http\Request;

use Illuminate\Foundation\Http\FormRequest;

class ShortUrlsRequest extends FormRequest
{
    public function rules() :array
    {
        return [
            'url' => ['required']
        ];
    }
}
