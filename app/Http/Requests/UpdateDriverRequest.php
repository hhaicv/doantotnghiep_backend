<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class updateDriverRequest extends FormRequest
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
            'name' =>['required','string','max:255'],
            'date_of_birth' => ['required','date'],
            'email' => ['required','string','email','max:255'],
            'password' => ['required','string','min:6'],
            'phone' => ['required','string','max:10'],
            'license_number' => ['required','string','max:50'],
            'address' => ['required','string','max:255'],
            'profile_image' => ['required','image','mimes:jpg,jpeg,png'], // Thêm quy tắc cho trường image
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Vui lòng nhập tên tài xế.',
            'name.string' => 'Tên tài xế phải là chuỗi ký tự.',
            'name.max' => 'Tên tài xế không được vượt quá 255 ký tự.',

            'date_of_birth.required' => 'Vui lòng nhập ngày sinh.',
            'date_of_birth.date' => 'Ngày sinh không đúng định dạng.',

            'email.required' => 'Vui lòng nhập địa chỉ email.',
            'email.string' => 'Email phải là chuỗi ký tự.',
            'email.email' => 'Địa chỉ email không đúng định dạng.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',

            'password.required' => 'Vui lòng nhập mật khẩu.',
            'password.string' => 'Mật khẩu phải là chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất 6 ký tự.',

            'phone.required' => 'Vui lòng nhập số điện thoại.',
            'phone.string' => 'Số điện thoại phải là chuỗi ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá 10 ký tự.',

            'license_number.required' => 'Vui lòng nhập số số bằng lái xe',
            'license_number.string' => 'Số bằng lái phải là chuỗi ký tự.',
            'license_number.max' => 'Số bằng lái không được vượt quá 50 ký tự.',

            'address.required' => 'Vui lòng nhập địa chỉ.',
            'address.string' => 'Địa chỉ phải là chuỗi ký tự.',
            'address.max' => 'Địa chỉ không được vượt quá 255 ký tự.',

            'profile_image.required' => 'Vui lòng nhập file ảnh.',
            'profile_image.image' => 'Tệp tải lên phải là ảnh.',
            'profile_image.mimes' => 'Ảnh phải có định dạng jpg, jpeg, hoặc png.',
        ];
    }
}
