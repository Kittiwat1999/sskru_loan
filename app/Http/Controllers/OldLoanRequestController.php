<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Storage;
use Illuminate\Http\Request;
use App\Models\Borrower;
use App\Models\Users;
use App\Models\UsefulActivities;
use App\Models\OldLoanRequest;
use Carbon\Carbon;
use App\Models\Files;
use Illuminate\Support\Facades\Redirect;

class OldLoanRequestController extends Controller
{
    public function index(){
        date_default_timezone_set("Asia/Bangkok");
        $user_id = 1;
        $borrower_id = 1;

        $loanRequestDocuments = OldLoanRequest::where('borrower_id', $borrower_id)->get();
        
        if($loanRequestDocuments !== null){
            return view('/borrower/loan_request/index',compact('loanRequestDocuments'));
        }else{
            return view('/borrower/loan_request/index');
        }
    }

    function create_doc(Request $request){
        $user_id = 1;
        $borrower_id = 1;

        
        $rules = [
            'term' => 'required|string|max:1',
            'year' => 'required|string|max:4',
        ];
        
        $messages = [
            'term.required' => 'โปรดกรอกภาคเรียน',
            'term.string' => 'ภาคเรียนต้องเป็นตัวอักษร',
            'term.max' => 'ภาคเรียนต้องไม่ยาวเกิน :max ตัวอักษร',
            'year.required' => 'โปรดกรอกปีการศึกษา',
            'year.string' => 'ปีการศึกษาต้องเป็นตัวอักษร',
            'year.max' => 'ปีการศึกษาต้องไม่ยาวเกิน :max ตัวอักษร'
        ];
        
        $validateData = $request->validate($rules,$messages);
        
        $chechishavedata = OldLoanRequest::where('borrower_id',$borrower_id)->where('year',$validateData['year'])->where('term',$validateData['term'])->first();
        if($chechishavedata != null){
            return redirect()->back()->withErrors(['error' => 'เอกสารนี้มีอยู่แล้ว']);
        }
        
        OldLoanRequest::create([
            'borrower_id'=>$borrower_id,
            'citizen_card_file'=>'0',
            'gpa_file'=>'0',
            'year'=>$validateData['year'],
            'term'=>$validateData['term'],
            'status'=>'nonsend',
            'comment'=>null,
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s')
        ]);
    
        return redirect('/borrower/loan_request');
    }

    function upload_page($doc_id){
        $user_id = 1;
        $borrower_id = 1;

        $loanRequestDocument = OldLoanRequest::where('id',$doc_id)->first();
        $activities = UsefulActivities::where('borrower_id',$borrower_id)->where('year',$loanRequestDocument->year)->get();
        $citizencardfile = Files::where('id',$loanRequestDocument->citizen_card_file)->where('description','citizen_card_file')->first();
        $gpafile = Files::where('id',$loanRequestDocument->gpa_file)->where('description','gpa_file')->first();

        if($loanRequestDocument != null){
            return view('/borrower/loan_request/loan_request_doc',compact('loanRequestDocument','activities','citizencardfile','gpafile'));
        }else{
            return redirect()->back()->withErrors(['error' => 'ไม่มีเอกสารนี้']);
        }
    }

