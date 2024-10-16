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
            'start_route' => ['required', 'string', 'min:6', 'max:255'],
            'end_route' => ['required', 'string', 'min:6', 'max:255'],
            'execution_time' => ['required', 'numeric'],
           'base_fare_per_km' => ['required', 'regex:/^\d{1,6}(\.\d{1,2})?$/'],
            'distance_km' =>  ['required', 'regex:/^\d{1,6}(\.\d{1,2})?$/']
        ];

    }
    public function messages(): array
    {
        return [
         
            'route_name.required' => 'Tên là bắt buộc.',
            'route_name.min' => 'Tên phải nhiều hơn 6 ký tự.',
            'route_name.max' => 'Tên phải ít hơn 255 kí tự.',
            
            
            'start_route.required' => 'Điểm bắt đầu là bắt buộc.',
            'start_route.min' => 'Điểm bắt đầu phải nhiều hơn 6 ký tự.',
            'start_route.max' => 'Điểm bắt đầu phải ít hơn 255 kí tự.',
            
            
            'end_route.required' => 'Điểm kết thúc là bắt buộc.',
            'end_route.min' => 'Điểm kết thúc phải nhiều hơn 6 ký tự.',
            'end_route.max' => 'Điểm kết thúc phải ít hơn 255 kí tự.',
            
            
            'execution_time.required' => 'Thời gian bắt buộc phải nhập.',
            'execution_time.numeric' => 'Thời gian bắt buộc phải là số.',
            
            
            'base_fare_per_km.required' => 'Hệ số bắt buộc phải nhập.',
            'base_fare_per_km.regex' => 'Hệ số bắt buộc phải số.',
            
            'distance_km.required' => 'Số Km bắt buộc phải nhập.',
            'distance_km.regex' => 'Số Km bắt buộc phải số.',
        ];
    }
}
