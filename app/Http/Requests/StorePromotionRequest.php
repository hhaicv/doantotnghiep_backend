<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePromotionRequest extends FormRequest
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

            'code' => ['required', 'string', 'min:5', 'max:20'],
            'discount' => 'required|numeric',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'description' => ['required', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'code.required' => 'Mã giảm giá là bắt buộc.',
            'discount.required' => 'Discount là bắt buộc.',
            'start_date.required' => 'Ngày bắt đầu là bắt buộc.',
            'end_date.required' => 'Ngày kết thúc là bắt buộc.',

            'code.min' => 'Mã giảm giá phải có ít nhất 5 ký tự.',
            'code.max' => 'Mã giảm giá không được vượt quá 255 ký tự.',
            'description.required' => 'Mô tả bắt buộc phải nhập',
        ];
    }
}
