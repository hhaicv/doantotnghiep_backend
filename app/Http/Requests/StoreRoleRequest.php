<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreRoleRequest extends FormRequest
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

            'name_role' => ['required', 'string', 'min:4', 'max:255'],
            'description' => ['required', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'name_role.required' => 'Tên là bắt buộc.',
            'name_role.min' => 'Tên phải có ít nhất 4 ký tự.',
            'name_role.max' => 'Tên không được vượt quá 255 ký tự.',
            'description.required' => 'Mô tả bắt buộc phải nhập',
        ];
    }

}
