<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Crypt;
use App\Http\Requests\BorrowerInformationRequest;
use Carbon\Carbon;

use App\Models\Borrower;
use App\Models\Users;
use App\Models\Address;
use App\Models\BorrowerApprearanceType;
use App\Models\BorrowerNessessities;
use App\Models\BorrowerProperties;
use App\Models\Faculties;
use App\Models\Majors;
use App\Models\Nessessities;
use App\Models\Properties;


class BorrowerInforamtionController extends Controller
{
    private function convert_date($inputDate){
        $parsedDate = Carbon::createFromFormat('d-m-Y', $inputDate);
        $isoDate = $parsedDate->format('Y-m-d');
        return $isoDate;

    }

    public function getMajorByFaculty($faculty){
        $major = Majors::where('faculty_id',$faculty)->get();
        return json_encode($major);
    }

    public function index(){
        $user_id = Session::get('user_id','1');
        $borrower_id = Borrower::where('user_id',$user_id)->select('id')->first() ?? null;
        return view('borrower.information_list',compact('borrower_id'));
    }

    public function borrower_input_information(){
        $user_id = Session::get('user_id','1');
        $borrower_id = Session::get('borrower_id','1');
        $faculties = Faculties::where('isactive',true)->get();
        $majors = Majors::where('isactive',true)->get();
        $borrower_apprearance_types = BorrowerApprearanceType::where('isactive',true)->get();
        $nessessities = Nessessities::where('isactive',true)->get();
        $properties = Properties::where('isactive',true)->get();
        $user = Users::where('id',$user_id)->first();
        unset($user['password']);
        return view('borrower.information.borrower_input_information',compact('user','borrower_apprearance_types','nessessities','properties','faculties','majors'));
    }

    public function store_borrower_information(BorrowerInformationRequest $request){
        $user_id = Session::get('user_id','1');

        $user = Users::where('id',$user_id)->first();
        $user['prefix'] = $request->prefix;
        $user['firstname'] = $request->firstname;
        $user['lastname'] = $request->lastname;
        $user['email'] = $request->email;
        $user->save();

        $address = new Address();
        $address['village'] = $request->village;
        $address['house_no']=$request->house_no;
        $address['village_no']=$request->village_no;
        $address['street']=$request->street;
        $address['road']=$request->road;
        $address['postcode']=$request->postcode;
        $address['province']=$request->province;
        $address['aumphure']=$request->aumphure;
        $address['tambon']=$request->tambon;
        $address->save();

        $borrower = new Borrower();
        $borrower['user_id'] = $user_id;
        $borrower['birthday'] = $this->convert_date($request->birthday);
        $borrower['citizen_id'] = Crypt::encryptString($request->citizen_id);
        $borrower['student_id'] = $request->student_id;
        $borrower['faculty_id'] = $request->faculty;
        $borrower['major_id'] = $request->major;
        $borrower['grade'] = $request->grade;
        $borrower['gpa'] = $request->gpa;
        $borrower['phone'] = $request->phone;
        $borrower['address_id'] = $address['id'];
        $borrower['borrower_appearance_id'] = $request->borrower_appearance;
        $borrower['marital_status'] = json_encode('{"status":"","file_path":""}');
        $borrower->save();

        foreach($request->nessessities as $nessessity){
            BorrowerNessessities::create(['borrower_id'=>$borrower['id'],'nessessity_id'=>$nessessity]);
        }
        foreach($request->properties as $property){
            BorrowerProperties::create(['borrower_id'=>$borrower['id'],'property_id'=>$property]);
        }
        if(filter_var($request->morePropCheck, FILTER_VALIDATE_BOOLEAN)){
            $nessessity = new BorrowerNessessities();
            $nessessity['borrower_id'] = $borrower['id'];
            $nessessity['other'] = $request->necessMoreProp;
            $nessessity->save();
        }
        return redirect('/borrower/information_list')->with(['success'=> 'บันทึกข้อมูลผู้กู้เรียบร้อยแล้ว']);
    }

