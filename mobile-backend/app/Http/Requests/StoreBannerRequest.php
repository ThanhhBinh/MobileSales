<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreBannerRequest extends FormRequest
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
            'name' => 'required|min:6',
            'description' => 'nullable|string|max:1000',
            'link' => 'required|url',
            'image' => 'required|image|mimes:png,jpg,jpeg,gif,webp|max:2048',
            'status' => 'required|boolean',
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
            'name.required' => 'Tên banner không được để trống.',
            'name.min' => 'Tên banner phải có ít nhất 6 ký tự.',
            'description.max' => 'Mô tả không được vượt quá 1000 ký tự.',
            'link.required' => 'Liên kết phải không được trống.',
            'link.url' => 'Liên kết phải là URL hợp lệ.',
            'image.image' => 'File phải là hình ảnh.',
            'image.mimes' => 'Hình ảnh phải có định dạng png, jpg, jpeg, gif hoặc webp.',
            'image.max' => 'Kích thước hình ảnh không được vượt quá 2MB.',
            'image.required' => 'Hình ảnh không được trống.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.boolean' => 'Trạng thái phải là true hoặc false.',
        ];
    }
}
