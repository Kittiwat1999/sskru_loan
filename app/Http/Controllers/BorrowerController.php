<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrower;
use App\Models\Users;
use App\Models\Address;
use App\Models\Parents;
use Carbon\Carbon;
use App\Http\Requests\borrowerInformationValidationRequest;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Storage;

class BorrowerController extends Controller
{

    public function testGetdata(){
        // return Borrower::getBorrowerData();
        $user_id = 1;

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

        $user_id = 1;

        $borrower =  Users::join('borrowers', function ($join) use ($user_id) {
            $join->on('users.id', '=', 'borrowers.user_id')
                 ->where('borrowers.user_id', '=', $user_id);
        })
        ->first();

        $user = Users::where('id',$user_id)->first();

        unset($borrower['password']);
        unset($user['password']);

        // dd($user,$borrower);
        
        if ($borrower === null){
            return view('/borrower/information',compact('user'));

        }else{

            // dd($get_borrower[0]['address_id']);
            $address = Address::where('id',$borrower['address_id'])->first();
            

            $borrower['borrower_necessity'] = json_decode($borrower['borrower_necessity']);
            $borrower['borrower_properties'] = json_decode($borrower['borrower_properties']);
            $borrower['marital_status'] = json_decode($borrower['marital_status']);
            
            $get_parent = Parents::where('user_id',$user_id)->orderby('id')->get();

            // dd($get_parent);
            // dd(count($get_parent));s
            if(count($get_parent) == 1){
                $parent1 = $get_parent[0];
                if($borrower['address_id'] == $parent1['address_id']){
                    $parent_address = $address;
                }else{
                    $parent_address = Address::where('id',$parent1['address_id'])->first();
                }
    
                // dd($borrower,$user_information,$address);
                return view('/borrower/information',compact('borrower','address','parent1','parent_address'));
            }else{
                $parent1 = $get_parent[0];
                $parent2 = $get_parent[1];
                
                if($parent1['address_id'] == null){
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
                

    
                // dd($borrower,$user_information,$address);
                return view('/borrower/information',compact('borrower','address','parent1','parent2','parent_address'));
            }
        }
    }

    // borrowerInformationValidationRequest
    function storeInformation(borrowerInformationValidationRequest $request){
        
        // dd($request);
        $user_id = 1;
        date_default_timezone_set("Asia/Bangkok");
        
        
        $update_user=[
            'prefix'=>$request->prefix,
            'fname'=>$request->fname,
            'lname'=>$request->lname,
            'email'=>$request->email,
        ];
        
        Users::where('id',$user_id)->update($update_user);

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

            $currentYear = Carbon::now()->year;
            $thaiBuddhistYear = $currentYear + 543;
            $uploadDirectory = 'public/uploads/'.$thaiBuddhistYear.'/'.$user_id;
            $displayDirectory = 'storage/uploads/'.$thaiBuddhistYear.'/'.$user_id;

            $file = $request->file('devorce_file');

            // dd($file);
            
            $new_file_name = $file->getClientOriginalName();
            $new_file_name = 'marital'.time().$new_file_name;

            // check file type
            $get_fullfilename = $new_file_name;
            $spit_filename = explode('.', $get_fullfilename);
            $file_extenstion = last($spit_filename);

            if(($file_extenstion != 'png' && $file_extenstion != 'jpg') && ($file_extenstion != 'jpeg' && $file_extenstion != 'pdf')){
                $error =['devorce_file'=>'ประเภทไฟล์ต้องเป็น .jpg .png .pdf เท่านั้น'];
                return $error;
            }

            $request->file('devorce_file')->storeAs($uploadDirectory,$new_file_name);

            $marital_status = ['status'=>'หย่า','file_path'=>$displayDirectory.'/'.$new_file_name];
        }
        
        $address = [
            'village'=>$request->village ,
            'house_no'=>$request->house_no ,
            'village_no'=>$request->village_no ,
            'street'=>$request->street ,
            'road'=>$request->road ,
            'postcode'=>$request->postcode ,
            'province'=>$request->province ,
            'aumphure'=>$request->aumphure ,
            'tambon'=>$request->tambon ,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];

        Address::create($address);
        
        //get address id
        $get_address = Address::where('created_at',$address['created_at'])->where('postcode',$address['postcode'])->where('house_no',$address['house_no'])->where('village_no',$address['village_no'])->get();
        $borrower_address_id = $get_address['0']['id'];

        
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

            $address = [
                'village'=>$request->main_parent_village ,
                'house_no'=>$request->main_parent_house_no ,
                'village_no'=>$request->main_parent_village_no ,
                'street'=>$request->main_parent_street ,
                'road'=>$request->main_parent_road ,
                'postcode'=>$request->main_parent_postcode ,
                'province'=>$request->main_parent_province ,
                'aumphure'=>$request->main_parent_aumphure ,
                'tambon'=>$request->main_parent_tambon ,
                'created_at'=>date('Y-m-d H:i:s'),
                'updated_at'=>date('Y-m-d H:i:s')
            ];
    
            Address::create($address);
    
            $get_address = Address::where('created_at',$address['created_at'])->where('postcode',$address['postcode'])->where('house_no',$address['house_no'])->where('village_no',$address['village_no'])->get();
            $parent_address_id = $get_address['0']['id'];
        }

