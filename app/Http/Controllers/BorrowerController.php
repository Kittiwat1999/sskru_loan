<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrower;
use App\Models\Users;
use App\Models\Address;
use App\Models\Parents;
use Carbon\Carbon;




class BorrowerController extends Controller
{

    function storeInformation(Request $request){
        // dd($request);
        $user_id = 1;
        date_default_timezone_set("Asia/Bangkok");
        
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
            $uploadDirectory = 'uploads/'.$thaiBuddhistYear.'/'.$user_id;

            // Check if the directory exists
            if (!is_dir($uploadDirectory)) {
                mkdir($uploadDirectory, 0755, true); // The third parameter creates parent directories if they don't exist

                // Check if the directory was created successfully
                if (!is_dir($uploadDirectory)) {
                    die('Failed to create upload directory');
                }
            }
            $file = $request->file('devorce_file');

            $new_file_name = $file->getClientOriginalName();
            $new_file_name = time().$new_file_name;
            if($file->move($uploadDirectory,$new_file_name)){
                echo "file upload success";
                // return view('dommono');
            }else{
                echo "file upload failed!";
            }

            $marital_status = ['status'=>'หย่า','file_path'=>$uploadDirectory.'/'.$new_file_name];
        }

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
            'phone'=>$request->parent1_phone,
            'occupation'=>$request->parent1_occupation,
            'income'=>$request->parent1_income,
            'alive'=>filter_var($request->parent1_alive, FILTER_VALIDATE_BOOLEAN),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];

         //check nationality of parent 1
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
            'phone'=>$request->parent2_phone,
            'occupation'=>$request->parent2_occupation,
            'income'=>$request->parent2_income,
            'alive'=>filter_var($request->parent2_alive, FILTER_VALIDATE_BOOLEAN),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];

        // add address to main parent 
        if($request->main_parent == "parent1"){
            $parent1['address_id'] = $parent_address_id;
        }else if($request->main_parent == "parent2"){
            $parent2['address_id'] = $parent_address_id;
        }

        // insert to database
        Parents::insert($parent1);
        Parents::insert($parent2);

        $get_main_parent = Parents::where('address_id',$parent_address_id)->get();
        $main_parent_id = $get_main_parent['0']['id'];

        $borrower = [
            'user_id'=>$user_id,
            'prefix'=>$request->prefix,
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
            'mariatal_status'=>json_encode($marital_status),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];

        Borrower::insert($borrower);
        $get_borrower = Borrower::where('user_id',$user_id)->get();
        // $get_user = Users::where('id',$user_id)->get();
        dd($get_borrower);

        return redirect('/borrower/information');
    }
}