<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrower;
use App\Models\Users;
use App\Models\Address;




class BorrowerController extends Controller
{
    function storeBorrowerInformation(Request $request){

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

        $get_address = Address::where('created_at',$address['created_at'])->where('postcode',$address['postcode'])->where('house_no',$address['house_no'])->where('village_no',$address['village_no'])->get();
        $address_id = $get_address['0']['id'];


        $data = [
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
            'address_id'=>$address_id,
            'borrower_necessity'=>json_encode($request->necess),
            'borrower_properties'=>json_encode($request->props),
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        Borrower::insert($data);
        $get_borrower = Borrower::where('id',$user_id)->get();
        $get_user = Users::where('id',$user_id)->get();
        return redirect('/borrower/information');
    }

    function getBorrowerInformation(){
        $user_id = 1;
        $get_borrower=Borrower::where('user_id',$user_id)->get();
        $get_user = Users::where('id',$user_id)->get();
        unset($get_user[0]['password']);
        if (count($get_borrower) === 0){
            $user_information = $get_user[0];
            // dd($user_information);
            return view('/borrower/information',compact('user_information'));
        }else{
            // dd($get_borrower[0]['address_id']);
            $get_address = Address::where('id',$get_borrower[0]['address_id'])->get();

            $borrower_information = $get_borrower[0];
            $user_information = $get_user[0];
            $address = $get_address[0];
            $borrower_information['borrower_necessity'] = json_decode($borrower_information['borrower_necessity']);
            $borrower_information['borrower_properties'] = json_decode($borrower_information['borrower_properties']);

            // dd($borrower_information,$user_information,$address);
            return view('/borrower/information',compact('borrower_information','user_information','address'));
        }

    }
}