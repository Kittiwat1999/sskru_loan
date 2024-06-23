<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserMgeAccountRequest extends FormRequest
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
            'username' => 'required|string|unique:users,username|max:255',
            'email' => 'required|email|unique:users,email|max:255',
            'password' => 'required|string|min:8', // Add more complex rules as needed
        ];
    }

    public function messages()
    {
        return [
            'prefix.required' => 'กรุณาเลือกคำนำหน้า',
            'firstname.required' => 'กรุณากรอกชื่อจริง',
            'firstname.string' => 'กรุณากรอกชื่อจริงเป็นข้อความ',
            'firstname.max' => 'กรุณากรอกชื่อจริงไม่เกิน :max ตัวอักษร',
            'lastname.required' => 'กรุณากรอกนามสกุล',
            'lastname.string' => 'กรุณากรอกนามสกุลเป็นข้อความ',
            'lastname.max' => 'กรุณากรอกนามสกุลไม่เกิน :max ตัวอักษร',
            'username.required' => 'กรุณากรอกชื่อผู้ใช้',
            'username.string' => 'กรุณากรอกชื่อผู้ใช้เป็นข้อความ',
            'username.unique' => 'ชื่อผู้ใช้นี้มีอยู่ในระบบแล้ว',
            'username.max' => 'กรุณากรอกชื่อผู้ใช้ไม่เกิน :max ตัวอักษร',
            'email.required' => 'กรุณากรอกอีเมล',
            'email.email' => 'กรุณากรอกอีเมลเป็นข้อความ',
            'email.unique' => 'อีเมลนี้มีอยู่ในระบบแล้ว',
            'email.max' => 'กรุณากรอกอีเมลไม่เกิน :max ตัวอักษร',
            'password.required' => 'กรุณากรอกรหัสผ่าน',
            'password.string' => 'กรุณากรอกรหัสผ่านเป็นข้อความ',
            'password.min' => 'กรุณากรอกรหัสผ่านอย่างน้อย :min ตัวอักษร',
        ];
    }
}
