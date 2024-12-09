<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCategoryRequest extends FormRequest
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
            'parent_id' => 'nullable|integer|exists:categories,id',
            'sort_order' => 'nullable|integer|min:0',
            'image' => 'required|image|mimes:jpg,png,gif,webp|max:2048',
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
            'name.required' => 'Tên danh mục không được để trống.',
            'name.min' => 'Tên danh mục phải có ít nhất 3 ký tự.',
            'name.max' => 'Tên danh mục không được vượt quá 255 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'description.required' => 'Mô tả không được để trống.',
            'parent_id.integer' => 'ID danh mục cha phải là số nguyên.',
            'parent_id.exists' => 'Danh mục cha không tồn tại.',
            'sort_order.integer' => 'Thứ tự sắp xếp phải là một số nguyên.',
            'sort_order.min' => 'Thứ tự sắp xếp không được nhỏ hơn 0.',
            'image.image' => 'File phải là một hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpg, png, gif, hoặc webp.',
            'image.max' => 'Kích thước ảnh không được vượt quá 2MB.',
            'image.required' => 'Hình ảnh không được trống.',
        ];
    }
}
