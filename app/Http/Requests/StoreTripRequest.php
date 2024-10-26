<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTripRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
<<<<<<< HEAD
        return false;
=======
        return true;
>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
<<<<<<< HEAD
            //
=======
            'departure_time' => ['required'],
           
        ];
    }
    public function messages(): array
    {
        return [
            'departure_time.required' => 'Thời gian là bắt buộc.'

>>>>>>> 5e72f5bd298277e513369229af78157ad3271f56
        ];
    }
}
