<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRouteRequest extends FormRequest
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
            'route_name' => ['required', 'string', 'min:6', 'max:255'],
            'route_price' => ['required'],
            'cycle' => ['required'],
            'length' =>  ['required'],
            'description' =>  ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'route_name.required' => 'Tên là bắt buộc.',
            'route_name.min' => 'Tên phải nhiều hơn 6 ký tự.',
            'route_name.max' => 'Tên phải ít hơn 255 kí tự.',
            'description.required' => 'Mô tả là bắt buộc.',
            'route_price.required' => 'Giá tuyến là bắt buộc.',
            'cycle.required' => 'Chu kì là bắt buộc.',
        ];
    }
}
