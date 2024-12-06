<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateBannerRequest extends FormRequest
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
            'image_url' => 'nullable|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'link' => 'required|string|max:255',
            'start_date' => 'required|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'status' => 'nullable|boolean',
        ];
    }
    public function messages(): array
    {
        return [
            'image_url.image' => 'Ảnh phải có định dạng hợp lệ (jpeg, png, jpg, gif, svg).',
            'image_url.mimes' => 'Ảnh phải thuộc một trong các định dạng sau: jpeg, png, jpg, gif, svg.',
            'image_url.max' => 'Kích thước ảnh không được vượt quá 2MB.',
            'link.required' => 'Link không được để trống.',
            'link.max' => 'Link không được vượt quá 255 ký tự.',
            'start_date.required' => 'Ngày bắt đầu không được để trống.',
            'start_date.date' => 'Ngày bắt đầu phải là định dạng ngày hợp lệ.',
            'end_date.date' => 'Ngày kết thúc phải là định dạng ngày hợp lệ.',
            'end_date.after_or_equal' => 'Ngày kết thúc phải sau hoặc bằng ngày bắt đầu.',
            'status.boolean' => 'Trạng thái phải là kiểu boolean (1 hoặc 0).',
        ];
    }
}
