<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'image_url' => ['required'],
            'link' => ['required', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'image_url.required' => 'Ảnh không được để trống.',
            'link.required' => 'Link không được để trống.',
        ];
    }
}
