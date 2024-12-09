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
            'promotion_name' => 'required|min:3|max:255',
            'discount_type' => 'required|in:percent,amount',
            'discount_value' => 'required|numeric|min:0',
            'start_date' => 'required|date|before:end_date',
            'end_date' => 'required|date|after:start_date',
        ];
    }

    /**
     * Custom messages for validation errors.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'promotion_name.required' => 'Tên khuyến mãi không được để trống.',
            'promotion_name.min' => 'Tên khuyến mãi phải có ít nhất 3 ký tự.',
            'promotion_name.max' => 'Tên khuyến mãi không được vượt quá 255 ký tự.',
            'discount_type.required' => 'Loại giảm giá không được để trống.',
            'discount_type.in' => 'Loại giảm giá phải là "percent" hoặc "amount".',
            'discount_value.required' => 'Giá khuyến mãi không được để trống.',
            'discount_value.numeric' => 'Giá khuyến mãi phải là một số.',
            'discount_value.min' => 'Giá khuyến mãi phải lớn hơn hoặc bằng 0.',
            'start_date.required' => 'Thời gian bắt đầu không được để trống.',
            'start_date.date' => 'Thời gian bắt đầu phải là một ngày hợp lệ.',
            'start_date.before' => 'Thời gian bắt đầu phải trước thời gian kết thúc.',
            'end_date.required' => 'Thời gian kết thúc không được để trống.',
            'end_date.date' => 'Thời gian kết thúc phải là một ngày hợp lệ.',
            'end_date.after' => 'Thời gian kết thúc phải sau thời gian bắt đầu.',
        ];
    }
}
