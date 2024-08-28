<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AuthenticationRequest extends FormRequest
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
            'email' => 'required|email|exists:users,email',
            'password' => 'required|min:8',
        ];
    }

    public function messages()
    {
        return [
            'email.required' => 'กรุณาระบุที่อยู่อีเมลของคุณ',
            'email.email' => 'รูปแบบอีเมลไม่ถูกต้อง',
            'email.exists' => 'อีเมลหรือรหัสผ่านไม่ถูกต้อง',
            'password.required' => 'กรุณาระบุรหัสผ่านของคุณ',
            'password.min' => 'รหัสผ่านต้องมีความยาวอย่างน้อย 6 ตัวอักษร',
        ];
    }
}
