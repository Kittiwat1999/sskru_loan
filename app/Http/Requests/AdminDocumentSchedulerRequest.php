<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class AdminDocumentSchedulerRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true; // Modify this as per your authorization logic
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "term" => "required|string|max:1",
            "year" => "required|string|max:4",
            "doctype_id" => "required|string|max:10",
            "child_documents.*" => "required",
            "start_date" => "required|string",
            "end_date" => "required|string",
            "need_useful_activity" => "string",
            "need_teacher_comment" => "string",
            "description" => "nullable|string",
        ];
    }

    /**
     * Get the error messages for the defined validation rules.
     *
     * @return array
     */
    public function messages()
    {
        return [
            'term.required' => 'กรุณากรอกภาคเรียน',
            'term.string' => 'ค่าที่กรอกต้องเป็นข้อความ',
            'term.max' => 'ความยาวของข้อความต้องไม่เกิน :max ตัวอักษร',
            'year.required' => 'กรุณากรอกปีการศึกษา',
            'year.string' => 'ค่าที่กรอกต้องเป็นข้อความ',
            'year.max' => 'ความยาวของข้อความต้องไม่เกิน :max ตัวอักษร',
            'doctype_id.required' => 'กรุณาเลือกเอกสาร',
            'doctype_id.string' => 'ค่าที่เลือกต้องเป็นข้อความ',
            'doctype_id.max' => 'ความยาวของข้อความต้องไม่เกิน :max ตัวอักษร',
            'child_documents.*.required' => 'กรุณาเลือกเอกสาร',
            'start_date.required' => 'กรุณากรอกวันที่เริ่มต้นการส่งเอกสาร',
            'start_date.string' => 'ค่าที่กรอกต้องเป็นข้อความ',
            'end_date.required' => 'กรุณากรอกวันที่สิ้นสุดการส่งเอกสาร',
            'end_date.string' => 'ค่าที่กรอกต้องเป็นข้อความ',
            'need_useful_activity.string' => 'ค่าที่กรอกต้องเป็นข้อความ',
            'need_teacher_comment.string' => 'ค่าที่กรอกต้องเป็นข้อความ',
            'description.string' => 'ค่าที่กรอกต้องเป็นข้อความ',
            'description.nullable' => 'ค่าที่กรอกต้องเป็นข้อความ',
        ];
    }
}
