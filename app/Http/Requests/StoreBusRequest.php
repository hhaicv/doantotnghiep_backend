<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBusRequest extends FormRequest
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

            'name_bus' => ['required', 'string','max:255'],
            'model' => ['required', 'string','max:255'],
            'image' => ['required'],
            'license_plate' => ['required' ,'string'],
            'total_seats' => ['required', 'max:100'],
            'phone' => ['required', 'numeric', 'digits_between:8,15'],
            'description' => ['required','string', 'max:255'],
        ];
    }
    public function messages(): array
    {
        return [
            'name_bus.required' => 'Tên xe không được để trống.',
            'image.required' => 'Hình ảnh không được để trống.',
            'name_bus.max' => 'Tên xe không được trên 255 kí tự',

            'model.required' => 'Hãng xe không được để trống.',
            'model.max' => 'Hãng xe không được trên 255.',

            'license_plate.required' => 'Biển số xe không được để trống.',

            'total_seats.required' => 'Số ghế không được bỏ trống.',
            'total_seats.max' => 'Số ghế không để quá 100.',

            'phone.required' => 'Số điện thoại là bắt buộc.',
            'phone.numeric' => 'Số điện thoại phải là một số.',
            'phone.digits_between' => 'Số điện thoại phải có từ 8 đến 15 chữ số.',

            'description.required' => 'Mô tả không được bỏ trống.',
            'description.max' => 'Mô tả không trên 255 số.',
        ];
    }
}
