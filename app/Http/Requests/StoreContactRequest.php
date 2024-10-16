<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreContactRequest extends FormRequest
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
            'email' => ['required', 'email'],
            'phone' => ['required', 'numeric', 'digits_between:8,15'],
            'title' => ['required', 'string', 'max:255'],
            'message' => ['required', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Tên là bắt buộc.',
            'name.min' => 'Tên phải có ít nhất 6 ký tự.',
            'name.max' => 'Tên không được vượt quá 255 ký tự.',

            'email.required' => 'Email là bắt buộc.',
            'email.email' => 'Email không đúng định dạng.',

            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.numeric' => 'Số điện thoại phải là một số.',
            'phone.digits_between' => 'Số điện thoại phải có từ 8 đến 15 chữ số.',

            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',

            'message.required' => 'Thông điệp là bắt buộc.',
            'message.string' => 'Thông điệp phải là một chuỗi.',
        ];
    }
}
