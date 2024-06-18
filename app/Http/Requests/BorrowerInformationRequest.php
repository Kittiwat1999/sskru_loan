<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class BorrowerInformationRequest extends FormRequest
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
            "email" =>'required|email|unique:users,email|max:255',
            "phone" => 'required|string|max:50',

            "properties" => 'required',
            "nessessities" => 'required',
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
            'email.unique' => 'email นี้มีอยู่ในระบบแล้ว',
            "phone.required" => 'ต้องระบุเบอร์โทร',
            "phone.max" => 'เบอร์โทรศัพท์ต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',

            "properties.required" => 'ต้องระบุคุณสมบัตรผู้กู้',
            "nessessities.required" => 'ต้องระบุเหตุผลตวามจำเป็นในการกู้ยืม',
        ];
    }
}