    public function store_activits(Request $request){
        date_default_timezone_set("Asia/Bangkok");
        $user_id = 1;

        //validate
        $messages = [
            'project_name.required' => 'โปรดกรอกชื่อโครงการ',
            'project_name.string' => 'โปรดกรอกชื่อโครงการเป็นข้อความ',
            'project_name.max' => 'ชื่อโครงการต้องมีความยาวไม่เกิน :max ตัวอักษร',
            'project_location.required' => 'โปรดกรอกสถานที่',
            'project_location.string' => 'โปรดกรอกสถานที่เป็นข้อความ',
            'project_location.max' => 'สถานที่ต้องมีความยาวไม่เกิน :max ตัวอักษร',
            'date.required' => 'โปรดกรอกวันที่',
            'date.date' => 'โปรดกรอกวันที่ในรูปแบบที่ถูกต้อง',
            'time.required' => 'โปรดกรอกเวลา',
            'time.string' => 'โปรดกรอกเวลาเป็นข้อความ',
            'hour_count.required' => 'โปรดกรอกจำนวนชั่วโมง',
            'hour_count.string' => 'โปรดกรอกจำนวนชั่วโมงเป็นข้อความ',
            'description.required' => 'โปรดกรอกรายละเอียด',
            'description.string' => 'โปรดกรอกรายละเอียดเป็นข้อความ',
            'file.required' => 'โปรดเลือกไฟล์ที่ต้องการอัปโหลด',
            'file.file' => 'ไฟล์ที่เลือกต้องเป็นไฟล์',
            'file.mimes' => 'ไฟล์ต้องเป็นประเภท :values',
            'file.max' => 'ไฟล์ต้องมีขนาดไม่เกิน :max กิโลไบต์',
            'year.required' => 'โปรดกรอกปีการศึกษา',
            'year.string' => 'ปีการศึกษาต้องเป็นตัวอักษร',
            'year.max' => 'ปีการศึกษาต้องไม่ยาวเกิน :max ตัวอักษร'
        ];
    
        $rules = [
            'project_name' => 'required|string|max:255',
            'project_location' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string',
            'hour_count' => 'required|string',
            'description' => 'required|string',
            'file' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'year' => 'required|string|max:4',
        ];
        
        $request->validate($rules, $messages);
        //end validate

        $borrower_id = Borrower::where('user_id',$user_id)->value('id');
        // = borrowerid + - + this buddha year

        $currentYear = Carbon::now()->year;
        $thaiBuddhistYear = $currentYear + 543;
        
        $file = $request->file('file');

        $uploadDirectory = 'public/uploads/'.$thaiBuddhistYear.'/'.$user_id;
        $displayDirectory = 'storage/uploads/'.$thaiBuddhistYear.'/'.$user_id;

        $timestamp = now()->format('YmdHis');

        $fileNameWithTimestamp = $timestamp . '_' . $file->getClientOriginalName();
        $storedPath = $file->storeAs($uploadDirectory, $fileNameWithTimestamp);
        $displayPath = $displayDirectory.'/'.$fileNameWithTimestamp;

        //Storage::delete($filePath);

        // dd($storedPath,$displayPath );

        $useful_activities = [
            "borrower_id" => $borrower_id,
            "year" => $request->year,
            "project_name" => $request->project_name,
            "project_location" => $request->project_location,
            "date" => $request->date,
            "time" => $request->time,
            "hour_count" => $request->hour_count,
            "description" => $request->description,
            "store_path" => $storedPath,
            "display_path" => $displayPath,
            "created_at" => date('Y-m-d H:i:s'),
            "updated_at" => date('Y-m-d H:i:s')
        ];

        UsefulActivities::create($useful_activities);

        return Redirect::back()->with('refresh', 'true');
    }

    public function get_activity_by_id($id){
        $acttivity = UsefulActivities::where('id',$id)->first();

        return json_encode($acttivity);
    }

