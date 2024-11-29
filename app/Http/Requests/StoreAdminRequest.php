<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAdminRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255', 
            'image' => 'required|mimes:jpeg,png,jpg,gif,svg',
            'email' => 'required|email',
            'password' => 'required|string',
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên không được để trống.',
            'image.required' => 'Không được để trống hình ảnh',
            'image.mimes' => 'Ảnh phải thuộc một trong các định dạng sau: jpeg, png, jpg, gif, svg.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'password.required' => 'mật khẩu không được để trống',
        ];
    }
}

