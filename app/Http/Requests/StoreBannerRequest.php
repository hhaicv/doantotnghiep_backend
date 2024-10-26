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
<<<<<<< HEAD
=======
            'start_date' => ['required'],
            'end_date'=> ['required'],
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
        ];
    }
    public function messages(): array
    {
        return [
            'image_url.required' => 'Ảnh không được để trống.',
            'link.required' => 'Link không được để trống.',
<<<<<<< HEAD
=======
            'start_date' => 'chọn ngày bắt đầu',
            'end_date'=>  'chọn ngày kết thúc',
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
        ];
    }
}