    public function edit_activity(Request $request){

        // dd($request);
        date_default_timezone_set("Asia/Bangkok");
        $user_id = 1;
        $useful_activity = UsefulActivities::find($request->activity_id);

        //validate
        $messages = [
            'project_name.required' => 'โปรดกรอกชื่อโครงการ',
            'project_name.string' => 'โปรดกรอกชื่อโครงการเป็นข้อความ',
            'project_name.max' => 'ชื่อโครงการต้องมีความยาวไม่เกิน :max ตัวอักษร',
            'project_location.required' => 'โปรดกรอกสถานที่',
            'project_location.string' => 'โปรดกรอกสถานที่เป็นข้อความ',
            'project_location.max' => 'สถานที่ต้องมีความยาวไม่เกิน :max ตัวอักษร',
            'date.required' => 'โปรดกรอกวันที่',
            'date.date' => 'โปรดกรอกวันที่ในรูปแบบที่ถูกต้อง',
            'time.required' => 'โปรดกรอกเวลา',
            'time.string' => 'โปรดกรอกเวลาเป็นข้อความ',
            'hour_count.required' => 'โปรดกรอกจำนวนชั่วโมง',
            'hour_count.string' => 'โปรดกรอกจำนวนชั่วโมงเป็นข้อความ',
            'description.required' => 'โปรดกรอกรายละเอียด',
            'description.string' => 'โปรดกรอกรายละเอียดเป็นข้อความ',
            'file.required' => 'โปรดเลือกไฟล์ที่ต้องการอัปโหลด',
            'file.file' => 'ไฟล์ที่เลือกต้องเป็นไฟล์',
            'file.mimes' => 'ไฟล์ต้องเป็นประเภท :values',
            'file.max' => 'ไฟล์ต้องมีขนาดไม่เกิน :max กิโลไบต์',
            'year.required' => 'โปรดกรอกปีการศึกษา',
            'year.string' => 'ปีการศึกษาต้องเป็นตัวอักษร',
            'year.max' => 'ปีการศึกษาต้องไม่ยาวเกิน :max ตัวอักษร'
        ];
    
        $rules = [
            'project_name' => 'required|string|max:255',
            'project_location' => 'required|string|max:255',
            'date' => 'required|date',
            'time' => 'required|string',
            'hour_count' => 'required|string',
            'description' => 'required|string',
            'file' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'year' => 'required|string|max:4',
        ];
    
        $request->validate($rules, $messages);
        //end validate

        $edit_data = [
            "project_name" => $request->project_name,
            "project_location" => $request->project_location,
            "date" => $request->date,
            "time" => $request->time,
            "hour_count" => $request->hour_count,
            "description" => $request->description,
            "updated_at" =>  date('Y-m-d H:i:s'),
        ];

        

        // check if have file
        if ($request->hasFile('file')) {

            //file validate
            $messages = [
                'file.required' => 'โปรดเลือกไฟล์ที่ต้องการอัปโหลด',
                'file.file' => 'ไฟล์ที่เลือกต้องเป็นไฟล์',
                'file.mimes' => 'ไฟล์ต้องเป็นประเภท :values',
                'file.max' => 'ไฟล์ต้องมีขนาดไม่เกิน :max กิโลไบต์',
            ];
        
            $rules = [
                'file' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            ];
        
            $request->validate($rules, $messages);
            //end file validate

            $currentYear = Carbon::now()->year;
            
            $file = $request->file('file');
            
            $uploadDirectory = 'public/uploads/'.$request->year.'/'.$user_id;
            $displayDirectory = 'storage/uploads/'.$request->year.'/'.$user_id;
            
            $timestamp = now()->format('YmdHis');
            
            $fileNameWithTimestamp = $timestamp . '_' . $file->getClientOriginalName();
            $storedPath = $file->storeAs($uploadDirectory, $fileNameWithTimestamp);
            $displayPath = $displayDirectory.'/'.$fileNameWithTimestamp;
            
            if (Storage::exists($useful_activity->store_path)) {
                Storage::delete($useful_activity->store_path);
            }

            $edit_data['store_path'] = $storedPath;
            $edit_data['display_path'] = $displayPath;

        }

        UsefulActivities::where('id',$request->activity_id)->update($edit_data);

        return Redirect::back()->with('refresh', 'true');
    }

    function delete_activity(Request $request){

        $useful_activity = UsefulActivities::find($request->activity_id);

        $useful_activity->delete();

        if (Storage::exists($useful_activity->store_path)) {
            Storage::delete($useful_activity->store_path);
        }
        

        return Redirect::back()->with('refresh', 'true');
    }

