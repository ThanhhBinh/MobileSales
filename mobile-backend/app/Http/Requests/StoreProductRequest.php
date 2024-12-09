<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreProductRequest extends FormRequest
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
     * @return array
     */
    public function rules(): array
    {
        return [
            'name' => 'required|string|max:255',
        ];
    }

    /**
     * Custom error messages for validation.
     *
     * @return array
     */
    public function messages(): array
    {
        return [
            'product_name.required' => 'Tên sản phẩm không được để trống.',
            'description.max' => 'Mô tả không được vượt quá 1000 kí tự.',
            'price.required' => 'Giá sản phẩm là bắt buộc.',
            'price.numeric' => 'Giá sản phẩm phải là một số.',
            'discount.numeric' => 'Giảm giá phải là một số.',
            'discount.max' => 'Giảm giá không được vượt quá 100.',
            'rating.numeric' => 'Đánh giá phải là một số.',
        ];
    }
}
