<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [

            'start_time' => ['required'],
            'end_time' => ['required'],
        ];
    }
    public function messages(): array
    {
        return [
            'start_time' => 'Không để trống thời gian bắt đầu',
            'end_time' => 'Không để trống thời gian kết thúc',
        ];
    }
}
