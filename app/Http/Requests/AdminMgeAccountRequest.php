<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminMgeAccountRequest extends FormRequest
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
            'password' => 'required|string|min:8', // Add more complex rules as needed
            'privilage' => 'required|string|max:50',
        ];
    }

    public function messages()
    {
        return [
            'required' => 'กรุณากรอก :attribute',
            'string' => 'กรุณากรอก :attribute เป็นข้อความ',
            'max' => 'กรุณากรอก :attribute ไม่เกิน :max ตัวอักษร',
            'email' => 'กรุณากรอก :attribute ให้ถูกต้อง',
            'unique' => ':attribute นี้มีอยู่ในระบบแล้ว',
            'min' => 'กรุณากรอก :attribute อย่างน้อย :min ตัว',
        ];
    }
}
