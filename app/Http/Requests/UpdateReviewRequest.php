<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateReviewRequest extends FormRequest
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
            'rating' => 'required',
            'comment' => 'required | max:255',
        ];
    }
    public function messages(): array
    {
        return [
            'rating' => 'Bạn yêu thích chúng tôi bao nhiêu',
            'comment' => 'Nhận xét không được để trống',
            'comment.max' => 'Nhận xét không được vượt quá 255 ký tự.',

        ];
    }
}
