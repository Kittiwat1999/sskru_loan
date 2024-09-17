<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StudentRegisterRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'prefix' => 'required|string|max:30',
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8|confirmed', // Add more complex rules as needed
        ];
    }

    public function messages()
    {
        return [
            'prefix.required' => 'กรุณาใส่คำนำหน้า',
            'firstname.required' => 'กรุณากรอกชื่อจริง',
            'firstname.string' => 'กรุณากรอกชื่อจริงเป็นข้อความ',
            'firstname.max' => 'กรุณากรอกชื่อจริงไม่เกิน :max ตัวอักษร',
            'lastname.required' => 'กรุณากรอกนามสกุล',
            'lastname.string' => 'กรุณากรอกนามสกุลเป็นข้อความ',
            'lastname.max' => 'กรุณากรอกนามสกุลไม่เกิน :max ตัวอักษร',
            'email.required' => 'กรุณากรอกอีเมล',
            'email.email' => 'กรุณากรอกรูปแบบอีเมลที่ถูกต้อง',
            'email.unique' => 'อีเมลนี้มีอยู่ในระบบแล้ว',
            'email.max' => 'กรุณากรอกอีเมลไม่เกิน :max ตัวอักษร',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.string' => 'กรุณากรอกรหัสผ่านเป็นข้อความ',
            'password.min' => 'กรุณากรอกรหัสผ่านอย่างน้อย :min ตัวอักษร',
            'password.confirmed' => 'รหัสผ่านไม่ตรงกัน',
        ];
    }
}
