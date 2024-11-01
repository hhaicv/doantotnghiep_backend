<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTicketBookingRequest extends FormRequest
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
            'name' => ['required'],
            'total_amount' => ['required'],
            'phone' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'name.required' => 'Cần phải nhập tên hành khách.',
            'total_amount.required' => 'Bạn cần chọn ghế để thanh toán.',
            'phone.required' => 'Cần phải nhập số điện thoại.',
        ];
    }
}
