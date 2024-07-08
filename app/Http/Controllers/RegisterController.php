<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserMgeAccountRequest;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use App\Models\RegisterToken;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Session;

class RegisterController extends Controller
{
    public function index(){
        $users = Users::where('isactive',true)->get();
        return view('register_student',compact('users'));
    }

    public function register_student(UserMgeAccountRequest $request){

        Session::put('email',$request->email);
        $student_registering = new Users();
        $student_registering->prefix = $request->prefix;
        $student_registering->firstname = $request->firstname;
        $student_registering->lastname = $request->lastname;
        $student_registering->username = $request->username;
        $student_registering->email = $request->email;
        $student_registering->password = Hash::make($request->password);
        $student_registering->privilage = 'borrower';
        $student_registering->save();
        return redirect('/')->with(['success'=>'เพิ่มบัญชี '.$student_registering->prefix.$student_registering->firstname.' '.$student_registering->lastname.' เรียบร้อยแล้ว']);
    }

    public function send_eamil_again(){
        $this->send_mail();
        $timeout = 60;
        return view('verify_email',compact('timeout'))->with(['success'=>'ส่งรหัสยืนยันตัวตนเรียบร้อยแล้ว']);
    }

    

    public function email_confirm(Request $request){
        $code = implode('', $request->code);
        $now = Carbon::now();
        $email = Session::get('email');
        $register_token = RegisterToken::where('email',$email)->first();
        if(Hash::check($code.$email, $register_token->token) and $now->lt($register_token->expired)){
            $student_registering = Users::where('email',$email)->first();
            $student_registering['actvated'] = true;
            $student_registering->delete();
            $register_token->delete();

            return redirect('/register-success');
        }else{
            return back()->withErrors('รหัสยืนยันตัวตนไม่ถูกต้อง กรุณาตารวจสอบรหัสยืนยันตัวตน');
        }
    }
}