    function store_citizencardfile(Request $request){
        // dd($request);

        $borrower_id = 1;
        $user_id = 1;
        date_default_timezone_set("Asia/Bangkok");
        $currentYear = Carbon::now()->year;

        $loan_request = OldLoanRequest::where('year',$request->year)->where('borrower_id',$borrower_id)->first();


        //file validate
        $messages = [
            'citizen_card_file.required' => 'โปรดเลือกไฟล์ที่ต้องการอัปโหลด',
            'citizen_card_file.file' => 'ไฟล์ที่เลือกต้องเป็นไฟล์',
            'citizen_card_file.mimes' => 'ไฟล์ต้องเป็นประเภท :values',
            'citizen_card_file.max' => 'ไฟล์ต้องมีขนาดไม่เกิน :max กิโลไบต์',
            'term.required' => 'โปรดกรอกภาคเรียน',
            'term.string' => 'ภาคเรียนต้องเป็นตัวอักษร',
            'term.max' => 'ภาคเรียนต้องไม่ยาวเกิน :max ตัวอักษร',
            'year.required' => 'โปรดกรอกปีการศึกษา',
            'year.string' => 'ปีการศึกษาต้องเป็นตัวอักษร',
            'year.max' => 'ปีการศึกษาต้องไม่ยาวเกิน :max ตัวอักษร'
        ];
    
        $request->validate([
            'citizen_card_file' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'term' => 'required|string|max:1',
            'year' => 'required|string|max:4',
        ], $messages);
        //end file validate

        if($loan_request->citizen_card_file == '0'){

            $file = $request->file('citizen_card_file');

            $uploadDirectory = 'public/uploads/'.$request->year.'/'.$user_id;
            $displayDirectory = 'storage/uploads/'.$request->year.'/'.$user_id;

            $timestamp = now()->format('YmdHis');

            $fileNameWithTimestamp = 'citizen_card_file'.$timestamp . '_' . $file->getClientOriginalName();
            $storedPath = $file->storeAs($uploadDirectory, $fileNameWithTimestamp);
            $displayPath = $displayDirectory.'/'.$fileNameWithTimestamp;

            $data = [
                "id"=>$borrower_id.$loan_request->id.'_'.'oldloan'.'_'.'citizen',
                "borrower_id"=>$borrower_id,
                "store_path"=>$storedPath,
                "display_path"=>$displayPath,
                "term"=>'1',
                "year"=>$request->year,
                "original_filename"=>$file->getClientOriginalName(),
                "description"=>'citizen_card_file',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s')
            ];

            Files::create($data);
            OldLoanRequest::where('id',$loan_request->id)->update(['citizen_card_file'=>$data['id'],'updated_at'=>date('Y-m-d H:i:s')]);

        }else{

            $file_db = Files::where('id',$loan_request->citizen_card_file)->first();

            $file = $request->file('citizen_card_file');

            $uploadDirectory = 'public/uploads/'.$request->year.'/'.$user_id;
            $displayDirectory = 'storage/uploads/'.$request->year.'/'.$user_id;

            $timestamp = now()->format('YmdHis');

            $fileNameWithTimestamp = 'citizen_card_file'.$timestamp . '_' . $file->getClientOriginalName();
            $storedPath = $file->storeAs($uploadDirectory, $fileNameWithTimestamp);
            $displayPath = $displayDirectory.'/'.$fileNameWithTimestamp;

            $data = [
                "borrower_id"=>$borrower_id,
                "store_path"=>$storedPath,
                "display_path"=>$displayPath,
                "term"=>'1',
                "year"=>$request->year,
                "original_filename"=>$file->getClientOriginalName(),
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s')
            ];

            Files::where('id',$loan_request->citizen_card_file)->update($data);
            if (Storage::exists($file_db->store_path)) {
                Storage::delete($file_db->store_path);
            }
        }
        
        return Redirect::back()->with('refresh', 'true');
    }

    
    function store_gpafile(Request $request){
        $borrower_id = 1;
        $user_id = 1;
        date_default_timezone_set("Asia/Bangkok");
        $currentYear = Carbon::now()->year;

        $loan_request = OldLoanRequest::where('year',$request->year)->where('borrower_id',$borrower_id)->first();

        //file validate
        $messages = [
            'gpa_file.required' => 'โปรดเลือกไฟล์ที่ต้องการอัปโหลด',
            'gpa_file.file' => 'ไฟล์ที่เลือกต้องเป็นไฟล์',
            'gpa_file.mimes' => 'ไฟล์ต้องเป็นประเภท :values',
            'gpa_file.max' => 'ไฟล์ต้องมีขนาดไม่เกิน :max กิโลไบต์',
            'term.required' => 'โปรดกรอกภาคเรียน',
            'term.string' => 'ภาคเรียนต้องเป็นตัวอักษร',
            'term.max' => 'ภาคเรียนต้องไม่ยาวเกิน :max ตัวอักษร',
            'year.required' => 'โปรดกรอกปีการศึกษา',
            'year.string' => 'ปีการศึกษาต้องเป็นตัวอักษร',
            'year.max' => 'ปีการศึกษาต้องไม่ยาวเกิน :max ตัวอักษร'
        ];
    
        $request->validate([
            'gpa_file' => 'required|file|mimes:jpeg,png,pdf|max:2048',
            'term' => 'required|string|max:1',
            'year' => 'required|string|max:4',
        ], $messages);
        //end validate

        if($loan_request->gpa_file == '0'){

            $file = $request->file('gpa_file');

            $uploadDirectory = 'public/uploads/'.$request->year.'/'.$user_id;
            $displayDirectory = 'storage/uploads/'.$request->year.'/'.$user_id;

            $timestamp = now()->format('YmdHis');

            $fileNameWithTimestamp = 'gpa_file'.$timestamp . '_' . $file->getClientOriginalName();
            $storedPath = $file->storeAs($uploadDirectory, $fileNameWithTimestamp);
            $displayPath = $displayDirectory.'/'.$fileNameWithTimestamp;

            $data = [
                "id"=>$borrower_id.$loan_request->id.'_'.'oldloan'.'_'.'gpa',
                "borrower_id"=>$borrower_id,
                "store_path"=>$storedPath,
                "display_path"=>$displayPath,
                "term"=>$request->term,
                "year"=>$request->year,
                "original_filename"=>$file->getClientOriginalName(),
                "description"=>'gpa_file',
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s')
            ];

            Files::create($data);

            OldLoanRequest::where('id',$loan_request->id)->update(['gpa_file'=>$data['id'],'updated_at'=>date('Y-m-d H:i:s')]);

        }else{

            $file_db = Files::where('id',$loan_request->gpa_file)->first();
            $file = $request->file('gpa_file');

            $uploadDirectory = 'public/uploads/'.$request->year.'/'.$user_id;
            $displayDirectory = 'storage/uploads/'.$request->year.'/'.$user_id;

            $timestamp = now()->format('YmdHis');

            $fileNameWithTimestamp = 'gpa_file'.$timestamp . '_' . $file->getClientOriginalName();
            $storedPath = $file->storeAs($uploadDirectory, $fileNameWithTimestamp);
            $displayPath = $displayDirectory.'/'.$fileNameWithTimestamp;

            $data = [
                "borrower_id"=>$borrower_id,
                "store_path"=>$storedPath,
                "display_path"=>$displayPath,
                "term"=>$request->term,
                "year"=>$$request->year,
                "original_filename"=>$file->getClientOriginalName(),
                "created_at" => date('Y-m-d H:i:s'),
                "updated_at" => date('Y-m-d H:i:s')
            ];

            Files::where('id',$file_db->id)->update($data);

            if (Storage::exists($file_db->store_path)) {
                Storage::delete($file_db->store_path);
            }
        }
        return Redirect::back()->with('refresh', 'true');
    }

