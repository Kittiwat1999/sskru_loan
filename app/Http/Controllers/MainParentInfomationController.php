<?php

namespace App\Http\Controllers;

use App\Http\Requests\MainParentInformationRequest;
use App\Models\Address;
use App\Models\Borrower;
use App\Models\Parents;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;


class MainParentInfomationController extends Controller
{
    private function convert_date($inputDate){
        $parsedDate = Carbon::createFromFormat('d-m-Y', $inputDate);
        $isoDate = $parsedDate->format('Y-m-d');
        return $isoDate;

    }
    public function borrower_input_main_parent_information(){
        $user_id = Session::get('user_id',1);
        $borrower_id = Borrower::where('user_id',$user_id)->value('id');
        $parents = Parents::where('borrower_id',$borrower_id)->where('main_parent_only',false)->select('id','prefix','firstname','lastname')->get();
        return view('borrower.information.main_parent_input',compact('parents'));
    }

    public function borrower_edit_main_parent_information_page(){
        $user_id = Session::get('user_id','1');
        $borrower = Borrower::where('user_id',$user_id)->select('id','address_id')->first();
        $parents = Parents::where('borrower_id',$borrower['id'])->where('main_parent_only',false)->select('id','prefix','firstname','lastname','is_main_parent','address_id')->get();
        $parent3 = Parents::where('borrower_id',$borrower['id'])->where('is_main_parent',true)->where('main_parent_only',true)->first();
        if(isset($parent3))$parent3['citizen_id'] = Crypt::decryptString($parent3['citizen_id']);
        $main_parent_address_id = Parents::where('borrower_id',$borrower['id'])->where('address_id','!=',null)->value('address_id');
        $main_parent_address = Address::find($main_parent_address_id);
        if($borrower['address_id'] == $main_parent_address_id){
            $together_address = true;
        }else{
            $together_address = false;
        }

        // dd($main_parent_address_id);
        return view('borrower.information.main_parent_edit',compact('parent3','parents','main_parent_address','together_address'));
    }
    public function borrower_store_main_parent_information(MainParentInformationRequest $request){
        
        $user_id = Session::get('user_id','1');
        $borrower = Borrower::where('user_id',$user_id)->first();
        
        //เช็คว่าที่อยู่เดียวกับผู้กู้มั้ย
        if(isset($request->address_with_borrower)){
            $main_parent_address_id = $borrower->address_id;
        }else{

            $request->validate([
                "main_parent_village" => 'required|string|max:50',
                "main_parent_house_no" => 'required|string|max:20',
                "main_parent_village_no" => 'required|string|max:20',
                "main_parent_street" => 'required|string|max:100',
                "main_parent_road" => 'required|string|max:100',
                "main_parent_postcode" => 'required|string|max:10',
                "main_parent_province" => 'required|string|max:50',
                "main_parent_aumphure" => 'required|string|max:50',
                "main_parent_tambon" => 'required|string|max:50',
            ],[
                
                "main_parent_village.required" => 'ต้องกรอกชื่อหมู่บ้าน',
                "main_parent_village.max" => 'ชื่อหมู่บ้านต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "main_parent_house_no.required" => 'ต้องกรอกบ้านเลขที่',
                "main_parent_house_no.max" => 'บ้านเลขที่ต้องไม่เกิน 20 ตัวอักษร',
                "main_parent_village_no.required" => 'ต้องกรอกเลขหมู่บ้าน',
                "main_parent_village_no.max" => 'เลขหมู่บ้านต้องไม่เกิน 20 ตัวอักษร',
                "main_parent_street.max" => 'ซอยต้องไม่เกิน 100 ตัวอักษร',
                "main_parent_road.max" => 'ถนนต้องไม่เกิน 100 ตัวอักษร',
                "main_parent_postcode.required" => 'ต้องระบุเลขไปรษณีย์',
                "main_parent_postcode.max" => 'เลขไปรษณีย์ต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
                "main_parent_province.required" => 'ต้องระบุจังหวัด',
                "main_parent_aumphure.max" => 'จังหวัดต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "main_parent_aumphure.required" => 'ต้องระบุอำเภอ',
                "main_parent_aumphure.max" => 'อำเภอต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "main_parent_tambon.required" => 'ต้องระบุตำบล',
                "main_parent_tambon.max" => 'ตำบลต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            ]);

            $main_parent_address = new Address();
            $main_parent_address['village'] = $request->main_parent_village;
            $main_parent_address['house_no']=$request->main_parent_house_no;
            $main_parent_address['village_no']=$request->main_parent_village_no;
            $main_parent_address['street']=$request->main_parent_street;
            $main_parent_address['road']=$request->main_parent_road;
            $main_parent_address['postcode']=$request->main_parent_postcode;
            $main_parent_address['province']=$request->main_parent_province;
            $main_parent_address['aumphure']=$request->main_parent_aumphure;
            $main_parent_address['tambon']=$request->main_parent_tambon;
            $main_parent_address->save();
            $main_parent_address_id = $main_parent_address['id'];
        }

        if($request->main_parent != 'parent3'){
            $main_parent = Parents::find($request->main_parent);
            $main_parent['address_id'] = $main_parent_address_id;
            $main_parent['is_main_parent'] = true;
            $main_parent->save();
        }else{
            $request->validate([
                "parent3_is_thai" => 'required|string|max:50',
                "parent3_nationality" => 'nullable|string|max:50',
                "parent3_alive" => 'required|string|max:10',
                "parent3_relational" => 'required|string|max:20',
                "parent3_prefix" => 'required|string|max:50',
                "parent3_firstname" => 'required|string|max:100',
                "parent3_lastname" => 'required|string|max:100',
                "parent3_birthday" => 'required|string|max:20',
                "parent3_citizen_id" => 'required|string|max:50',
                "parent3_phone" => 'required|string|max:50',
                "parent3_email" => 'required|string|max:100',
                "parent3_occupation" => 'required|string|max:100',
                "parent3_place_of_work" => 'required|string|max:100',
                "parent3_income" => 'required|string|max:50',
            ],[
                "parent3_is_thai.required" => 'ต้องระบุสัญชาติผู้ปกครอง',
                "parent3_is_thai.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent3_nationnality.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent3_alive.required" => 'ต้องระบุว่าผู้ปกครองมีชีวิตอยู่หรือเสียชีวิต',
                "parent3_alive.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
                "parent3_relational.required" => 'ต้องระบุความสัมพันธ์ของผู้กู้กับผู้ปกครอง',
                "parent3_relational.max" => 'ความสัมพันธ์ของผู้กู้กับผู้ปกครองต้องมีครวามยาวไม่เกิน 20 ตัวอักษร',
                'parent3_prefix.required' => 'ต้องระบุคำนำหน้าชื่อผู้ปกครอง',
                'parent3_prefix.max' => 'คำนำหน้าชื่อผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                'parent3_firstname.required' => 'ต้องกรอกชื่อจริงผู้ปกครอง',
                'parent3_firstname.max' => 'ชื่อจริงผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                'parent3_lastname.required' => 'ต้องกรอกนามสกุลผู้ปกครอง',
                'parent3_lastname.max' => 'นามสกุลผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                'parent3_birthday.required' => 'ต้องกรอกวันเกิดผู้ปกครอง',
                'parent3_birthday.max' => 'วันเกิดผู้ปกครองไม่ถูกต้อง',
                'parent3_citizen_id.required' => 'ต้องกรอกเลขบัตรประชาชนผู้ปกครอง',
                'parent3_citizen_id.max' => 'เลขบัตรประชาชนผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent3_phone.required" => 'ต้องระบุเบอร์โทรผู้ปกครอง',
                "parent3_phone.max" => 'เบอร์โทรศัพท์ผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent3_email.required" => 'ต้องระบุอีเมลล์โทรผู้ปกครอง',
                "parent3_email.max" => 'อีเมลล์ผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
                "parent3_occupation.required" => 'ต้องระบุอาชีพผู้ปกครอง',
                "parent3_occupation.max" => 'อาชีพผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
                "parent3_place_of_work.required" => 'ต้องระบุสถานที่ทำงานผู้ปกครอง',
                "parent3_place_of_work.max" => 'สถานที่ทำงานผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
                "parent3_income.required" => 'ต้องระบุรายได้ผู้ปกครอง',
                "parent3_income.max" => 'รายได้ผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            ]);
            
            //check nationality of parent 2
            if($request->parent3_is_thai == "ไทย"){
                $parent3_nationality = "ไทย";
            }else{
                 $request->validate([
                     "parent3_nationality" => 'required|string|max:50',
                 ],[
                     "parent3_nationality.required" => 'ต้องระบุสัญชาตผู้ปกครอง',
                     "parent3_nationality.string" => 'ประเภทข้อมูลไม่ถูกต้อง',
                     "parent3_nationality.max" => 'สัญชาตผู้ปกครองงมีครวามยาวไม่เกิน :max ตัวอักษร',
                 ]);
 
                $parent3_nationality = $request->parent3_nationality;
            }

            $parent3 = new Parents();
            $parent3['borrower_id'] = $borrower['id'];
            $parent3['address_id'] = $main_parent_address_id;
            $parent3['borrower_relational'] = $request->parent3_relational;
            $parent3['nationality'] = $parent3_nationality;
            $parent3['prefix'] = $request->parent3_prefix;
            $parent3['firstname'] = $request->parent3_firstname;
            $parent3['lastname'] = $request->parent3_lastname;
            $parent3['birthday'] = $this->convert_date($request->parent3_birthday);
            $parent3['citizen_id'] = Crypt::encryptString($request->parent3_citizen_id);
            $parent3['phone'] = $request->parent3_phone;
            $parent3['email'] = $request->parent3_email;
            $parent3['occupation'] = $request->parent3_occupation;
            $parent3['place_of_work'] = $request->parent3_place_of_work;
            $parent3['income'] = $request->parent3_income;
            $parent3['alive'] = filter_var($request->parent3_alive, FILTER_VALIDATE_BOOLEAN);
            $parent3['is_main_parent'] = true;
            $parent3['main_parent_only'] = true;
            $parent3->save();
        }    

        return redirect('/borrower/information/information_list')->with(['success'=>'บันทึกข้อมูลผู้แทนโดยชอบธรรมเสร็จสิ้น']);
    }

    public function borrower_edit_main_parent_information(MainParentInformationRequest $request){

        $user_id = Session::get('user_id','1');
        $borrower = Borrower::where('user_id',$user_id)->first();
        $main_parent_db = Parents::where('borrower_id',$borrower['id'])->where('is_main_parent',true)->first();
        //เช็คว่าที่อยู่เดียวกับผู้กู้มั้ย (ที่ติ๊กมา)
        if(isset($request->address_with_borrower)){
            //ถ้าเปลี่ยนจากไม่อยู่เป็นอยู่
            if($main_parent_db['address_id'] != $borrower->address_id){ //ถ้าเดิมไม่อยู่ด้วยกัน(ใน db)
                $main_parent_address = Address::find($main_parent_db['address_id']);
                if ($main_parent_address) {
                    $main_parent_address->delete();
                }
            }
            $main_parent_address_id = $borrower->address_id;
        }else{

            $request->validate([
                "main_parent_village" => 'required|string|max:50',
                "main_parent_house_no" => 'required|string|max:20',
                "main_parent_village_no" => 'required|string|max:20',
                "main_parent_street" => 'required|string|max:100',
                "main_parent_road" => 'required|string|max:100',
                "main_parent_postcode" => 'required|string|max:10',
                "main_parent_province" => 'required|string|max:50',
                "main_parent_aumphure" => 'required|string|max:50',
                "main_parent_tambon" => 'required|string|max:50',
            ],[
                
                "main_parent_village.required" => 'ต้องกรอกชื่อหมู่บ้าน',
                "main_parent_village.max" => 'ชื่อหมู่บ้านต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "main_parent_house_no.required" => 'ต้องกรอกบ้านเลขที่',
                "main_parent_house_no.max" => 'บ้านเลขที่ต้องไม่เกิน 20 ตัวอักษร',
                "main_parent_village_no.required" => 'ต้องกรอกเลขหมู่บ้าน',
                "main_parent_village_no.max" => 'เลขหมู่บ้านต้องไม่เกิน 20 ตัวอักษร',
                "main_parent_street.max" => 'ซอยต้องไม่เกิน 100 ตัวอักษร',
                "main_parent_road.max" => 'ถนนต้องไม่เกิน 100 ตัวอักษร',
                "main_parent_postcode.required" => 'ต้องระบุเลขไปรษณีย์',
                "main_parent_postcode.max" => 'เลขไปรษณีย์ต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
                "main_parent_province.required" => 'ต้องระบุจังหวัด',
                "main_parent_aumphure.max" => 'จังหวัดต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "main_parent_aumphure.required" => 'ต้องระบุอำเภอ',
                "main_parent_aumphure.max" => 'อำเภอต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "main_parent_tambon.required" => 'ต้องระบุตำบล',
                "main_parent_tambon.max" => 'ตำบลต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            ]);

            // เปลี่ยนจากอยู่ด้วยเป็นไม่อยู่
            if($main_parent_db['address_id'] == $borrower->address_id){ //ถ้าเดิมคืออยู่ด้วยกันเพิ่มที่อยู่ใหม่
                $main_parent_address = new Address();
            }else{ //ถ้าเดิมไท่ได้อยู่ด้วยกันอยู่แล้วเข้าไปแก้ที่อยู่เดิม
                $main_parent_address =  Address::find($main_parent_db['address_id']);
            }

            $main_parent_address = new Address();
            $main_parent_address['village'] = $request->main_parent_village;
            $main_parent_address['house_no']=$request->main_parent_house_no;
            $main_parent_address['village_no']=$request->main_parent_village_no;
            $main_parent_address['street']=$request->main_parent_street;
            $main_parent_address['road']=$request->main_parent_road;
            $main_parent_address['postcode']=$request->main_parent_postcode;
            $main_parent_address['province']=$request->main_parent_province;
            $main_parent_address['aumphure']=$request->main_parent_aumphure;
            $main_parent_address['tambon']=$request->main_parent_tambon;
            $main_parent_address->save();
            $main_parent_address_id = $main_parent_address['id'];
        }

        if($request->main_parent != 'parent3'){
            $main_parent = Parents::find($request->main_parent); 
            if($main_parent_db['id'] != $main_parent['id']){ //ถ้าเปลี่ยนผู้แทน
                if($main_parent_db['main_parent_only']){ //ถ้าเดิมผู้แทนเป็นคนที่ 3
                    $main_parent_db->delete();
                }else{
                    //แก้ให้ไม่เป็นผู้แทน
                    $main_parent_db['address_id'] = null;
                    $main_parent_db['is_main_parent'] = true;
                    $main_parent_db->save();
                }
                //ผู้แทนใหม่
                $main_parent['is_main_parent'] = true;
            }
            $main_parent['address_id'] = $main_parent_address_id;
            $main_parent->save();
        }else{
            $request->validate([
                "parent3_is_thai" => 'required|string|max:50',
                "parent3_nationality" => 'nullable|string|max:50',
                "parent3_alive" => 'required|string|max:10',
                "parent3_relational" => 'required|string|max:20',
                "parent3_prefix" => 'required|string|max:50',
                "parent3_firstname" => 'required|string|max:100',
                "parent3_lastname" => 'required|string|max:100',
                "parent3_birthday" => 'required|string|max:20',
                "parent3_citizen_id" => 'required|string|max:50',
                "parent3_phone" => 'required|string|max:50',
                "parent3_email" => 'required|string|max:100',
                "parent3_occupation" => 'required|string|max:100',
                "parent3_place_of_work" => 'required|string|max:100',
                "parent3_income" => 'required|string|max:50',
            ],[
                "parent3_is_thai.required" => 'ต้องระบุสัญชาติผู้ปกครอง',
                "parent3_is_thai.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent3_nationnality.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent3_alive.required" => 'ต้องระบุว่าผู้ปกครองมีชีวิตอยู่หรือเสียชีวิต',
                "parent3_alive.max" => 'สัญชาติผู้ปกครองต้องมีครวามยาวไม่เกิน 10 ตัวอักษร',
                "parent3_relational.required" => 'ต้องระบุความสัมพันธ์ของผู้กู้กับผู้ปกครอง',
                "parent3_relational.max" => 'ความสัมพันธ์ของผู้กู้กับผู้ปกครองต้องมีครวามยาวไม่เกิน 20 ตัวอักษร',
                'parent3_prefix.required' => 'ต้องระบุคำนำหน้าชื่อผู้ปกครอง',
                'parent3_prefix.max' => 'คำนำหน้าชื่อผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                'parent3_firstname.required' => 'ต้องกรอกชื่อจริงผู้ปกครอง',
                'parent3_firstname.max' => 'ชื่อจริงผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                'parent3_lastname.required' => 'ต้องกรอกนามสกุลผู้ปกครอง',
                'parent3_lastname.max' => 'นามสกุลผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                'parent3_birthday.required' => 'ต้องกรอกวันเกิดผู้ปกครอง',
                'parent3_birthday.max' => 'วันเกิดผู้ปกครองไม่ถูกต้อง',
                'parent3_citizen_id.required' => 'ต้องกรอกเลขบัตรประชาชนผู้ปกครอง',
                'parent3_citizen_id.max' => 'เลขบัตรประชาชนผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent3_phone.required" => 'ต้องระบุเบอร์โทรผู้ปกครอง',
                "parent3_phone.max" => 'เบอร์โทรศัพท์ผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
                "parent3_email.required" => 'ต้องระบุอีเมลล์โทรผู้ปกครอง',
                "parent3_email.max" => 'อีเมลล์ผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
                "parent3_occupation.required" => 'ต้องระบุอาชีพผู้ปกครอง',
                "parent3_occupation.max" => 'อาชีพผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
                "parent3_place_of_work.required" => 'ต้องระบุสถานที่ทำงานผู้ปกครอง',
                "parent3_place_of_work.max" => 'สถานที่ทำงานผู้ปกครองต้องมีครวามยาวไม่เกิน 100 ตัวอักษร',
                "parent3_income.required" => 'ต้องระบุรายได้ผู้ปกครอง',
                "parent3_income.max" => 'รายได้ผู้ปกครองต้องมีครวามยาวไม่เกิน 50 ตัวอักษร',
            ]);
            
            //check nationality of parent 2
            if($request->parent3_is_thai == "ไทย"){
                $parent3_nationality = "ไทย";
            }else{
                 $request->validate([
                     "parent3_nationality" => 'required|string|max:50',
                 ],[
                     "parent3_nationality.required" => 'ต้องระบุสัญชาตผู้ปกครอง',
                     "parent3_nationality.string" => 'ประเภทข้อมูลไม่ถูกต้อง',
                     "parent3_nationality.max" => 'สัญชาตผู้ปกครองงมีครวามยาวไม่เกิน :max ตัวอักษร',
                 ]);
 
                $parent3_nationality = $request->parent3_nationality;
            }
            // dd($main_parent_db['main_parent_only']);

            if($main_parent_db['main_parent_only']){//เช็คว่ามีอยู่แล้ว
                $parent3 = $main_parent_db;
            }else{
                $main_parent_db['is_main_parent'] = false;
                $main_parent_db['address_id'] = null;
                $main_parent_db->save();
                $parent3 = new Parents();
            }
            $parent3['borrower_id'] = $borrower['id'];
            $parent3['address_id'] = $main_parent_address_id;
            $parent3['borrower_relational'] = $request->parent3_relational;
            $parent3['nationality'] = $parent3_nationality;
            $parent3['prefix'] = $request->parent3_prefix;
            $parent3['firstname'] = $request->parent3_firstname;
            $parent3['lastname'] = $request->parent3_lastname;
            $parent3['birthday'] = $this->convert_date($request->parent3_birthday);
            $parent3['citizen_id'] = Crypt::encryptString($request->parent3_citizen_id);
            $parent3['phone'] = $request->parent3_phone;
            $parent3['email'] = $request->parent3_email;
            $parent3['occupation'] = $request->parent3_occupation;
            $parent3['place_of_work'] = $request->parent3_place_of_work;
            $parent3['income'] = $request->parent3_income;
            $parent3['alive'] = filter_var($request->parent3_alive, FILTER_VALIDATE_BOOLEAN);
            $parent3['is_main_parent'] = true;
            $parent3['main_parent_only'] = true;
            $parent3->save();
        }

        return redirect('/borrower/information/information_list')->with(['success'=>'แก้ใขข้อมูลผู้แทนโดยชอบธรรมเสร็จสิ้น']);
    }
}
