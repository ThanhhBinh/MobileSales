<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePaymentRequest extends FormRequest
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
            'payment_method' => 'required|string|max:255',
            'amount' => 'required|numeric|min:0',
            'status' => 'required|in:1,2',
        ];
    }

    /**
     * Get the custom messages for validator errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'payment_method.required' => 'Tên phương thức thanh toán không được để trống.',
            'payment_method.string' => 'Tên phương thức thanh toán phải là chuỗi ký tự.',
            'payment_method.max' => 'Tên phương thức thanh toán không được vượt quá 255 ký tự.',
            'amount.required' => 'Giá không được để trống.',
            'amount.numeric' => 'Giá phải là số.',
            'amount.min' => 'Giá không được nhỏ hơn 0.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái phải là 1 (Xuất bản) hoặc 2 (Chưa xuất bản).',
        ];
    }
}
