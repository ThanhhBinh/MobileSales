<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'username' => 'required|string|max:255',
            'gender' => 'required|string|max:10',
            'phone' => 'required|string|max:20',
            'email' => 'required|email|max:255|unique:users',
            'roles' => 'required|string|max:50',
            'password' => 'required|string|min:8|confirmed', // Đảm bảo mật khẩu và xác nhận mật khẩu
            'image' => 'nullable|file|mimes:png,jpg,jpeg,gif,webp|max:2048', // Xác thực hình ảnh
            'status' => 'required|in:1,2'
        ];
    }

    /**
     * Get the custom validation messages for attributes.
     *
     * @return array<string, string>
     */
    public function messages(): array
    {
        return [
            'name.required' => 'Tên người dùng không được để trống.',
            'name.string' => 'Tên người dùng phải là một chuỗi ký tự.',
            'name.max' => 'Tên người dùng không được vượt quá 255 ký tự.',
            'username.required' => 'Tên tài khoản không được để trống.',
            'username.string' => 'Tên tài khoản phải là một chuỗi ký tự.',
            'username.max' => 'Tên tài khoản không được vượt quá 255 ký tự.',
            'gender.required' => 'Giới tính không được để trống.',
            'gender.string' => 'Giới tính phải là một chuỗi ký tự.',
            'gender.max' => 'Giới tính không được vượt quá 10 ký tự.',
            'phone.required' => 'Số điện thoại không được để trống.',
            'phone.string' => 'Số điện thoại phải là một chuỗi ký tự.',
            'phone.max' => 'Số điện thoại không được vượt quá 20 ký tự.',
            'email.required' => 'Email không được để trống.',
            'email.email' => 'Email không hợp lệ.',
            'email.max' => 'Email không được vượt quá 255 ký tự.',
            'email.unique' => 'Email đã được sử dụng.',
            'roles.required' => 'Quyền không được để trống.',
            'roles.string' => 'Quyền phải là một chuỗi ký tự.',
            'roles.max' => 'Quyền không được vượt quá 50 ký tự.',
            'password.required' => 'Mật khẩu không được để trống.',
            'password.string' => 'Mật khẩu phải là một chuỗi ký tự.',
            'password.min' => 'Mật khẩu phải có ít nhất 8 ký tự.',
            'password.confirmed' => 'Xác nhận mật khẩu không khớp.',
            'image.file' => 'Hình ảnh phải là một tập tin.',
            'image.mimes' => 'Hình ảnh phải có định dạng png, jpg, jpeg, gif, hoặc webp.',
            'image.max' => 'Hình ảnh không được vượt quá 2MB.',
            'status.required' => 'Trạng thái không được để trống.',
            'status.in' => 'Trạng thái không hợp lệ.'
        ];
    }
}