        //check nationality of parent 1
        if($request->parent1_is_thai == "ไทย"){
            $parent1_nationality = "ไทย";
        }else{
            $parent1_nationality = $request->parent1_nationality;
        }
        // dd($request->parent1_nationality);

        $parent1 = [
            'user_id'=>$user_id,
            'borrower_relational'=>$request->parent1_relational,
            'nationality'=>$parent1_nationality,
            'prefix'=>$request->parent1_prefix,
            'fname'=>$request->parent1_fname,
            'lname'=>$request->parent1_lname,
            'birthday'=>$request->parent1_birthday,
            'citizen_id'=>$request->parent1_citizen_id,
            'phone'=>$request->parent1_phone,
            'occupation'=>$request->parent1_occupation,
            'income'=>$request->parent1_income,
            'alive'=>filter_var($request->parent1_alive, FILTER_VALIDATE_BOOLEAN),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];


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
               "parent2_fname" => 'required|string|max:100',
               "parent2_lname" => 'required|string|max:100',
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
               'user_id'=>$user_id,
               'borrower_relational'=>$request->parent2_relational,
               'nationality'=>$parent2_nationality,
               'prefix'=>$request->parent2_prefix,
               'fname'=>$request->parent2_fname,
               'lname'=>$request->parent2_lname,
               'birthday'=>$request->parent2_birthday,
               'citizen_id'=>$request->parent2_citizen_id,
               'phone'=>$request->parent2_phone,
               'occupation'=>$request->parent2_occupation,
               'income'=>$request->parent2_income,
               'alive'=>filter_var($request->parent2_alive, FILTER_VALIDATE_BOOLEAN),
               'created_at'=>date('Y-m-d H:i:s'),
               'updated_at'=>date('Y-m-d H:i:s')
           ];

           $parent2_have_data = true;
        }    

        // dd($parent2_have_data);

        // dd($request->main_parent);
        

        // add address to main parent 
        if($request->main_parent == "parent1"){
            $parent1['address_id'] = $parent_address_id;
            $parent_citizen_id = $request->parent1_citizen_id;
            $parent_create_at = $parent1['created_at'];
        }else if($request->main_parent == "parent2"){
            $parent2['address_id'] = $parent_address_id;
            $parent_citizen_id = $request->parent2_citizen_id;
            $parent_create_at = $parent2['created_at'];
        }

        

        // insert to database
        Parents::create($parent1);
        if($parent2_have_data)Parents::create($parent2);

        $get_main_parent = Parents::where('citizen_id',$parent_citizen_id)->where('created_at',$parent_create_at)->get();
        $main_parent_id = $get_main_parent['0']['id'];

        // dd($main_parent_id);

        $borrower = [
            'user_id'=>$user_id,
            'birthday'=>$request->birthday,
            'citizen_id'=>$request->citizen_id,
            'student_id'=>$request->student_id,
            'faculty'=>$request->faculty,
            'major'=>$request->major,
            'grade'=>$request->grade,
            'gpa'=>$request->gpa,
            'borrower_appearance'=>$request->borrower_appearance,
            'phone_number'=>$request->phone_number,
            'address_id'=>$borrower_address_id,
            'borrower_necessity'=>json_encode($request->necess),
            'borrower_properties'=>json_encode($request->props),
            'parents_id'=>$main_parent_id,
            'marital_status'=>json_encode($marital_status),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];

        Borrower::create($borrower);
        // $get_borrower = Borrower::where('user_id',$user_id)->get();
        // $get_user = Users::where('id',$user_id)->get();
        // dd($parent1,$parent2,$borrower);

        return redirect('/borrower/information');
    }

    function borrowerEditdata(borrowerInformationValidationRequest $request){

        $user_id = 1;
        date_default_timezone_set("Asia/Bangkok");
        
        
        $update_user=[
            'prefix'=>$request->prefix,
            'fname'=>$request->fname,
            'lname'=>$request->lname,
            'email'=>$request->email,
        ];
        
        Users::where('id',$user_id)->update($update_user);

        $borrower_from_db = Borrower::where('user_id',$user_id)->first();
        $main_parents_from_db = Parents::where('id',$borrower_from_db->parents_id)->first();
        $parents_from_db = Parents::where('user_id',$user_id)->get();

        // dd($parents_from_db);

        $marital_db = json_decode($borrower_from_db->marital_status);

        //check old status is not equal new status and old is หย่า
        if($request->marital_status != $marital_db->status && ($marital_db->status == "หย่า")){
            $file_path = str_replace('storage', 'public', $marital_db->file_path);

            if (Storage::exists($file_path)) {
                // Delete the file
                Storage::delete($file_path);
            }
        }

        // dd($request->marital_status);
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

                $file_path = str_replace('storage', 'public', $marital_db->file_path);

                if (Storage::exists($file_path)) {
                    // Delete the file
                    Storage::delete($file_path);
                }
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

            $currentYear = Carbon::now()->year;
            $thaiBuddhistYear = $currentYear + 543;
            $uploadDirectory = 'public/uploads/'.$thaiBuddhistYear.'/'.$user_id;
            $displayDirectory = 'storage/uploads/'.$thaiBuddhistYear.'/'.$user_id;

            $file = $request->file('devorce_file');

            // dd($file);
            
            $new_file_name = $file->getClientOriginalName();
            $new_file_name = 'marital'.time().$new_file_name;

            // check file type
            $get_fullfilename = $new_file_name;
            $spit_filename = explode('.', $get_fullfilename);
            $file_extenstion = last($spit_filename);

            if(($file_extenstion != 'png' && $file_extenstion != 'jpg') && ($file_extenstion != 'jpeg' && $file_extenstion != 'pdf')){
                $error =['devorce_file'=>'ประเภทไฟล์ต้องเป็น .jpg .png .pdf เท่านั้น'];
                return $error;
            }

            $request->file('devorce_file')->storeAs($uploadDirectory,$new_file_name);

            $marital_status = ['status'=>'หย่า','file_path'=>$displayDirectory.'/'.$new_file_name];
        }


        $address = [
            'village'=>$request->village ,
            'house_no'=>$request->house_no ,
            'village_no'=>$request->village_no ,
            'street'=>$request->street ,
            'road'=>$request->road ,
            'postcode'=>$request->postcode ,
            'province'=>$request->province ,
            'aumphure'=>$request->aumphure ,
            'tambon'=>$request->tambon ,
            'updated_at'=>date('Y-m-d H:i:s')
        ];

        Address::where('id',$borrower_from_db->address_id)->update($address);
        
        //check address parent are living with borrower
        // dd($request->address_with_borrower);
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

            $address_parent = [
                'village'=>$request->main_parent_village ,
                'house_no'=>$request->main_parent_house_no ,
                'village_no'=>$request->main_parent_village_no ,
                'street'=>$request->main_parent_street ,
                'road'=>$request->main_parent_road ,
                'postcode'=>$request->main_parent_postcode ,
                'province'=>$request->main_parent_province ,
                'aumphure'=>$request->main_parent_aumphure ,
                'tambon'=>$request->main_parent_tambon ,
                'updated_at'=>date('Y-m-d H:i:s')
            ];

            // if change form living with borrower to not living with borrower
            if($main_parents_from_db->address_id == $borrower_from_db->address_id){

                Address::create($address_parent);
    
                $get_address = Address::where('updated_at',$address_parent['updated_at'])->where('postcode',$address_parent['postcode'])->where('house_no',$address_parent['house_no'])->where('village_no',$address_parent['village_no'])->get();
                $parent_address_id = $get_address['0']['id'];
                
            }else{
                Address::where('id',$main_parents_from_db->address_id)->update($address_parent);
                
                $parent_address_id = $main_parents_from_db->address_id;
            }
        }

        // dd($parent_address_id);

        //check nationality of parent 1
        if($request->parent1_is_thai == "ไทย"){
            $parent1_nationality = "ไทย";
        }else{
            $parent1_nationality = $request->parent1_nationality;
        }
        // dd($request->parent1_nationality);

        $parent1 = [
            'user_id'=>$user_id,
            'borrower_relational'=>$request->parent1_relational,
            'nationality'=>$parent1_nationality,
            'prefix'=>$request->parent1_prefix,
            'fname'=>$request->parent1_fname,
            'lname'=>$request->parent1_lname,
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
               "parent2_fname" => 'required|string|max:100',
               "parent2_lname" => 'required|string|max:100',
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
               'user_id'=>$user_id,
               'borrower_relational'=>$request->parent2_relational,
               'nationality'=>$parent2_nationality,
               'prefix'=>$request->parent2_prefix,
               'fname'=>$request->parent2_fname,
               'lname'=>$request->parent2_lname,
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
            $parent1['address_id'] = $parent_address_id;
            $parent2['address_id'] = null;
            $parent_citizen_id = $request->parent1_citizen_id;
            $parent_create_at = $parent1['updated_at'];
        }else if($request->main_parent == "parent2"){
            $parent2['address_id'] = $parent_address_id;
            $parent1['address_id'] = null;
            $parent_citizen_id = $request->parent2_citizen_id;
            $parent_create_at = $parent2['updated_at'];
        }

        

        // insert to database
        Parents::where('id',$parents_from_db[0]->id)->update($parent1);
        if($parent2_have_data){
            //if parent 2 not found data
            if(isset($parents_from_db[1])){
                Parents::where('id',$parents_from_db[1]->id)->update($parent2);
            }else{
                Parents::create($parent2);
            }
        }

        $get_main_parent = Parents::where('citizen_id',$parent_citizen_id)->where('updated_at',$parent_create_at)->get();
        $main_parent_id = $get_main_parent[0]['id'];

        

        $borrower = [
            'user_id'=>$user_id,
            'birthday'=>$request->birthday,
            'citizen_id'=>$request->citizen_id,
            'student_id'=>$request->student_id,
            'faculty'=>$request->faculty,
            'major'=>$request->major,
            'grade'=>$request->grade,
            'gpa'=>$request->gpa,
            'borrower_appearance'=>$request->borrower_appearance,
            'phone_number'=>$request->phone_number,
            'address_id'=>$borrower_from_db->address_id,
            'borrower_necessity'=>json_encode($request->necess),
            'borrower_properties'=>json_encode($request->props),
            'parents_id'=>$main_parent_id,
            'marital_status'=>json_encode($marital_status),
            'updated_at'=>date('Y-m-d H:i:s')
        ];

        Borrower::where('id',$borrower_from_db->id)->update($borrower);

        // dd($parent1,$parent2,$borrower);
        // $get_borrower = Borrower::where('user_id',$user_id)->get();
        // $get_user = Users::where('id',$user_id)->get();
        // dd($parent1,$parent2,$borrower);

        return redirect('/borrower/information');

    }
    
}