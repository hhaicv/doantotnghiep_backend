<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInformationRequest extends FormRequest
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

            'title' => ['required', 'string', 'min:6', 'max:255'],
            'summary' => ['required', 'string', 'min:6', 'max:255'],
            'thumbnail_image' => ['required','image ','mimes:jpeg,png,jpg,gif,svg', 'max:255'],
            'content' => ['required', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Bắt buộc phải nhập tiêu đề ',
            'title.min' => 'Tiêu đề phải có ít nhất 6 ký tự.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'summary.required' => 'Tóm tắt không được bỏ trống ',
            'summary.min' => 'Tóm tắt phải có ít nhất 6 ký tự.',
            'summary.max' => 'Tóm tắt không được vượt quá 255 ký tự.',
            'thumbnail_image.required' => 'Hình ảnh không được bỏ trống ',
            'thumbnail_image.min' => 'Hình ảnh phải có ít nhất 6 ký tự.',
            'thumbnail_image.max' => 'Hình ảnh không được vượt quá 255 ký tự.',
            'content.required' => 'Nội dung không được bỏ trống',
        ];
    }
}