    function send_loanrequest_doc(Request $request){
        date_default_timezone_set("Asia/Bangkok");

        $user_id = 1;
        $borrower_id = 1;

        $loanRequestDocument = OldLoanRequest::where('id',$request->doc_id)->where('borrower_id',$borrower_id)->first();
        $activities = UsefulActivities::where('borrower_id',$borrower_id)->where('year',$loanRequestDocument->year)->get();
        $hour_sum =  UsefulActivities::where('borrower_id',$borrower_id)->where('year',$loanRequestDocument->year)->sum('hour_count');
        
        if($loanRequestDocument == null){
            return redirect()->back()->withErrors(['error' => 'ดูเหมือนว่าเอกสารนี้ยังไม่มีอยู่']);
        }

        if($loanRequestDocument->citizen_card_file == '0' || $loanRequestDocument->citizen_card_file == '0' ){
            return redirect()->back()->withErrors(['error' => 'ดูเหมือนว่าไฟล์ของคุณยังไม่ครบ']);
        }

        if($loanRequestDocument->citizen_card_file == '0' || $loanRequestDocument->citizen_card_file == '0' ){
            return redirect()->back()->withErrors(['error' => 'ดูเหมือนว่าไฟล์ของคุณยังไม่ครบ']);
        }

        if($activities == null || $hour_sum < 36){
            return redirect()->back()->withErrors(['error' => 'ดูเหมือนว่าชั่วโมงกิจกรรมของคุณยังไม่ครบ']);
        }

        $loanRequestDocument->status = 'send';
        $loanRequestDocument->updated_at = date('Y-m-d H:i:s');
        $loanRequestDocument->save();

        return Redirect::route('old.loanrequest')->with('success', 'ส่งเอกสารเรียบร้อยแล้ว!');

    }
}