    public function borrower_edit_information_page(){
        $user_id = Session::get('user_id','1');
        $borrower_id = Session::get('borrower_id','1');

        $borrower =  Users::join('borrowers', function ($join) use ($user_id) {
            $join->on('users.id', '=', 'borrowers.user_id')
                 ->where('borrowers.user_id', '=', $user_id);
            })
            ->first();
        $faculties = Faculties::where('isactive',true)->get();
        $majors = Majors::where('isactive',true)->get();
        $borrower_apprearance_types = BorrowerApprearanceType::where('isactive',true)->get();
        $nessessities = Nessessities::where('isactive',true)->get();
        $properties = Properties::where('isactive',true)->get();
        $borrower_nessessities = BorrowerNessessities::where('borrower_id',$borrower_id)->where('nessessity_id',"!=",null)->pluck('nessessity_id')->toArray();
        $borrower_nessessity_other = BorrowerNessessities::where('borrower_id',$borrower_id)->where('nessessity_id',"=",null)->first() ?? null;
        $borrower_properties = BorrowerProperties::where('borrower_id',$borrower_id)->pluck('property_id')->toArray();
        $user = Users::where('id',$user_id)->first();
        $borrower['citizen_id'] = Crypt::decryptString($borrower['citizen_id']);
        $address = Address::find($borrower['address_id']);
        // dd($address);
        unset($user['password']);
        return view('borrower.information.borrower_edit_information',compact('user','borrower_apprearance_types','nessessities','properties','faculties','majors','borrower','address','borrower_nessessities','borrower_nessessity_other','borrower_properties'));
    }

    public function borrower_edit_information(BorrowerInformationRequest $request){
        // dd($request);
        $user_id = Session::get('user_id','1');
        $db_borrower = Borrower::where('user_id',$user_id)->first();
        $user = Users::where('id',$user_id)->first();
        $user['prefix'] = $request->prefix;
        $user['firstname'] = $request->firstname;
        $user['lastname'] = $request->lastname;
        $user['email'] = $request->email;
        $user->save();

        $address = Address::find($db_borrower['address_id']);
        $address['village'] = $request->village;
        $address['house_no']=$request->house_no;
        $address['village_no']=$request->village_no;
        $address['street']=$request->street;
        $address['road']=$request->road;
        $address['postcode']=$request->postcode;
        $address['province']=$request->province;
        $address['aumphure']=$request->aumphure;
        $address['tambon']=$request->tambon;
        $address->save();

        $borrower = $db_borrower;
        $borrower['user_id'] = $user_id;
        $borrower['birthday'] = $this->convert_date($request->birthday);
        $borrower['citizen_id'] = Crypt::encryptString($request->citizen_id);
        $borrower['student_id'] = $request->student_id;
        $borrower['faculty_id'] = $request->faculty;
        $borrower['major_id'] = $request->major;
        $borrower['grade'] = $request->grade;
        $borrower['gpa'] = $request->gpa;
        $borrower['phone'] = $request->phone;
        $borrower['address_id'] = $address['id'];
        $borrower['borrower_appearance_id'] = $request->borrower_appearance;
        $borrower['marital_status'] = json_encode('{"status":"","file_path":""}');
        $borrower->save();

        BorrowerNessessities::where('borrower_id',$borrower['id'])->delete();
        BorrowerProperties::where('borrower_id',$borrower['id'])->delete();

        foreach($request->nessessities as $nessessity){
            BorrowerNessessities::create(['borrower_id'=>$borrower['id'],'nessessity_id'=>$nessessity]);
        }
        foreach($request->properties as $property){
            BorrowerProperties::create(['borrower_id'=>$borrower['id'],'property_id'=>$property]);
        }
        if(filter_var($request->morePropCheck, FILTER_VALIDATE_BOOLEAN)){
            $nessessity = new BorrowerNessessities();
            $nessessity['borrower_id'] = $borrower['id'];
            $nessessity['other'] = $request->necessMoreProp;
            $nessessity->save();
        }
        return redirect('/borrower/information_list')->with(['success'=> 'แก้ใขข้อมูลผู้กู้เรียบร้อยแล้ว']);
    }
}
