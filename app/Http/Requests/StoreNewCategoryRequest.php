<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreNewCategoryRequest extends FormRequest
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

            'name' => ['required', 'string', 'min:6', 'max:255'],
            'description' => ['required', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được bỏ trống',
            'name.min' => 'Tên phải có ít nhất 6 ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',
            'description.required' => 'Mô tả bắt buộc phải nhập',
        ];
    }
}
