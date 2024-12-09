<?php


namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTopicRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true; // Thay đổi thành true để cho phép tất cả người dùng thực hiện yêu cầu này.
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
            'description' => 'nullable|string',
            'detail' => 'nullable|string',
            'type' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,png,jpeg,gif|max:2048',
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
            'name.required' => 'Tên chủ đề không được để trống.',
            'name.min' => 'Tên chủ đề không dưới 6 kí tự.',
            'image.image' => 'File phải là một hình ảnh.',
            'image.mimes' => 'Ảnh phải có định dạng jpg, png, jpeg, hoặc gif.',
            'image.max' => 'Kích thước ảnh không được vượt quá 2MB.',
            'status.required' => 'Trạng thái là bắt buộc.',
            'status.boolean' => 'Trạng thái phải là true hoặc false.',
        ];
    }
}
