<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UsefulActivityRequest extends FormRequest
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
            'activity_name' => 'required|string|max:50',
            'activity_location' => 'required|string|max:50',
            'start_date' => 'required|date_format:d-m-Y H:i',
            'end_date' => 'required|date_format:d-m-Y H:i|after:start_date',
            'hour_count' => 'required|numeric|min:0',
            'description' => 'required|string|max:255'
        ];
    }

    public function messages(){
        return [
            'activity_name.required' => 'กรุณากรอกชื่อกิจกรรม',
            'activity_name.string' => 'ชื่อกิจกรรมมีรูปแบบข้อมูลไม่ถูกต้อง',
            'activity_name.max' => 'ชื่อกิจกรรมต้องไม่เกิน 50 ตัวอักษร',
    
            'activity_location.required' => 'กรุณากรอกสถานที่จัดกิจกรรม',
            'activity_location.string' => 'สถานที่จัดกิจกรรมมีรูปแบบข้อมูลไม่ถูกต้อง',
            'activity_location.max' => 'สถานที่จัดกิจกรรมต้องไม่เกิน 50 ตัวอักษร',
    
            'start_date.required' => 'กรุณากรอกวันเริ่มต้น',
            'start_date.date_format' => 'วันเริ่มต้นต้องอยู่ในรูปแบบ d-m-Y H:i',
    
            'end_date.required' => 'กรุณากรอกวันสิ้นสุด',
            'end_date.date_format' => 'วันสิ้นสุดต้องอยู่ในรูปแบบ d-m-Y H:i',
            'end_date.after' => 'วันสิ้นสุดต้องอยู่หลังจากวันเริ่มต้น',
    
            'hour_count.required' => 'กรุณากรอกจำนวนชั่วโมง',
            'hour_count.numeric' => 'จำนวนชั่วโมงต้องเป็นตัวเลข',
            'hour_count.min' => 'จำนวนชั่วโมงต้องไม่น้อยกว่า 0',
    
            'description.required' => 'กรุณากรอกรายละเอียด',
            'description.string' => 'รายละเอียดต้องเป็นตัวอักษร',
            'description.max' => 'รายละเอียดต้องไม่เกิน 255 ตัวอักษร',
        ];
    }
}
