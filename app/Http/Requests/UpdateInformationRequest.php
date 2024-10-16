<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInformationRequest extends FormRequest
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
            'content' => ['required', 'string'],
        ];
    }
    public function messages(): array
    {
        return [
            'title.required' => 'Tiêu đề là bắt buộc.',
            'title.min' => 'Tiêu đề phải có ít nhất 6 ký tự.',
            'title.max' => 'Tiêu đề không được vượt quá 255 ký tự.',
            'summary.required' => 'Tóm tắt là bắt buộc.',
            'summary.min' => 'Tóm tắt phải có ít nhất 6 ký tự.',
            'summary.max' => 'Tóm tắt không được vượt quá 255 ký tự.',
            'content.required' => 'Nội dung bắt buộc phải nhập',
        ];
    }
}
