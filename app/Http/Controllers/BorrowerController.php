<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrower;
use App\Models\Users;
use App\Models\Address;
use App\Models\Parents;
use Carbon\Carbon;
use App\Http\Requests\borrowerInformationValidationRequest;




class BorrowerController extends Controller
{

    public function getBorrowerInformation(){

        $user_id = 4;
        $get_borrower=Borrower::where('user_id',$user_id)->get();
        $get_user = Users::where('id',$user_id)->get();

        unset($get_user[0]['password']);
        if (count($get_borrower) === 0){
            $user_information = $get_user[0];
            return view('/borrower/information',compact('user_information'));

        }else{

            // dd($get_borrower[0]['address_id']);
            $get_borroweraddress = Address::where('id',$get_borrower[0]['address_id'])->get();
            
            $borrower_information = $get_borrower[0];
            $user_information = $get_user[0];
            $address = $get_borroweraddress[0];

            $borrower_information['borrower_necessity'] = json_decode($borrower_information['borrower_necessity']);
            $borrower_information['borrower_properties'] = json_decode($borrower_information['borrower_properties']);
            $borrower_information['marital_status'] = json_decode($borrower_information['marital_status']);
            
            $get_parent = Parents::where('user_id',$user_id)->orderby('id')->get();
            if(count($get_parent) == 2){
                $parent1 = $get_parent[0];
                $parent2 = $get_parent[1];
                
                if($parent1['address_id'] == null){
                    if($borrower_information['address_id'] == $parent2['address_id']){
                        $parent_address = $address;
                    }else{
                        $get_parent_address = Address::where('id',$parent2['address_id'])->get();
                        $parent_address = $get_parent_address[0];
                    }
                }else{
                    if($borrower_information['address_id'] == $parent1['address_id']){
                        $parent_address = $address;
                    }else{
                        $get_parent_address = Address::where('id',$parent1['address_id'])->get();
                        $parent_address = $get_parent_address[0];
                    }
                }
                
    
                // dd($borrower_information,$user_information,$address);
                return view('/borrower/information',compact('borrower_information','user_information','address','parent1','parent2','parent_address'));
            }else{
                $parent1 = $get_parent[0];
                if($borrower_information['address_id'] == $parent1['address_id']){
                    $parent_address = $address;
                }else{
                    $get_parent_address = Address::where('id',$parent1['address_id'])->get();
                    $parent_address = $get_parent_address[0];
                }
    
                // dd($borrower_information,$user_information,$address);
                return view('/borrower/information',compact('borrower_information','user_information','address','parent1','parent_address'));
            }
        }
    }

    // borrowerInformationValidationRequest
    function storeInformation(borrowerInformationValidationRequest $request){
        
        // dd($request);
        $user_id = 4;
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
            $marital_status = ['status'=>'แยกกันอยู่ตามอาชีพ','file_path'=>''];
        }else if($request->marital_status == "other"){
            $marital_status = ['status'=>$request->other_text,'file_path'=>''];
        }else if($request->marital_status == "แยกกันอยู่ตามอาชีพ"){
            $marital_status = ['status'=>'แยกกันอยู่ตามอาชีพ','file_path'=>''];
        }else if($request->marital_status == "หย่า"){
            $currentYear = Carbon::now()->year;
            $thaiBuddhistYear = $currentYear + 543;
            $uploadDirectory = 'public/uploads/'.$thaiBuddhistYear.'/'.$user_id;
            $displayDirectory = 'storage/uploads/'.$thaiBuddhistYear.'/'.$user_id;

            $file = $request->file('devorce_file');

            
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

        Address::insert($address);
        
        //get address id
        $get_address = Address::where('created_at',$address['created_at'])->where('postcode',$address['postcode'])->where('house_no',$address['house_no'])->where('village_no',$address['village_no'])->get();
        $borrower_address_id = $get_address['0']['id'];

        
        //check address parent are living with borrower
        if(isset($request->address_with_borrower)){
            $parent_address_id = $borrower_address_id;
        }else{
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
    
            Address::insert($address);
    
            $get_address = Address::where('created_at',$address['created_at'])->where('postcode',$address['postcode'])->where('house_no',$address['house_no'])->where('village_no',$address['village_no'])->get();
            $parent_address_id = $get_address['0']['id'];
        }

        //check nationality of parent 1
        if($request->parent1_is_thai == "ไทย"){
            $parent1_nationality = "ไทย";
        }else{
            $parent1_nationality = $request->parent1_nationnality;
        }

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
        if(!filter_var($request->parent2_no_data, FILTER_VALIDATE_BOOLEAN))
        {
             //check nationality of parent 2
            if($request->parent2_is_thai == "ไทย"){
                $parent2_nationality = "ไทย";
            }else{
                $parent2_nationality = $request->parent2_nationnality;
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
        }else{
            $parent2_have_data = false;
        }    

        // dd($parent2_have_data);
        

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
        Parents::insert($parent1);
        if($parent2_have_data)Parents::insert($parent2);

        $get_main_parent = Parents::where('citizen_id',$parent_citizen_id)->where('created_at',$parent_create_at)->get();
        $main_parent_id = $get_main_parent['0']['id'];

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

        Borrower::insert($borrower);
        $get_borrower = Borrower::where('user_id',$user_id)->get();
        // $get_user = Users::where('id',$user_id)->get();
        // dd($parent1,$parent2,$borrower);

        return redirect('/borrower/information');
    }

    
}