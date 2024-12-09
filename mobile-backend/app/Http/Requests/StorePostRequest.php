<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePostRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'title' => 'required|min:6',  // Sửa 'name' thành 'title'
            'description' => 'required|string',
            'detail' => 'required|string',
            'type' => 'nullable|string',
            'image' => 'required|image|mimes:jpg,png,jpeg,gif|max:2048',
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
            'title.required' => 'Tên tiêu đề không được để trống.',  // Sửa 'name' thành 'title'
            'description.required' => 'Chi tiết không được để trống.',
            'detail.required' => 'Mô tả không được để trống.',  
            'title.min' => 'Tên tiêu đề không dưới 6 kí tự.',  // Sửa 'name' thành 'title'
            'image.image' => 'File phải là một hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpg, png, jpeg, hoặc gif.',
            'image.max' => 'Kích thước ảnh không được vượt quá 2MB.',
            'image.required' => 'Hình ảnh không được trống.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.boolean' => 'Trạng thái phải là true hoặc false.',
        ];
    }
}
