<?php

namespace App\Http\Controllers;

use App\Mail\ResetPasswordMail;
use App\Models\PasswordResetToken;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;


class ResetpasswordController extends Controller
{
    public function index(){
        return view('login_student');
    }

    public function check_email(Request $request){
        // dd($request);
        $request->validate([
            'email' => 'required|email|max:255|exists:users,email',
        ],[
            "email.required" => 'กรุณากรอกอีเมล',
            "email.email" => 'กรุณากรอกรูปแบบอีเมลที่ถูกต้อง',
            "email.max" => 'กรุณากรอกอีเมลไม่เกิน :max ตัวอักษร',
            "email.exists" => 'email ไม่ถูกต้องกรุณาตรวจสอบอีกครั้ง'
        ]);

        $user = Users::where('email',$request->email)->first();
        Session::put('user_id',$user['id']);
        $this->send_email();
        return redirect('/verify_reset_password')->with(['success'=>'ส่งรหัสยืนยัน'.'เรียบร้อยแล้ว']);
    }

    public function change_password(Request $request){
        $user_id = Session::get('user_id');
        // ตรวจสอบข้อมูลที่ส่งมา
        $request->validate([
            'new_password' => 'required|string|min:8|confirmed',
        ],[
            "new_password.required" => 'กรุณากรอกรหัสผ่าน',
            "new_password.string" => 'กรุณากรอกรหัสผ่านเป็นข้อความ',
            "new_password.min" => 'กรุณากรอกรหัสผ่านอย่างน้อย :min ตัวอักษร',
            "new_password.confirmed" => 'รหัสผ่านไม่ตรงกัน',
        ]);

        $user = Users::find($user_id);
        $user['password'] = Hash::make($request->new_password);
        $user->save();

        return view('reset_password_success')->with(['success'=>'รหัสผ่านถูกเปลี่ยนเรียบร้อยแล้ว']);
    }

    public function send_email(){
        $user_id = Session::get('user_id');
        $user = Users::find($user_id);
        $code = rand(100000, 999999);
        $password_reset_token = PasswordResetToken::where('email',$user['email'])->first();
        $password_reset_token = $password_reset_token ?? new PasswordResetToken();
        $password_reset_token['email'] = $user['email'];
        $password_reset_token['token'] = Hash::make($code.$user['email']); //add email before hash;
        $password_reset_token['expired'] = Carbon::now()->addMinute(5);
        $password_reset_token->save();

        Mail::to($user->email)->send(new ResetPasswordMail($code));
        return "send email successfuly";
    }

    public function email_confirm(Request $request){
        $request->validate(
            [
                'code' => 'required|array',
                'code.*' => 'required|string|max:1',
            ],[
                'code.required' => 'กรุณากรอกรหัสยืนยันตัวตน',
                'code.array' => 'รูปแบบข้อมูลไม่ถูกต้อง',
                'code.*.required' => 'กรุณากรอกรหัสยืนยันตัวตน',
                'code.*.string' => 'รูปแบบข้อมูลไม่ถูกต้อง',
                'code.*.max' => 'รหัสแต่ละช่องต้องมีความยาวไม่เกิน :max ตัวอักษร',
            ]
        );
        $code = implode('', $request->code);
        $now = Carbon::now();
        $user_id = Session::get('user_id');
        $user = Users::find($user_id);
        $password_reset_token = PasswordResetToken::where('email',$user['email'])->first();
        if(Hash::check($code.$user['email'], $password_reset_token['token']) and $now->lt($password_reset_token['expired'])){
            $student_registering = Users::where('email',$user['email'])->first();
            $student_registering['activated'] = true;
            $student_registering->save();
            return view('change_password');
        }else{
            return back()->withErrors('รหัสยืนยันตัวตนไม่ถูกต้อง หรือรหัสอาจหมดอายุไปแล้ว');
        }
    }
}
