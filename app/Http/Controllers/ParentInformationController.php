<?php

namespace App\Http\Controllers;

use App\Http\Requests\ParentInformationRequest;
use App\Models\Borrower;
use App\Models\Config;
use App\Models\Parents;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Response;

class ParentInformationController extends Controller
{
    private function convert_date($inputDate){
        $parsedDate = Carbon::createFromFormat('d-m-Y', $inputDate);
        $isoDate = $parsedDate->format('Y-m-d');
        return $isoDate;

    }

    public function deleteFile($file_path,$file_name){
        $path = storage_path($file_path.'/'.$file_name);
        if (File::exists($path)) {
            File::delete($path);
        }
    }

    private function storeFile($file_path,$file){
        $path = storage_path($file_path);
        !file_exists($path) && mkdir($path, 0777, true);
        $name = now()->format('Y-m-d_H-i-s') . '_' . $file->getClientOriginalName();
        $file->move($path, $name);
        return $name;
    }

    public function displayFile($file_path,$file_name){
        $path = storage_path($file_path.'/'.$file_name);
        if (!File::exists($path)) {
            abort(404);
        }
        $file = File::get($path);
        $type = File::mimeType($path);
        $response = Response::make($file, 200);
        $response->header("Content-Type", $type);
        return $response;
    }

    public function borrower_input_parent_information(){
        return view('borrower.information.parent_input_information');
    }

    public function borrower_store_parent_information(ParentInformationRequest $request){
        // dd($request);
        $user_id = Session::get('user_id','1');
        $borrower = Borrower::where('user_id',$user_id)->first();
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
        $parent1['birthday'] = $this->convert_date($request->parent1_birthday);
        $parent1['citizen_id'] = Crypt::encryptString($request->parent1_citizen_id);
        $parent1['phone'] = $request->parent1_phone;
        $parent1['email'] = $request->parent1_email;
        $parent1['occupation'] = $request->parent1_occupation;
        $parent1['place_of_work'] = $request->parent1_place_of_work;
        $parent1['income'] = $request->parent1_income;
        $parent1['alive'] = filter_var($request->parent1_alive, FILTER_VALIDATE_BOOLEAN);
       //parent 2 have data

       if(filter_var($request->parent2_no_data, FILTER_VALIDATE_BOOLEAN)){
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
              "parent2_email" => 'required|string|max:100',
              "parent2_occupation" => 'required|string|max:100',
              "parent2_place_of_work" => 'required|string|max:100',
              "parent2_income" => 'required|string|max:50',
           ]);

            // Check if validation fails
            if ($parent2_validator->fails()) {
                return redirect()
                ->back()
                ->withErrors($parent2_validator);
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
                    return redirect()
                    ->back()
                    ->withErrors($parent2_validator);
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
            $parent2['birthday'] = $this->convert_date($request->parent2_birthday);
            $parent2['citizen_id'] = Crypt::encryptString($request->parent1_citizen_id);
            $parent2['phone'] = $request->parent2_phone;
            $parent2['email'] = $request->parent2_email;
            $parent2['occupation'] = $request->parent2_occupation;
            $parent2['place_of_work'] = $request->parent2_place_of_work;
            $parent2['income'] = $request->parent2_income;
            $parent2['alive'] = filter_var($request->parent2_alive, FILTER_VALIDATE_BOOLEAN);
            $parent2_have_data = true;
        }    
        
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
                return redirect()
                    ->back()
                    ->withErrors($file_validator);
            }
            $marital_status_path = Config::where('variable','marital_file_path')->value('value');
            $file = $request->file('devorce_file');
            $file_name = $file->getClientOriginalName();
            $spit_filename = explode('.', $file_name);
            $file_extenstion = last($spit_filename);
            if(($file_extenstion != 'png' && $file_extenstion != 'jpg') && ($file_extenstion != 'jpeg' && $file_extenstion != 'pdf')){
                $error =['devorce_file'=>'ประเภทไฟล์ต้องเป็น .jpg .png .pdf เท่านั้น'];
                return $error;
            }
            $file_path = $this->storeFile($marital_status_path.'/'.$borrower['student_id'],$file);
            $marital_status = ['status'=>'หย่า','file_path'=>$file_path];
        }

        $parent1->save();
        if($parent2_have_data)$parent2->save();
        $borrower['marital_status'] = $marital_status;
        $borrower->save();

        return redirect('/borrower/information/information_list')->with(['success'=> 'บันทึกข้อมูลผู้ปกครองเรียบร้อยแล้ว']);
    }
}
