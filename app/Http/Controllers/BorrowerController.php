<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Borrower;

class BorrowerController extends Controller
{
    function storeBorrowerInformation(Request $request){

        // dd($request);
        date_default_timezone_set("Asia/Bangkok");
        
        $data = [
            'prefix'=>$request->prefix,
            'birthday'=>$request->birthday,
            'citizen_id'=>$request->citizen_id,
            'student_id'=>$request->student_id,
            'faculty'=>$request->faculty,
            'major'=>$request->major,
            'grade'=>$request->grade,
            'gpa'=>$request->gpa,
            'borrower_appearance'=>$request->borrower_appearance,
            'email'=>$request->email,
            'phone_number'=>$request->phone_number,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        Borrower::insert($data);
        dd($data);
    }
}