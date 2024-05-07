<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class borrowerInformationValidationRequest extends FormRequest
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
            'borrower_appearance' => 'required|string|max:100',
            'prefix' => 'required|string|max:10',
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
            'birthday' => 'required|string|max:20',
            'citizen_id' => 'required|string|max:50',
            'student_id' => 'required|string|max:50',
            'faculty' => 'required|string|max:100',
            'major' => 'required|string|max:100',
            'grade' => 'required|string|max:10',
            'gpa' => 'required|string|max:10',

            'village' => 'required|string|max:50',
            "house_no" => 'required|string|max:20',
            "village_no" => 'required|string|max:20',
            "street" => 'nullable|string|max:100',
            "road" => 'nullable|string|max:100',
            "postcode" => 'required|string|max:10',
            "province" => 'required|string|max:50',
            "aumphure" => 'required|string|max:50',
            "tambon" => 'required|string|max:50',
            "email" =>'required|email|max:255',
            "phone" => 'required|string|max:50',

            "properties" => 'required',
            "nessessities" => 'required',

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

            "main_parent" => 'required|string|max:50',
            
            "address_with_borrower"=>'string:max:20',

            "main_parent_village" => 'nullable|string|max:50',
            "main_parent_house_no" => 'nullable|string|max:20',
            "main_parent_village_no" => 'nullable|string|max:20',
            "main_parent_street" => 'nullable|string|max:100',
            "main_parent_road" => 'nullable|string|max:100',
            "main_parent_postcode" => 'nullable|string|max:10',
            "main_parent_province" => 'nullable|string|max:50',
            "main_parent_aumphure" => 'nullable|string|max:50',
            "main_parent_tambon" => 'nullable|string|max:50',

            "marital_status" => 'required|string',
            "other_text"=>'nullable|string|max:50',

            "parent2_no_data" => 'nullable|string|max:10'
        ];
    }

    public function messages()
    {
        return [
            
            'borrower_appearance.required' => 'ต้องระบุประเภทผู้กู้',
            'borrower_appearance.max' => 'ประเภทผู้กู้ต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
            'prefix.required' => 'ต้องระบุคำนำหน้าชื่อ',
            'prefix.max' => 'คำนำหน้าชื่อต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            'firstname.required' => 'ต้องกรอกชื่อจริง',
            'firstname.max' => 'ชื่อจริงต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            'lastname.required' => 'ต้องกรอกนามสกุล',
            'lastname.max' => 'นามสกุลต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            'birthday.required' => 'ต้องกรอกวันเกิด',
            'birthday.max' => 'วันที่ไม่ถูกต้อง',
            'citizen_id.required' => 'ต้องกรอกเลขบัตรประชาชน',
            'citizen_id.max' => 'เลขบัตรประชาชนต้องมีครวามยาวไม่เกิน 13 ตัวอักษร',
            'student_id.required' => 'ต้องกรอกเลขประจำตัวนักศึกษา',
            'student_id.max' => 'เลขประจำตัวนักศึกษาต้องมีครวามยาวไม่เกิน 13 ตัวอักษร',
            'faculty.required' => 'ต้องกรอกคณะ',
            'faculty.max' => 'คณะต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
            'major.required' => 'ต้องกรอกสาขา',
            'major.max' => 'คณะต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
            'grade.required' => 'ต้องกรอกชั้นปี',
            'grade.max' => 'ชั้นปีต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
            'gpa.required' => 'ต้องกรอกคณะผลการเรียน',
            'gpa.max' => 'ผลการเรียนต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',

            'village.required' => 'ต้องกรอกชื่อหมู่บ้าน',
            'village.max' => 'ชื่อหมู่บ้านต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "house_no.required" => 'ต้องกรอกบ้านเลขที่',
            "house_no.max" => 'บ้านเลขที่ต้องไม่เกิน 20 ตัวอักษร',
            "village_no.required" => 'ต้องกรอกเลขหมู่บ้าน',
            "village_no.max" => 'เลขหมู่บ้านต้องไม่เกิน 20 ตัวอักษร',
            "street.max" => 'ซอยต้องไม่เกิน 100 ตัวอักษร',
            "road.max" => 'ถนนต้องไม่เกิน 100 ตัวอักษร',
            "postcode.required" => 'ต้องระบุเลขไปรษณีย์',
            "postcode.max" => 'เลขไปรษณีย์ต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
            "province.required" => 'ต้องระบุจังหวัด',
            "aumphure.max" => 'จังหวัดต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "aumphure.required" => 'ต้องระบุอำเภอ',
            "aumphure.max" => 'อำเภอต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "tambon.required" => 'ต้องระบุตำบล',
            "tambon.max" => 'ตำบลต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            'email.required' => 'กรุณากรอก email',
            'email.email' => 'รูปแบบ email ไม่ถูกต้อง',
            'email.max' => 'ความยาวของ email ต้องไม่มากกว่า 255 ตัวอักษร',
            "phone.required" => 'ต้องระบุเบอร์โทร',
            "phone.max" => 'เบอร์โทรศัพท์ต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',

            "properties.required" => 'ต้องระบุคุณสมบัตรผู้กู้',
            "nessessities.required" => 'ต้องระบุเหตุผลตวามจำเป็นในการกู้ยืม',

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

            "main_parent.required" => 'ต้องเลือกผู้เเทนโดยชอบธรรม',
            "main_parent.max" => 'ผู้เเทนโดยชอบธรรมต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            
            "address_with_borrower"=>'ต้องมีครวามยาวไม่เกิน 20 ตัวอักษร',

            'main_parent_village.max' => 'ชื่อหมู่บ้านต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "main_parent_house_no.max" => 'บ้านเลขที่ต้องไม่เกิน 20 ตัวอักษร',
            "main_parent_village_no.max" => 'เลขหมู่บ้านต้องไม่เกิน 20 ตัวอักษร',
            "main_parent_street.max" => 'ซอยต้องไม่เกิน 100 ตัวอักษร',
            "main_parent_road.max" => 'ถนนต้องไม่เกิน 100 ตัวอักษร',
            "main_parent_postcode.max" => 'เลขไปรษณีย์ต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
            "main_parent_aumphure.max" => 'จังหวัดต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "main_parent_aumphure.max" => 'อำเภอต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "main_parent_tambon.max" => 'ตำบลต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',

            "marital_status.required" => 'ต้องระบุสถานะสมรสผู้ปกครอง',
            "other_text"=>'สถานภาพอื่นๆต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
        ];
    }
}
