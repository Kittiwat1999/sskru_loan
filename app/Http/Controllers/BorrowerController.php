<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrower;
use App\Models\Users;
use App\Models\Address;
use App\Models\Parents;
use Carbon\Carbon;
use App\Http\Requests\borrowerInformationValidationRequest;
use App\Models\BorrowerApprearanceType;
use App\Models\BorrowerNessessities;
use App\Models\BorrowerProperties;
use App\Models\Nessessities;
use App\Models\Properties;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class BorrowerController extends Controller
{

    public function testGetdata(){
        // return Borrower::getBorrowerData();
        $user_id = Session::get('user_id','1');

        // $borrower =  Users::join('borrowers', function ($join) use ($user_id) {
        //     $join->on('users.id', '=', 'borrowers.user_id')
        //          ->where('borrowers.user_id', '=', $user_id);
        // })
        // ->first();
        // dd($borrower);

        $borrower = Borrower::with('users')->get();
        dd($borrower);

    }

    public function getBorrowerInformation(){

        $user_id = Session::get('user_id','1');
        $borrower_id = Session::get('borrower_id','1');

        $borrower =  Users::join('borrowers', function ($join) use ($user_id) {
            $join->on('users.id', '=', 'borrowers.user_id')
                 ->where('borrowers.user_id', '=', $user_id);
        })
        ->first();

        $borrower_apprearance_types = BorrowerApprearanceType::where('isactive',true)->get();
        $nessessities = Nessessities::where('isactive',true)->get();
        $properties = Properties::where('isactive',true)->get();

        $user = Users::where('id',$user_id)->first();
        // dd($user);
        unset($borrower['password']);
        unset($user['password']);

        // dd($user,$borrower);
        
        if ($borrower === null){
            return view('/borrower/information',compact('user','borrower_apprearance_types','nessessities','properties'));

        }else{

            // dd($get_borrower[0]['address_id']);
            $address = Address::where('id',$borrower['address_id'])->first();
            $borrower['marital_status'] = json_decode($borrower['marital_status']);
            $borrower_nessessities = BorrowerNessessities::where('borrower_id',$borrower_id)->where('nessessity_id',"!=",null)->pluck('nessessity_id')->toArray();
            $borrower_nessessity_other = BorrowerNessessities::where('borrower_id',$borrower_id)->where('nessessity_id',"=",null)->first() ?? null;
            $borrower_properties = BorrowerProperties::where('borrower_id',$borrower_id)->pluck('property_id')->toArray();
            $get_parent = Parents::where('borrower_id',$borrower_id)->orderby('id')->get();

            if(count($get_parent) == 1){
                $parent1 = $get_parent[0];
                if($borrower['address_id'] == $parent1['address_id']){
                    $parent_address = $address;
                }else{
                    $parent_address = Address::where('id',$parent1['address_id'])->first();
                }
    
                // dd($borrower,$user_information,$address);
                return view('/borrower/information',compact('borrower','address','parent1','parent_address','borrower_apprearance_types','nessessities','properties','borrower_nessessities','borrower_properties','borrower_nessessity_other'));
            }else{
                $parent1 = $get_parent[0];
                $parent2 = $get_parent[1];
                
                if($parent1['is_main_parent'] == null){
                    if($borrower['address_id'] == $parent2['address_id']){
                        $parent_address = $address;
                    }else{
                        $parent_address = Address::where('id',$parent2['address_id'])->first();
                    }
                }else{
                    if($borrower['address_id'] == $parent1['address_id']){
                        $parent_address = $address;
                    }else{
                        $parent_address = Address::where('id',$parent1['address_id'])->first();
                    }
                }
                

    
                // dd($borrower,$parent_address,$address);
                return view('/borrower/information',compact('borrower','address','parent1','parent2','parent_address','borrower_apprearance_types','nessessities','properties','borrower_nessessities','borrower_properties','borrower_nessessity_other'));
            }
        }
    }

    // borrowerInformationValidationRequest
    function storeInformation(borrowerInformationValidationRequest $request){
        
        // dd($request);
        $user_id = Session::get('user_id','1');
        date_default_timezone_set("Asia/Bangkok");
        
        $user = Users::where('id',$user_id)->first();
        $user['prefix'] = $request->prefix;
        $user['firstname'] = $request->firstname;
        $user['lastname'] = $request->lastname;
        $user['email'] = $request->email;
        
        $user->save();

        //marital status
        if($request->marital_status == "อยู่ด้วยกัน"){
            $marital_status = ['status'=>'อยู่ด้วยกัน','file_path'=>''];
        }else if($request->marital_status == "other"){
            $marital_status = ['status'=>$request->other_text,'file_path'=>''];
        }else if($request->marital_status == "แยกกันอยู่ตามอาชีพ"){
            $marital_status = ['status'=>'แยกกันอยู่ตามอาชีพ','file_path'=>''];
        }else if($request->marital_status == "หย่า"){

            $file_validator = Validator::make($request->all(), [
                "devorce_file" => 'required|file|max:2048|mimes:jpg,jpeg,png,pdf',
            ]);
        
            // Check if validation fails
            if ($file_validator->fails()) {
                return redirect('/borrower/information')
                    ->withErrors($file_validator)
                    ->withInput();
            }

            $file = $request->file('devorce_file');
            
            $file_name = $file->getClientOriginalName();
            $spit_filename = explode('.', $file_name);
            $file_extenstion = last($spit_filename);

            if(($file_extenstion != 'png' && $file_extenstion != 'jpg') && ($file_extenstion != 'jpeg' && $file_extenstion != 'pdf')){
                $error =['devorce_file'=>'ประเภทไฟล์ต้องเป็น .jpg .png .pdf เท่านั้น'];
                return $error;
            }

            $file_path = $this->storeFile($file);

            $marital_status = ['status'=>'หย่า','file_path'=>$file_path];
        }
        
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

        $borrower_address_id = $address['id'];

        //check address parent are living with borrower
        if(isset($request->address_with_borrower)){
            $parent_address_id = $borrower_address_id;
        }else{

            $address_validator = Validator::make($request->all(), [
                "main_parent_village" => 'required|string|max:50',
                "main_parent_house_no" => 'required|string|max:20',
                "main_parent_village_no" => 'required|string|max:20',
                "main_parent_street" => 'required|string|max:100',
                "main_parent_road" => 'required|string|max:100',
                "main_parent_postcode" => 'required|string|max:10',
                "main_parent_province" => 'required|string|max:50',
                "main_parent_aumphure" => 'required|string|max:50',
                "main_parent_tambon" => 'required|string|max:50',
            ]);
        
            // Check if validation fails
            if ($address_validator->fails()) {
                return redirect('/borrower/information')
                    ->withErrors($address_validator)
                    ->withInput();
            }

            $parent_address = new Address();
            $parent_address['village'] = $request->main_parent_village;
            $parent_address['house_no']=$request->main_parent_house_no;
            $parent_address['village_no']=$request->main_parent_village_no;
            $parent_address['street']=$request->main_parent_street;
            $parent_address['road']=$request->main_parent_road;
            $parent_address['postcode']=$request->main_parent_postcode;
            $parent_address['province']=$request->main_parent_province;
            $parent_address['aumphure']=$request->main_parent_aumphure;
            $parent_address['tambon']=$request->main_parent_tambon;
            $parent_address->save();
    
            $parent_address_id = $parent_address['id'];
        }

        $borrower = new Borrower();
        $borrower['user_id'] = $user_id;
        $borrower['birthday'] = $request->birthday;
        $borrower['citizen_id'] = $request->citizen_id;
        $borrower['student_id'] = $request->student_id;
        $borrower['faculty'] = $request->faculty;
        $borrower['major'] = $request->major;
        $borrower['grade'] = $request->grade;
        $borrower['gpa'] = $request->gpa;
        $borrower['phone'] = $request->phone;
        $borrower['address_id'] = $borrower_address_id;
        $borrower['borrower_appearance_id'] = $request->borrower_appearance;
        $borrower['marital_status'] = json_encode($marital_status);
        $borrower->save();

        //check nationality of parent 1
        if($request->parent1_is_thai == "ไทย"){
            $parent1_nationality = "ไทย";
        }else{
            $parent1_nationality = $request->parent1_nationality;
        }

        $parent1 = new Parents();
        $parent1['borrower_id'] = $borrower['id'];
        $parent1['borrower_relational'] = $request->parent1_relational;
        $parent1['nationality'] = $parent1_nationality;
        $parent1['prefix'] = $request->parent1_prefix;
        $parent1['firstname'] = $request->parent1_firstname;
        $parent1['lastname'] = $request->parent1_lastname;
        $parent1['birthday'] = $request->parent1_birthday;
        $parent1['citizen_id'] = $request->parent1_citizen_id;
        $parent1['phone'] = $request->parent1_phone;
        $parent1['occupation'] = $request->parent1_occupation;
        $parent1['income'] = $request->parent1_income;
        $parent1['alive'] = filter_var($request->parent1_alive, FILTER_VALIDATE_BOOLEAN);
        // $parent1->save()


        //parent 2 have data
        if(filter_var($request->parent2_no_data, FILTER_VALIDATE_BOOLEAN))
        {
            $parent2_have_data = false;
        }else{
            
            $parent2_validator = Validator::make($request->all(), [
               "parent2_is_thai" => 'required|string|max:50',
               
               "parent2_alive" => 'required|string|max:10',
               "parent2_relational" => 'required|string|max:20',
               "parent2_prefix" => 'required|string|max:50',
               "parent2_firstname" => 'required|string|max:100',
               "lastname" => 'required|string|max:100',
               "parent2_birthday" => 'required|string|max:20',
               "parent2_citizen_id" => 'required|string|max:50',
               "parent2_phone" => 'required|string|max:50',
               "parent2_occupation" => 'required|string|max:100',
               "parent2_income" => 'required|string|max:50',
            ]);
            
            // Check if validation fails
            if ($parent2_validator->fails()) {
                return redirect('/borrower/information')
                ->withErrors($parent2_validator)
                ->withInput();
            }
            
            //check nationality of parent 2
           if($request->parent2_is_thai == "ไทย"){
               $parent2_nationality = "ไทย";
           }else{
                $parent1_nationality_validator = Validator::make($request->all(),[
                    "parent2_nationality" => 'required|string|max:50',
                ]);

                // Check if validation fails
                if ($parent1_nationality_validator->fails()) {
                    return redirect('/borrower/information')
                    ->withErrors($parent2_validator)
                    ->withInput();
                }

               $parent2_nationality = $request->parent2_nationality;
           }

            $parent2 = new Parents();
            $parent2['borrower_id'] = $borrower['id'];
            $parent2['borrower_relational'] = $request->parent2_relational;
            $parent2['nationality'] = $parent2_nationality;
            $parent2['prefix'] = $request->parent2_prefix;
            $parent2['firstname'] = $request->parent2_firstname;
            $parent2['lastname'] = $request->parent2_lastname;
            $parent2['birthday'] = $request->parent2_birthday;
            $parent2['citizen_id'] = $request->parent2_citizen_id;
            $parent2['phone'] = $request->parent2_phone;
            $parent2['occupation'] = $request->parent2_occupation;
            $parent2['income'] = $request->parent2_income;
            $parent2['alive'] = filter_var($request->parent2_alive, FILTER_VALIDATE_BOOLEAN);

            $parent2_have_data = true;
        }    

        // add address to main parent 
        if($request->main_parent == "parent1"){
            $parent1['address_id'] = $parent_address_id;
            $parent1['is_main_parent'] = true;
            $parent2['is_main_parent'] = false;
        }else if($request->main_parent == "parent2"){
            $parent2['address_id'] = $parent_address_id;
            $parent2['is_main_parent'] = true;
            $parent1['is_main_parent'] = false;

        }

        // insert to database
        $parent1->save();
        if($parent2_have_data)$parent2->save();

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

        return redirect()->back()->with(['success'=>'บันมึกข้อมูลเสร็จสิ้น']);
    }

    function borrowerEditdata(borrowerInformationValidationRequest $request){

        $user_id = Session::get('user_id','1');
        $borrower_id = Session::get('borrower_id','1');
        date_default_timezone_set("Asia/Bangkok");
        
        $user = Users::where('id',$user_id)->first();
        $user['prefix'] = $request->prefix;
        $user['firstname'] = $request->firstname;
        $user['lastname'] = $request->lastname;
        $user['email'] = $request->email;
        $user->save();

        $borrower_from_db = Borrower::where('user_id',$user_id)->first();
        $main_parents_from_db = Parents::where('borrower_id',$borrower_id)->where('is_main_parent',true)->first();
        $parents_from_db = Parents::where('borrower_id',$borrower_id)->get();
        $marital_db = json_decode($borrower_from_db->marital_status);

        //check old status is not equal new status and old is หย่า
        if($request->marital_status != $marital_db->status && ($marital_db->status == "หย่า")){
            $this->deleteFile($marital_db->file_path);
        }

        //marital status
        if($request->marital_status == "อยู่ด้วยกัน"){
            $marital_status = ['status'=>'อยู่ด้วยกัน','file_path'=>''];
        }else if($request->marital_status == "other"){
            $marital_status = ['status'=>$request->other_text,'file_path'=>''];
        }else if($request->marital_status == "แยกกันอยู่ตามอาชีพ"){
            $marital_status = ['status'=>'แยกกันอยู่ตามอาชีพ','file_path'=>''];
        }else if($request->marital_status == "หย่า"){

            //check if have new file delete old file
            if($request->file('devorce_file') != null){
                $this->deleteFile($marital_db->file_path);
            }

            //validate file
            $file_validator = Validator::make($request->all(), [
                "devorce_file" => 'required|file|max:2048|mimes:jpg,jpeg,png,pdf',
            ]);
        
            // Check if validation fails
            if ($file_validator->fails()) {
                return redirect('/borrower/information')
                    ->withErrors($file_validator)
                    ->withInput();
            }

            $file = $request->file('devorce_file');
            
            $file_name = $file->getClientOriginalName();
            $spit_filename = explode('.', $file_name);
            $file_extenstion = last($spit_filename);

            if(($file_extenstion != 'png' && $file_extenstion != 'jpg') && ($file_extenstion != 'jpeg' && $file_extenstion != 'pdf')){
                $error =['devorce_file'=>'ประเภทไฟล์ต้องเป็น .jpg .png .pdf เท่านั้น'];
                return $error;
            }

            $file_path = $this->storeFile($file);

            $marital_status = ['status'=>'หย่า','file_path'=>$file_path];
        }

        $address = Address::where('id',$borrower_from_db->address_id)->first();
        $address['village'] = $request->village;
        $address['house_no'] = $request->house_no;
        $address['village_no'] = $request->village_no;
        $address['street'] = $request->street;
        $address['road'] = $request->road;
        $address['postcode'] = $request->postcode;
        $address['province'] = $request->province;
        $address['aumphure'] = $request->aumphure;
        $address['tambon'] = $request->tambon;
        $address->save();
        
        //check address parent are living with borrower
        if($request->address_with_borrower != null){

            //if change from not living to living
            if($main_parents_from_db->address_id != $borrower_from_db->address_id){

                $parent_address = Address::find($main_parents_from_db->address_id);
                
                if ($parent_address) {
                    $parent_address->delete();
                }
            }
            $parent_address_id = $borrower_from_db->address_id;
            
        }else{

            $address_validator = Validator::make($request->all(), [
                "main_parent_village" => 'required|string|max:50',
                "main_parent_house_no" => 'required|string|max:20',
                "main_parent_village_no" => 'required|string|max:20',
                "main_parent_street" => 'required|string|max:100',
                "main_parent_road" => 'required|string|max:100',
                "main_parent_postcode" => 'required|string|max:10',
                "main_parent_province" => 'required|string|max:50',
                "main_parent_aumphure" => 'required|string|max:50',
                "main_parent_tambon" => 'required|string|max:50',
            ]);
        
            // Check if validation fails
            if ($address_validator->fails()) {
                return redirect('/borrower/information')
                    ->withErrors($address_validator)
                    ->withInput();
            }

            $parent_address = new Address();
            $parent_address['village'] = $request->main_parent_village;
            $parent_address['house_no'] = $request->main_parent_house_no;
            $parent_address['village_no'] = $request->main_parent_village_no;
            $parent_address['street'] = $request->main_parent_street;
            $parent_address['road'] = $request->main_parent_road;
            $parent_address['postcode'] = $request->main_parent_postcode;
            $parent_address['province'] = $request->main_parent_province;
            $parent_address['aumphure'] = $request->main_parent_aumphure;
            $parent_address['tambon'] = $request->main_parent_tambon;

            // if change form living with borrower to not living with borrower
            if($main_parents_from_db->address_id == $borrower_from_db->address_id){

                $parent_address->save();
                $parent_address_id = $parent_address['id'];
                
            }else{
                Address::where('id',$main_parents_from_db->address_id)->update($parent_address);
                
                $parent_address_id = $main_parents_from_db->address_id;
            }
        }

        //check nationality of parent 1
        if($request->parent1_is_thai == "ไทย"){
            $parent1_nationality = "ไทย";
        }else{
            $parent1_nationality = $request->parent1_nationality;
        }
        // dd($request->parent1_nationality);

        $parent1 = [
            'borrower_id'=>$borrower_id,
            'borrower_relational'=>$request->parent1_relational,
            'nationality'=>$parent1_nationality,
            'prefix'=>$request->parent1_prefix,
            'firstname'=>$request->parent1_firstname,
            'lastname'=>$request->parent1_lastname,
            'birthday'=>$request->parent1_birthday,
            'citizen_id'=>$request->parent1_citizen_id,
            'phone'=>$request->parent1_phone,
            'occupation'=>$request->parent1_occupation,
            'income'=>$request->parent1_income,
            'alive'=>filter_var($request->parent1_alive, FILTER_VALIDATE_BOOLEAN),
            'updated_at'=>date('Y-m-d H:i:s')
        ];


        //parent 2 have data
        if(filter_var($request->parent2_no_data, FILTER_VALIDATE_BOOLEAN))
        {   
            //if change from have data to no data
            if(isset($parents_from_db[1])){

                $parent2_find = Parents::find($parents_from_db[1]->id);
                
                if ($parent2_find) {
                    $parent2_find->delete();
                }
            }
            $parent2_have_data = false;

        }else{
            
            $parent2_validator = Validator::make($request->all(), [
               "parent2_is_thai" => 'required|string|max:50',
               
               "parent2_alive" => 'required|string|max:10',
               "parent2_relational" => 'required|string|max:20',
               "parent2_prefix" => 'required|string|max:50',
               "parent2_firstname" => 'required|string|max:100',
               "parent2_lastname" => 'required|string|max:100',
               "parent2_birthday" => 'required|string|max:20',
               "parent2_citizen_id" => 'required|string|max:50',
               "parent2_phone" => 'required|string|max:50',
               "parent2_occupation" => 'required|string|max:100',
               "parent2_income" => 'required|string|max:50',
            ]);
            
            // Check if validation fails
            if ($parent2_validator->fails()) {
                return redirect('/borrower/information')
                ->withErrors($parent2_validator)
                ->withInput();
            }
            
            //check nationality of parent 2
           if($request->parent2_is_thai == "ไทย"){
               $parent2_nationality = "ไทย";
           }else{
                $parent1_nationality_validator = Validator::make($request->all(),[
                    "parent2_nationality" => 'required|string|max:50',
                ]);

                // Check if validation fails
                if ($parent1_nationality_validator->fails()) {
                    return redirect('/borrower/information')
                    ->withErrors($parent2_validator)
                    ->withInput();
                }

               $parent2_nationality = $request->parent2_nationality;
           }


           $parent2 = [
               'borrower_id'=>$borrower_id,
               'borrower_relational'=>$request->parent2_relational,
               'nationality'=>$parent2_nationality,
               'prefix'=>$request->parent2_prefix,
               'firstname'=>$request->parent2_firstname,
               'lastname'=>$request->parent2_lastname,
               'birthday'=>$request->parent2_birthday,
               'citizen_id'=>$request->parent2_citizen_id,
               'phone'=>$request->parent2_phone,
               'occupation'=>$request->parent2_occupation,
               'income'=>$request->parent2_income,
               'alive'=>filter_var($request->parent2_alive, FILTER_VALIDATE_BOOLEAN),
               'updated_at'=>date('Y-m-d H:i:s')
           ];

           $parent2_have_data = true;
        }    


        // add address to main parent 
        if($request->main_parent == "parent1"){
            $parent1['is_main_parent'] = true;
            $parent1['address_id'] = $parent_address_id;
            $parent2['address_id'] = null;
            $parent2['is_main_parent'] = false;
        }else if($request->main_parent == "parent2"){
            $parent2['is_main_parent'] = true;
            $parent2['address_id'] = $parent_address_id;
            $parent1['is_main_parent'] = false;
            $parent1['address_id'] = null;
        }

        

        // insert to database
        $parent1_updated = Parents::where('id',$parents_from_db[0]->id)->update($parent1);
        if($parent2_have_data){
            //if parent 2 not found data
            if(isset($parents_from_db[1])){
                $parent2_updated = Parents::where('id',$parents_from_db[1]->id)->update($parent2);
            }else{
                $parent2_updated = Parents::create($parent2);
            }
        }

        $borrower = [
            'user_id'=>$user_id,
            'birthday'=>$request->birthday,
            'citizen_id'=>$request->citizen_id,
            'student_id'=>$request->student_id,
            'faculty'=>$request->faculty,
            'major'=>$request->major,
            'grade'=>$request->grade,
            'gpa'=>$request->gpa,
            'borrower_appearance_id'=>$request->borrower_appearance,
            'phone'=>$request->phone,
            'address_id'=>$borrower_from_db->address_id,
            'marital_status'=>json_encode($marital_status),
            'updated_at'=>date('Y-m-d H:i:s')
        ];

        Borrower::where('id',$borrower_id)->update($borrower);
        BorrowerNessessities::where('borrower_id',$borrower_id)->delete();
        BorrowerProperties::where('borrower_id',$borrower_id)->delete();

        foreach($request->nessessities as $nessessity){
            BorrowerNessessities::create(['borrower_id'=>$borrower_id,'nessessity_id'=>$nessessity]);
        }
        foreach($request->properties as $property){
            BorrowerProperties::create(['borrower_id'=>$borrower_id,'property_id'=>$property]);
        }

        if(filter_var($request->morePropCheck, FILTER_VALIDATE_BOOLEAN)){
            $nessessity = new BorrowerNessessities();
            $nessessity['borrower_id'] = $borrower['id'];
            $nessessity['other'] = $request->necessMoreProp;
            $nessessity->save();
        }
        return redirect()->back()->with(['success'=>'แก้ใขข้อมูลเสร็จสิ้น']);

    }

    public function deleteFile($file)
    {
        $path = storage_path('mariatal/'.$file);

        if (File::exists($path)) {
            File::delete($path);
        } else {
            echo 'File does not exist.';
        }
    }

    private function storeFile($file,)
    {
        $path = storage_path('mariatal/');

        !file_exists($path) && mkdir($path, 0777, true);

        $name = now()->format('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
        $file->move($path, $name);

        return $name;
    }

    public function displayFile($file)
    {
        $path = storage_path('mariatal/'.$file);

        if (!File::exists($path)) {
            abort(404);
        }

        $file = File::get($path);
        $type = File::mimeType($path);

        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);

        return $response;
    }
    
}