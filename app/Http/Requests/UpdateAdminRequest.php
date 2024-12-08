<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            
        ];
    }
    public function messages(): array
    {
        return [
           
        ];
    }
}
