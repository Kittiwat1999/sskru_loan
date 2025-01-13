<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParentInformationRequest;
use App\Models\Address;
use App\Models\Borrower;
use App\Models\Config;
use App\Models\Parents;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;
use setasign\Fpdi\Fpdi;
use iio\libmergepdf\Merger;

class ParentInformationController extends Controller
{

    private function convert_date($inputDate)
    {
        $parsedDate = Carbon::createFromFormat('d-m-Y', $inputDate);
        $isoDate = $parsedDate->format('Y-m-d');
        return $isoDate;
    }

    public function deleteFile($file_path, $file_name)
    {
        $path = storage_path($file_path . '/' . $file_name);
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    private function storeFile($file_path, $file)
    {
        $path = storage_path($file_path);
        !file_exists($path) && mkdir($path, 0777, true);
        $name = now()->format('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
        $file->move($path, $name);
        return $name;
    }

    public function displayFile($file_path, $file_name)
    {
        $path = storage_path($file_path . '/' . $file_name);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public function display_marital_status_file(Request $request, $file_name)
    {
        $user_id = $request->session()->get('user_id', '1');
        $marital_status_path = Config::where('variable', 'marital_file_path')->value('value');
        $reqsonse = $this->displayFile($marital_status_path . '/' . $user_id, $file_name);
        return $reqsonse;
    }

    public function borrower_input_parent_information()
    {
        return view('borrower.information.parent_input_information');
    }

    public function borrower_edit_parent_information_page(Request $request,)
    {
        $user_id = $request->session()->get('user_id', '1');
        $borrower = Borrower::where('user_id', $user_id)->select('id', 'marital_status', 'student_id', 'address_id')->first();
        $parent = Parents::where('borrower_id', $borrower['id'])->where('main_parent_only', false)->get();
        $borrower_id = $borrower['id'];
        $student_id = $borrower['student_id'];
        // dd($borrower['student_id']);
        $marital_status = json_decode($borrower['marital_status']);
        $parent_count = count($parent);

        $parent1_address = Address::find($parent[0]['address_id']);
        $parent1_address['with_borrower'] = ($borrower['address_id'] == $parent[0]['address_id']) ? true : false;
        $parent2_dont_have_data = ($parent_count > 1) ? false : true;
        if (!$parent2_dont_have_data) {
            $parent2_address = Address::find($parent[1]['address_id']);
            $parent2_address['with_borrower']  = ($borrower['address_id'] == $parent[1]['address_id']) ? true : false;
        }else{
            $parent2_address = [];
            $parent2_address['with_borrower']  = false;
        }

        foreach ($parent as $feild) {
            $feild['citizen_id'] = Crypt::decryptString($feild['citizen_id']);
        }

        return view('borrower.information.parent_edit_information', compact('parent', 'parent2_dont_have_data', 'marital_status', 'student_id', 'parent1_address', 'parent2_address',));
    }

    public function borrower_store_parent_information(ParentInformationRequest $request)
    {
        // dd($request);
        date_default_timezone_set("Asia/Bangkok");
        $user_id = $request->session()->get('user_id', '1');
        $borrower = Borrower::where('user_id', $user_id)->first();

        //เช็คว่าที่อยู่เดียวกับผู้กู้มั้ย
        if (isset($request->parent1_address_with_borrower)) {
            $parent1_address_id = $borrower->address_id;
        } else {

            $request->validate([
                "parent1_village" => 'required|string|max:50',
                "parent1_house_no" => 'required|string|max:20',
                "parent1_village_no" => 'required|string|max:20',
                "parent1_street" => 'required|string|max:100',
                "parent1_road" => 'required|string|max:100',
                "parent1_postcode" => 'required|string|max:10',
                "parent1_province" => 'required|string|max:50',
                "parent1_aumphure" => 'required|string|max:50',
                "parent1_tambon" => 'required|string|max:50',
            ], [

                "parent1_village.required" => 'ต้องกรอกชื่อหมู่บ้าน',
                "parent1_village.max" => 'ชื่อหมู่บ้านต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent1_house_no.required" => 'ต้องกรอกบ้านเลขที่',
                "parent1_house_no.max" => 'บ้านเลขที่ต้องไม่เกิน 20 ตัวอักษร',
                "parent1_village_no.required" => 'ต้องกรอกเลขหมู่บ้าน',
                "parent1_village_no.max" => 'เลขหมู่บ้านต้องไม่เกิน 20 ตัวอักษร',
                "parent1_street.max" => 'ซอยต้องไม่เกิน 100 ตัวอักษร',
                "parent1_road.max" => 'ถนนต้องไม่เกิน 100 ตัวอักษร',
                "parent1_postcode.required" => 'ต้องระบุเลขไปรษณีย์',
                "parent1_postcode.max" => 'เลขไปรษณีย์ต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
                "parent1_province.required" => 'ต้องระบุจังหวัด',
                "parent1_aumphure.max" => 'จังหวัดต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent1_aumphure.required" => 'ต้องระบุอำเภอ',
                "parent1_aumphure.max" => 'อำเภอต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent1_tambon.required" => 'ต้องระบุตำบล',
                "parent1_tambon.max" => 'ตำบลต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            ]);

            $parent1_address = new Address();
            $parent1_address['village'] = $request->parent1_village;
            $parent1_address['house_no'] = $request->parent1_house_no;
            $parent1_address['village_no'] = $request->parent1_village_no;
            $parent1_address['street'] = $request->parent1_street;
            $parent1_address['road'] = $request->parent1_road;
            $parent1_address['postcode'] = $request->parent1_postcode;
            $parent1_address['province'] = $request->parent1_province;
            $parent1_address['aumphure'] = $request->parent1_aumphure;
            $parent1_address['tambon'] = $request->parent1_tambon;
            $parent1_address->save();
            $parent1_address_id = $parent1_address['id'];
        }

        //check nationality of parent 1
        if ($request->parent1_is_thai == "ไทย") {
            $parent1_nationality = "ไทย";
        } else {
            $parent1_nationality = $request->parent1_nationality;
        }

        $parent1 = new Parents();
        $parent1['borrower_id'] = $borrower['id'];
        $parent1['borrower_relational'] = $request->parent1_relational;
        $parent1['address_id'] = $parent1_address_id;
        $parent1['nationality'] = $parent1_nationality;
        $parent1['prefix'] = $request->parent1_prefix;
        $parent1['firstname'] = $request->parent1_firstname;
        $parent1['lastname'] = $request->parent1_lastname;
        $parent1['birthday'] = $this->convert_date($request->parent1_birthday);
        $parent1['citizen_id'] = Crypt::encryptString($request->parent1_citizen_id);
        $parent1['phone'] = $request->parent1_phone;
        $parent1['email'] = $request->parent1_email;
        $parent1['occupation'] = $request->parent1_occupation;
        $parent1['place_of_work'] = $request->parent1_place_of_work;
        $parent1['income'] = $request->parent1_income;
        $parent1['alive'] = filter_var($request->parent1_alive, FILTER_VALIDATE_BOOLEAN);

        if (filter_var($request->parent2_no_data, FILTER_VALIDATE_BOOLEAN)) {
            $parent2_have_data = false;
        } else {
            $request->validate([
                "parent2_is_thai" => 'required|string|max:50',
                "parent2_nationality" => 'nullable|string|max:50',
                "parent2_alive" => 'required|string|max:10',
                "parent2_relational" => 'required|string|max:20',
                "parent2_prefix" => 'required|string|max:50',
                "parent2_firstname" => 'required|string|max:100',
                "parent2_lastname" => 'required|string|max:100',
                "parent2_birthday" => 'required|string|max:20',
                "parent2_citizen_id" => 'required|string|max:50',
                "parent2_phone" => 'required|string|max:50',
                "parent2_email" => 'required|string|max:100',
                "parent2_occupation" => 'required|string|max:100',
                "parent2_place_of_work" => 'required|string|max:100',
                "parent2_income" => 'required|string|max:50',
            ], [
                "parent2_is_thai.required" => 'ต้องระบุสัญชาติผู้ปกครอง',
                "parent2_is_thai.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent2_nationnality.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent2_alive.required" => 'ต้องระบุว่าผู้ปกครองมีชีวิตอยู่หรือเสียชีวิต',
                "parent2_alive.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
                "parent2_relational.required" => 'ต้องระบุความสัมพันธ์ของผู้กู้กับผู้ปกครอง',
                "parent2_relational.max" => 'ความสัมพันธ์ของผู้กู้กับผู้ปกครองต้องมีครวามยาวไม่เกิน 20 ตัวอักษร',
                'parent2_prefix.required' => 'ต้องระบุคำนำหน้าชื่อผู้ปกครอง',
                'parent2_prefix.max' => 'คำนำหน้าชื่อผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                'parent2_firstname.required' => 'ต้องกรอกชื่อจริงผู้ปกครอง',
                'parent2_firstname.max' => 'ชื่อจริงผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                'parent2_lastname.required' => 'ต้องกรอกนามสกุลผู้ปกครอง',
                'parent2_lastname.max' => 'นามสกุลผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                'parent2_birthday.required' => 'ต้องกรอกวันเกิดผู้ปกครอง',
                'parent2_birthday.max' => 'วันเกิดผู้ปกครองไม่ถูกต้อง',
                'parent2_citizen_id.required' => 'ต้องกรอกเลขบัตรประชาชนผู้ปกครอง',
                'parent2_citizen_id.max' => 'เลขบัตรประชาชนผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent2_phone.required" => 'ต้องระบุเบอร์โทรผู้ปกครอง',
                "parent2_phone.max" => 'เบอร์โทรศัพท์ผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent2_email.required" => 'ต้องระบุอีเมลล์โทรผู้ปกครอง',
                "parent2_email.max" => 'อีเมลล์ผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
                "parent2_occupation.required" => 'ต้องระบุอาชีพผู้ปกครอง',
                "parent2_occupation.max" => 'อาชีพผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
                "parent2_place_of_work.required" => 'ต้องระบุสถานที่ทำงานผู้ปกครอง',
                "parent2_place_of_work.max" => 'สถานที่ทำงานผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
                "parent2_income.required" => 'ต้องระบุรายได้ผู้ปกครอง',
                "parent2_income.max" => 'รายได้ผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            ]);
            //check nationality of parent 2
            if ($request->parent2_is_thai == "ไทย") {
                $parent2_nationality = "ไทย";
            } else {
                $request->validate([
                    "parent2_nationality" => 'required|string|max:50',
                ], [
                    "parent2_nationality.required" => 'ต้องระบุสัญชาตผู้ปกครอง',
                    "parent2_nationality.string" => 'ประเภทข้อมูลไม่ถูกต้อง',
                    "parent2_nationality.max" => 'สัญชาตผู้ปกครองงมีครวามยาวไม่เกิน :max ตัวอักษร',
                ]);

                $parent2_nationality = $request->parent2_nationality;
            }

            $parent2 = new Parents();
            $parent2['borrower_id'] = $borrower['id'];
            $parent2['borrower_relational'] = $request->parent2_relational;

            $parent2['nationality'] = $parent2_nationality;
            $parent2['prefix'] = $request->parent2_prefix;
            $parent2['firstname'] = $request->parent2_firstname;
            $parent2['lastname'] = $request->parent2_lastname;
            $parent2['birthday'] = $this->convert_date($request->parent2_birthday);
            $parent2['citizen_id'] = Crypt::encryptString($request->parent2_citizen_id);
            $parent2['phone'] = $request->parent2_phone;
            $parent2['email'] = $request->parent2_email;
            $parent2['occupation'] = $request->parent2_occupation;
            $parent2['place_of_work'] = $request->parent2_place_of_work;
            $parent2['income'] = $request->parent2_income;
            $parent2['alive'] = filter_var($request->parent2_alive, FILTER_VALIDATE_BOOLEAN);
            $parent2_have_data = true;

            //เช็คว่าที่อยู่เดียวกับผู้กู้มั้ย
            if (isset($request->parent2_address_with_borrower)) {
                $parent2['address_id'] = $borrower->address_id;
            } else {

                $request->validate([
                    "parent2_village" => 'required|string|max:50',
                    "parent2_house_no" => 'required|string|max:20',
                    "parent2_village_no" => 'required|string|max:20',
                    "parent2_street" => 'required|string|max:100',
                    "parent2_road" => 'required|string|max:100',
                    "parent2_postcode" => 'required|string|max:10',
                    "parent2_province" => 'required|string|max:50',
                    "parent2_aumphure" => 'required|string|max:50',
                    "parent2_tambon" => 'required|string|max:50',
                ], [

                    "parent2_village.required" => 'ต้องกรอกชื่อหมู่บ้าน',
                    "parent2_village.max" => 'ชื่อหมู่บ้านต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                    "parent2_house_no.required" => 'ต้องกรอกบ้านเลขที่',
                    "parent2_house_no.max" => 'บ้านเลขที่ต้องไม่เกิน 20 ตัวอักษร',
                    "parent2_village_no.required" => 'ต้องกรอกเลขหมู่บ้าน',
                    "parent2_village_no.max" => 'เลขหมู่บ้านต้องไม่เกิน 20 ตัวอักษร',
                    "parent2_street.max" => 'ซอยต้องไม่เกิน 100 ตัวอักษร',
                    "parent2_road.max" => 'ถนนต้องไม่เกิน 100 ตัวอักษร',
                    "parent2_postcode.required" => 'ต้องระบุเลขไปรษณีย์',
                    "parent2_postcode.max" => 'เลขไปรษณีย์ต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
                    "parent2_province.required" => 'ต้องระบุจังหวัด',
                    "parent2_aumphure.max" => 'จังหวัดต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                    "parent2_aumphure.required" => 'ต้องระบุอำเภอ',
                    "parent2_aumphure.max" => 'อำเภอต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                    "parent2_tambon.required" => 'ต้องระบุตำบล',
                    "parent2_tambon.max" => 'ตำบลต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                ]);

                $parent2_address = new Address();
                $parent2_address['village'] = $request->parent2_village;
                $parent2_address['house_no'] = $request->parent2_house_no;
                $parent2_address['village_no'] = $request->parent2_village_no;
                $parent2_address['street'] = $request->parent2_street;
                $parent2_address['road'] = $request->parent2_road;
                $parent2_address['postcode'] = $request->parent2_postcode;
                $parent2_address['province'] = $request->parent2_province;
                $parent2_address['aumphure'] = $request->parent2_aumphure;
                $parent2_address['tambon'] = $request->parent2_tambon;
                $parent2_address->save();
                $parent2['address_id'] = $parent2_address['id'];
            }
        }

        //marital status
        if ($request->marital_status == "อยู่ด้วยกัน") {
            $marital_status = ['status' => 'อยู่ด้วยกัน', 'file_name' => ''];
        } else if ($request->marital_status == "other") {
            $marital_status = ['status' => $request->other_text, 'file_name' => ''];
        } else if ($request->marital_status == "แยกกันอยู่ตามอาชีพ") {
            $marital_status = ['status' => 'แยกกันอยู่ตามอาชีพ', 'file_name' => ''];
        } else if ($request->marital_status == "หย่า") {

            $file_validator = Validator::make($request->all(), [
                "devorce_file" => 'required|file|max:2048|mimes:pdf',
            ]);

            // Check if validation fails
            if ($file_validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($file_validator);
            }
            $marital_status_path = Config::where('variable', 'marital_file_path')->value('value');
            $file = $request->file('devorce_file');
            $file_name = $file->getClientOriginalName();
            $spit_filename = explode('.', $file_name);
            $file_extenstion = last($spit_filename);
            if ($file_extenstion != 'pdf') {
                $error = ['devorce_file' => 'ประเภทไฟล์ต้องเป็น .pdf เท่านั้น'];
                return $error;
            }
            //check file supported
            $merger = new Merger(); 
            try {
                $merger->addFile($file);
                $merger->merge();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors('ไฟล์ PDF ไม่รองรับเทคนิคการบีบอัดนี้ ลองเปลี่ยนเครื่องมือแสกน PDF');
            }

            $new_file_name = $this->storeFile($marital_status_path . '/' . $user_id, $file);
            $marital_status = ['status' => 'หย่า', 'file_name' => $new_file_name,];
        }

        $parent1->save();
        if ($parent2_have_data) $parent2->save();
        $borrower['marital_status'] = json_encode($marital_status);
        $borrower->save();

        return redirect('/borrower/information/information_list')->with(['success' => 'บันทึกข้อมูลผู้ปกครองเรียบร้อยแล้ว']);
    }

    public function borrower_edit_parent_information(ParentInformationRequest $request)
    {
        // dd($request->all());
        date_default_timezone_set("Asia/Bangkok");
        $user_id = $request->session()->get('user_id', '1');
        $borrower = Borrower::where('user_id', $user_id)->first();
        $parents_db = Parents::where('borrower_id', $borrower->id)->get();
        $marital_db = json_decode($borrower->marital_status);
        $marital_status_path = Config::where('variable', 'marital_file_path')->value('value');

        //เช็คว่าที่อยู่เดียวกับผู้กู้มั้ย (ที่ติ๊กมา)
        if (isset($request->parent1_address_with_borrower)) {
            //ถ้าเปลี่ยนจากไม่อยู่เป็นอยู่
            if ($parents_db[0]['address_id'] != $borrower->address_id) { //ถ้าเดิมไม่อยู่ด้วยกัน(ใน db)
                $parent1_address = Address::find($parents_db[0]['address_id']);
                if ($parent1_address) {
                    $parent1_address->delete();
                }
            }
            $parent1_address_id = $borrower->address_id;
        } else {

            $request->validate([
                "parent1_village" => 'required|string|max:50',
                "parent1_house_no" => 'required|string|max:20',
                "parent1_village_no" => 'required|string|max:20',
                "parent1_street" => 'required|string|max:100',
                "parent1_road" => 'required|string|max:100',
                "parent1_postcode" => 'required|string|max:10',
                "parent1_province" => 'required|string|max:50',
                "parent1_aumphure" => 'required|string|max:50',
                "parent1_tambon" => 'required|string|max:50',
            ], [

                "parent1_village.required" => 'ต้องกรอกชื่อหมู่บ้าน',
                "parent1_village.max" => 'ชื่อหมู่บ้านต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent1_house_no.required" => 'ต้องกรอกบ้านเลขที่',
                "parent1_house_no.max" => 'บ้านเลขที่ต้องไม่เกิน 20 ตัวอักษร',
                "parent1_village_no.required" => 'ต้องกรอกเลขหมู่บ้าน',
                "parent1_village_no.max" => 'เลขหมู่บ้านต้องไม่เกิน 20 ตัวอักษร',
                "parent1_street.max" => 'ซอยต้องไม่เกิน 100 ตัวอักษร',
                "parent1_road.max" => 'ถนนต้องไม่เกิน 100 ตัวอักษร',
                "parent1_postcode.required" => 'ต้องระบุเลขไปรษณีย์',
                "parent1_postcode.max" => 'เลขไปรษณีย์ต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
                "parent1_province.required" => 'ต้องระบุจังหวัด',
                "parent1_aumphure.max" => 'จังหวัดต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent1_aumphure.required" => 'ต้องระบุอำเภอ',
                "parent1_aumphure.max" => 'อำเภอต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent1_tambon.required" => 'ต้องระบุตำบล',
                "parent1_tambon.max" => 'ตำบลต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            ]);

            // เปลี่ยนจากอยู่ด้วยเป็นไม่อยู่
            if ($parents_db[0]['address_id'] == $borrower->address_id) { //ถ้าเดิมคืออยู่ด้วยกันเพิ่มที่อยู่ใหม่
                $parent1_address = new Address();
            } else { //ถ้าเดิมไท่ได้อยู่ด้วยกันอยู่แล้วเข้าไปแก้ที่อยู่เดิม
                $parent1_address =  Address::find($parents_db[0]['address_id']);
            }

            $parent1_address = new Address();
            $parent1_address['village'] = $request->parent1_village;
            $parent1_address['house_no'] = $request->parent1_house_no;
            $parent1_address['village_no'] = $request->parent1_village_no;
            $parent1_address['street'] = $request->parent1_street;
            $parent1_address['road'] = $request->parent1_road;
            $parent1_address['postcode'] = $request->parent1_postcode;
            $parent1_address['province'] = $request->parent1_province;
            $parent1_address['aumphure'] = $request->parent1_aumphure;
            $parent1_address['tambon'] = $request->parent1_tambon;
            $parent1_address->save();
            $parent1_address_id = $parent1_address['id'];
        }

        //check nationality of parent 1
        if ($request->parent1_is_thai == "ไทย") {
            $parent1_nationality = "ไทย";
        } else {
            $parent1_nationality = $request->parent1_nationality;
        }
        $parent1 = $parents_db[0];
        $parent1['borrower_id'] = $borrower['id'];
        $parent1['borrower_relational'] = $request->parent1_relational;
        $parent1['address_id'] = $parent1_address_id;
        $parent1['nationality'] = $parent1_nationality;
        $parent1['prefix'] = $request->parent1_prefix;
        $parent1['firstname'] = $request->parent1_firstname;
        $parent1['lastname'] = $request->parent1_lastname;
        $parent1['birthday'] = $this->convert_date($request->parent1_birthday);
        $parent1['citizen_id'] = Crypt::encryptString($request->parent1_citizen_id);
        $parent1['phone'] = $request->parent1_phone;
        $parent1['email'] = $request->parent1_email;
        $parent1['occupation'] = $request->parent1_occupation;
        $parent1['place_of_work'] = $request->parent1_place_of_work;
        $parent1['income'] = $request->parent1_income;
        $parent1['alive'] = filter_var($request->parent1_alive, FILTER_VALIDATE_BOOLEAN);

        if (isset($parents_db[1])) {
            
        }

        if (filter_var($request->parent2_no_data, FILTER_VALIDATE_BOOLEAN)) {
            //if change from have data to no data
            if (isset($parents_db[1])) {
                $parent2 = $parents_db[1];
                $parent2->delete();
            }
            $parent2_have_data = false;
        } else { //
            $request->validate([
                "parent2_is_thai" => 'required|string|max:50',
                "parent2_nationality" => 'nullable|string|max:50',
                "parent2_alive" => 'required|string|max:10',
                "parent2_relational" => 'required|string|max:20',
                "parent2_prefix" => 'required|string|max:50',
                "parent2_firstname" => 'required|string|max:100',
                "parent2_lastname" => 'required|string|max:100',
                "parent2_birthday" => 'required|string|max:20',
                "parent2_citizen_id" => 'required|string|max:50',
                "parent2_phone" => 'required|string|max:50',
                "parent2_email" => 'required|string|max:100',
                "parent2_occupation" => 'required|string|max:100',
                "parent2_place_of_work" => 'required|string|max:100',
                "parent2_income" => 'required|string|max:50',
            ], [
                "parent2_is_thai.required" => 'ต้องระบุสัญชาติผู้ปกครอง',
                "parent2_is_thai.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent2_nationnality.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent2_alive.required" => 'ต้องระบุว่าผู้ปกครองมีชีวิตอยู่หรือเสียชีวิต',
                "parent2_alive.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
                "parent2_relational.required" => 'ต้องระบุความสัมพันธ์ของผู้กู้กับผู้ปกครอง',
                "parent2_relational.max" => 'ความสัมพันธ์ของผู้กู้กับผู้ปกครองต้องมีครวามยาวไม่เกิน 20 ตัวอักษร',
                'parent2_prefix.required' => 'ต้องระบุคำนำหน้าชื่อผู้ปกครอง',
                'parent2_prefix.max' => 'คำนำหน้าชื่อผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                'parent2_firstname.required' => 'ต้องกรอกชื่อจริงผู้ปกครอง',
                'parent2_firstname.max' => 'ชื่อจริงผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                'parent2_lastname.required' => 'ต้องกรอกนามสกุลผู้ปกครอง',
                'parent2_lastname.max' => 'นามสกุลผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                'parent2_birthday.required' => 'ต้องกรอกวันเกิดผู้ปกครอง',
                'parent2_birthday.max' => 'วันเกิดผู้ปกครองไม่ถูกต้อง',
                'parent2_citizen_id.required' => 'ต้องกรอกเลขบัตรประชาชนผู้ปกครอง',
                'parent2_citizen_id.max' => 'เลขบัตรประชาชนผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent2_phone.required" => 'ต้องระบุเบอร์โทรผู้ปกครอง',
                "parent2_phone.max" => 'เบอร์โทรศัพท์ผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent2_email.required" => 'ต้องระบุอีเมลล์โทรผู้ปกครอง',
                "parent2_email.max" => 'อีเมลล์ผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
                "parent2_occupation.required" => 'ต้องระบุอาชีพผู้ปกครอง',
                "parent2_occupation.max" => 'อาชีพผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
                "parent2_place_of_work.required" => 'ต้องระบุสถานที่ทำงานผู้ปกครอง',
                "parent2_place_of_work.max" => 'สถานที่ทำงานผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
                "parent2_income.required" => 'ต้องระบุรายได้ผู้ปกครอง',
                "parent2_income.max" => 'รายได้ผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            ]);

            //check nationality of parent 2
            if ($request->parent2_is_thai == "ไทย") {
                $parent2_nationality = "ไทย";
            } else {
                $request->validate([
                    "parent2_nationality" => 'required|string|max:50',
                ], [
                    "parent2_nationality.required" => 'ต้องระบุสัญชาตผู้ปกครอง',
                    "parent2_nationality.string" => 'ประเภทข้อมูลไม่ถูกต้อง',
                    "parent2_nationality.max" => 'สัญชาตผู้ปกครองงมีครวามยาวไม่เกิน :max ตัวอักษร',
                ]);

                $parent2_nationality = $request->parent2_nationality;
            }

            if (isset($parents_db[1])) {
                $parent2 = $parents_db[1];
                $parent2['updated_at'] = date('Y-m-d H:i:s');
            } else {
                $parent2 = new Parents();
            }
            $parent2['borrower_id'] = $borrower['id'];
            $parent2['borrower_relational'] = $request->parent2_relational;
            $parent2['nationality'] = $parent2_nationality;
            $parent2['prefix'] = $request->parent2_prefix;
            $parent2['firstname'] = $request->parent2_firstname;
            $parent2['lastname'] = $request->parent2_lastname;
            $parent2['birthday'] = $this->convert_date($request->parent2_birthday);
            $parent2['citizen_id'] = Crypt::encryptString($request->parent2_citizen_id);
            $parent2['phone'] = $request->parent2_phone;
            $parent2['email'] = $request->parent2_email;
            $parent2['occupation'] = $request->parent2_occupation;
            $parent2['place_of_work'] = $request->parent2_place_of_work;
            $parent2['income'] = $request->parent2_income;
            $parent2['alive'] = filter_var($request->parent2_alive, FILTER_VALIDATE_BOOLEAN);
            $parent2_have_data = true;

            //เช็คว่าที่อยู่เดียวกับผู้กู้มั้ย (ที่ติ๊กมา)
            if (isset($request->parent2_address_with_borrower)) {
                //ถ้ามีข้อมูลผู้ปกครอง 2
                if(isset($parents_db[1])) {
                    //ถ้าเปลี่ยนจากไม่อยู่เป็นอยู่
                    if ($parents_db[1]['address_id'] != $borrower->address_id) { //ถ้าเดิมไม่อยู่ด้วยกัน(ใน db)
                        $parent2_address = Address::find($parents_db[1]['address_id']);
                        if ($parent2_address) {
                            $parent2_address->delete();
                        }
                    }
                }
                $parent2['address_id'] = $borrower->address_id;
            } else {

                $request->validate([
                    "parent2_village" => 'required|string|max:50',
                    "parent2_house_no" => 'required|string|max:20',
                    "parent2_village_no" => 'required|string|max:20',
                    "parent2_street" => 'required|string|max:100',
                    "parent2_road" => 'required|string|max:100',
                    "parent2_postcode" => 'required|string|max:10',
                    "parent2_province" => 'required|string|max:50',
                    "parent2_aumphure" => 'required|string|max:50',
                    "parent2_tambon" => 'required|string|max:50',
                ], [

                    "parent2_village.required" => 'ต้องกรอกชื่อหมู่บ้าน',
                    "parent2_village.max" => 'ชื่อหมู่บ้านต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                    "parent2_house_no.required" => 'ต้องกรอกบ้านเลขที่',
                    "parent2_house_no.max" => 'บ้านเลขที่ต้องไม่เกิน 20 ตัวอักษร',
                    "parent2_village_no.required" => 'ต้องกรอกเลขหมู่บ้าน',
                    "parent2_village_no.max" => 'เลขหมู่บ้านต้องไม่เกิน 20 ตัวอักษร',
                    "parent2_street.max" => 'ซอยต้องไม่เกิน 100 ตัวอักษร',
                    "parent2_road.max" => 'ถนนต้องไม่เกิน 100 ตัวอักษร',
                    "parent2_postcode.required" => 'ต้องระบุเลขไปรษณีย์',
                    "parent2_postcode.max" => 'เลขไปรษณีย์ต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
                    "parent2_province.required" => 'ต้องระบุจังหวัด',
                    "parent2_aumphure.max" => 'จังหวัดต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                    "parent2_aumphure.required" => 'ต้องระบุอำเภอ',
                    "parent2_aumphure.max" => 'อำเภอต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                    "parent2_tambon.required" => 'ต้องระบุตำบล',
                    "parent2_tambon.max" => 'ตำบลต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                ]);

                if(isset($parents_db[1])) {
                    // เปลี่ยนจากอยู่ด้วยเป็นไม่อยู่
                    if ($parents_db[1]['address_id'] == $borrower->address_id) { //ถ้าเดิมคืออยู่ด้วยกันเพิ่มที่อยู่ใหม่
                        $parent2_address = new Address();
                    } else { //ถ้าเดิมไท่ได้อยู่ด้วยกันอยู่แล้วเข้าไปแก้ที่อยู่เดิม
                        $parent2_address =  Address::find($parents_db[1]['address_id']);
                    }
                }else{
                    $parent2_address = new Address();
                }
                $parent2_address['village'] = $request->parent2_village;
                $parent2_address['house_no'] = $request->parent2_house_no;
                $parent2_address['village_no'] = $request->parent2_village_no;
                $parent2_address['street'] = $request->parent2_street;
                $parent2_address['road'] = $request->parent2_road;
                $parent2_address['postcode'] = $request->parent2_postcode;
                $parent2_address['province'] = $request->parent2_province;
                $parent2_address['aumphure'] = $request->parent2_aumphure;
                $parent2_address['tambon'] = $request->parent2_tambon;
                $parent2_address->save();
                $parent2['address_id'] = $parent2_address['id'];
            }
        }

        //check old status is not equal new status and old is หย่า
        if ($request->marital_status != $marital_db->status && ($marital_db->status == "หย่า")) {
            $this->deleteFile($marital_status_path . '/' . $user_id, $marital_db->file_name);
        }
        //marital status
        if ($request->marital_status == "อยู่ด้วยกัน") {
            $marital_status = ['status' => 'อยู่ด้วยกัน', 'file_name' => ''];
        } else if ($request->marital_status == "other") {
            $marital_status = ['status' => $request->other_text, 'file_name' => ''];
        } else if ($request->marital_status == "แยกกันอยู่ตามอาชีพ") {
            $marital_status = ['status' => 'แยกกันอยู่ตามอาชีพ', 'file_name' => ''];
        } else if ($request->marital_status == "หย่า") {

            
            $file = $request->file('devorce_file');
            //check file supported
            $merger = new Merger(); 
            try {
                $merger->addFile($file);
                $merger->merge();
            } catch (\Exception $e) {
                return redirect()->back()->withErrors('ไฟล์ PDF ไม่รองรับเทคนิคการบีบอัดนี้ ลองเปลี่ยนเครื่องมือแสกน PDF');
            }
            
            //check if have new file delete old file
            if ($request->file('devorce_file') != null) {
                $this->deleteFile($marital_status_path . '/' . $user_id, $marital_db->file_name);
            }

            $file_validator = Validator::make($request->all(), [
                "devorce_file" => 'required|file|max:2048|mimes:pdf',
            ]);

            if ($file_validator->fails()) {
                return redirect()
                    ->back()
                    ->withErrors($file_validator)
                    ->withInput();
            }

            $file_name = $file->getClientOriginalName();
            $spit_filename = explode('.', $file_name);
            $file_extenstion = last($spit_filename);

            if ($file_extenstion != 'pdf') {
                $error = ['devorce_file' => 'ประเภทไฟล์ต้องเป็น .pdf เท่านั้น'];
                return $error;
            }


            $file_name = $this->storeFile($marital_status_path . '/' . $user_id, $file);
            $marital_status = ['status' => 'หย่า', 'file_name' => $file_name];
        }
        $parent1->save();
        if ($parent2_have_data) $parent2->save();
        $borrower['marital_status'] = json_encode($marital_status);
        $borrower->save();

        return redirect('/borrower/information/information_list')->with(['success' => 'บันทึกข้อมูลผู้ปกครองเรียบร้อยแล้ว']);
    }
}
