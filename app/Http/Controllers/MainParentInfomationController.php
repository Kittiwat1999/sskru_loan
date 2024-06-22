<?php

namespace App\Http\Controllers;

use App\Http\Requests\MainParentInformationRequest;
use App\Models\Address;
use App\Models\Borrower;
use App\Models\Parents;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

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

    public function borrower_store_main_parent_information(MainParentInformationRequest $request){
        // dd($request);
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
        }

        return redirect('/borrower/information/information_list')->with(['success'=>'บันทึกข้อมูลผู้แทนโดยชอบธรรมเสร็จสิ้น']);
    }
}
