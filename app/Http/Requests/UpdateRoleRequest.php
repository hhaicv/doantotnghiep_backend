<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRoleRequest extends FormRequest
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

            'name_role' => ['required', 'string', 'max:255'],
            'description' => ['required', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'name_role.required' => 'Tên bắt buộc phải nhập',
            'description.required' => 'Mô tả bắt buộc phải nhập',
        ];
    }
}
