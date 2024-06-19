<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ParentInformationRequest extends FormRequest
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
            "parent1_is_thai" => 'required|string|max:50',
            "parent1_nationality" => 'nullable|string|max:50',
            "parent1_alive" => 'required|string|max:10',
            "parent1_relational" => 'required|string|max:20',
            "parent1_prefix" => 'required|string|max:50',
            "parent1_firstname" => 'required|string|max:100',
            "parent1_lastname" => 'required|string|max:100',
            "parent1_birthday" => 'required|string|max:20',
            "parent1_citizen_id" => 'required|string|max:50',
            "parent1_phone" => 'required|string|max:50',
            "parent1_email" => 'required|string|max:100',
            "parent1_occupation" => 'required|string|max:100',
            "parent1_place_of_work" => 'required|string|max:100',
            "parent1_income" => 'required|string|max:50',

            "parent2_is_thai" => 'nullable|string|max:50',
            "parent2_nationnality" => 'nullable|string|max:50',
            "parent2_alive" => 'nullable|string|max:10',
            "parent2_relational" => 'nullable|string|max:20',
            "parent2_prefix" => 'nullable|string|max:50',
            "parent2_firstname" => 'nullable|string|max:100',
            "parent2_lastname" => 'nullable|string|max:100',
            "parent2_birthday" => 'nullable|string|max:20',
            "parent2_citizen_id" => 'nullable|string|max:50',
            "parent2_phone" => 'nullable|string|max:50',
            "parent2_email" => 'nullable|string|max:100',
            "parent2_occupation" => 'nullable|string|max:100',
            "parent2_place_of_work" => 'nullable|string|max:100',
            "parent2_income" => 'nullable|string|max:50',

            "marital_status" => 'required|string',
            "other_text"=>'nullable|string|max:50',

            "parent2_no_data" => 'nullable|string|max:10'
        ];
    }

    public function messages(){
        return [
            "parent1_is_thai.required" => 'ต้องระบุสัญชาติผู้ปกครอง',
            "parent1_is_thai.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "parent1_nationnality.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "parent1_alive.required" => 'ต้องระบุว่าผู้ปกครองมีชีวิตอยู่หรือเสียชีวิต',
            "parent1_alive.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
            "parent1_relational.required" => 'ต้องระบุความสัมพันธ์ของผู้กู้กับผู้ปกครอง',
            "parent1_relational.max" => 'ความสัมพันธ์ของผู้กู้กับผู้ปกครองต้องมีครวามยาวไม่เกิน 20 ตัวอักษร',
            'parent1_prefix.required' => 'ต้องระบุคำนำหน้าชื่อผู้ปกครอง',
            'parent1_prefix.max' => 'คำนำหน้าชื่อผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            'parent1_firstname.required' => 'ต้องกรอกชื่อจริงผู้ปกครอง',
            'parent1_firstname.max' => 'ชื่อจริงผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            'parent1_lastname.required' => 'ต้องกรอกนามสกุลผู้ปกครอง',
            'parent1_lastname.max' => 'นามสกุลผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            'parent1_birthday.required' => 'ต้องกรอกวันเกิดผู้ปกครอง',
            'parent1_birthday.max' => 'วันเกิดผู้ปกครองไม่ถูกต้อง',
            'parent1_citizen_id.required' => 'ต้องกรอกเลขบัตรประชาชนผู้ปกครอง',
            'parent1_citizen_id.max' => 'เลขบัตรประชาชนผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "parent1_phone.required" => 'ต้องระบุเบอร์โทรผู้ปกครอง',
            "parent1_phone.max" => 'เบอร์โทรศัพท์ผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "parent1_email.required" => 'ต้องระบุอีเมลล์โทรผู้ปกครอง',
            "parent1_email.max" => 'อีเมลล์ผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
            "parent1_occupation.required" => 'ต้องระบุอาชีพผู้ปกครอง',
            "parent1_occupation.max" => 'อาชีพผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
            "parent1_place_of_work.required" => 'ต้องระบุสถานที่ทำงานผู้ปกครอง',
            "parent1_place_of_work.max" => 'สถานที่ทำงานผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
            "parent1_income.required" => 'ต้องระบุรายได้ผู้ปกครอง',
            "parent1_income.max" => 'รายได้ผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',

            "parent2_is_thai.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "parent2_nationnality.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "parent2_alive.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
            "parent2_relational.max" => 'ความสัมพันธ์ของผู้กู้กับผู้ปกครองต้องมีครวามยาวไม่เกิน 20 ตัวอักษร',
            "parent2_prefix.max" => 'คำนำหน้าชื่อต้องผู้ปกครองมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "parent2_firstname.max" => 'ชื่อจริงผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "parent2_lastname.max" => 'นามสกุลผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "parent2_birthday.max" => 'วันเกิดผู้ปกครองไม่ถูกต้อง',
            "parent2_citizen_id.max" => 'เลขบัตรประชาชนผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "parent2_phone.max" => 'เบอร์โทรศัพท์ผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "parent2_email.max" => 'อีเมลล์ผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
            "parent2_place_of_work.max" => 'สถานที่ทำงานผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
            "parent2_occupation.max" => 'อาชีพผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
            "parent2_income.max" => 'รายได้ผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',

            "marital_status.required" => 'ต้องระบุสถานะสมรสผู้ปกครอง',
            "other_text.max"=>'สถานภาพอื่นๆต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "parent2_no_data.max" => 'ค่าไม่ตรงกับที่ระบบกำหนด ครวามยาวไม่เกิน 50 ตัวอักษร',

        ];
    }
}
