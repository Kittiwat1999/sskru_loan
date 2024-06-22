<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MainParentInformationRequest extends FormRequest
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
        ];
    }

    public function messages()
    {
        return [
            'main_parent_village.max' => 'ชื่อหมู่บ้านต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "main_parent_house_no.max" => 'บ้านเลขที่ต้องไม่เกิน 20 ตัวอักษร',
            "main_parent_village_no.max" => 'เลขหมู่บ้านต้องไม่เกิน 20 ตัวอักษร',
            "main_parent_street.max" => 'ซอยต้องไม่เกิน 100 ตัวอักษร',
            "main_parent_road.max" => 'ถนนต้องไม่เกิน 100 ตัวอักษร',
            "main_parent_postcode.max" => 'เลขไปรษณีย์ต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
            "main_parent_aumphure.max" => 'จังหวัดต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "main_parent_aumphure.max" => 'อำเภอต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            "main_parent_tambon.max" => 'ตำบลต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
        ];
    }
}
