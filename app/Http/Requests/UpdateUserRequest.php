<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'phone' => 'required|digits:10', 
            'address' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email,' . $this->route('user'), // Sửa lại ở đây
            'password' => 'required|min:8|confirmed', 
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên tài khoản là bắt buộc.',
            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không hợp lệ.',
            'email.unique' => 'Email đã tồn tại.',
            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.digits_between' => 'Số điện thoại phải từ 10 đến 11 chữ số.',
            'password.required' => 'Mật khẩu là bắt buộc.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Mật khẩu xác nhận không khớp.',
        ];
    }
}
