<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBrandRequest extends FormRequest
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
            'name' => 'required|min:3|max:255',
            'description' => 'required|string|max:1000',
            'image' => 'required',
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
            'name.required' => 'Tên thương hiệu không được để trống.',
            'name.min' => 'Tên thương hiệu phải có ít nhất 3 ký tự.',
            'name.max' => 'Tên thương hiệu không được vượt quá 255 ký tự.',
            'image.required' => 'Hình ảnh không được trống.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'description.required' => 'Mô tả không được để trống.',
        ];
    }
}
