<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class ResetpasswordController extends Controller
{
    public function index(){
        return view('login_student');
    }

    public function send_otp_email(Request $request){
        $request->validate([
            'email' => 'required|email|max:255',
        ],[
            "email.required" => 'กรุณากรอกอีเมล',
            "email.email" => 'กรุณากรอกรูปแบบอีเมลที่ถูกต้อง',
            "email.max" => 'กรุณากรอกอีเมลไม่เกิน :max ตัวอักษร',
        ]);

        return redirect()->to('/verify_resetpassword')->with(['success'=>'ส่งรหัสยืนยัน'.'เรียบร้อยแล้ว']);
    }

    public function verify_resetpassword(Request $request){
        $request->validate([
            'otp_1' => 'required|string|max:1',
            'otp_2' => 'required|string|max:1',
            'otp_3' => 'required|string|max:1',
            'otp_4' => 'required|string|max:1',
            'otp_5' => 'required|string|max:1',
            'otp_6' => 'required|string|max:1',
        ],[
            "otp_1.required" => 'กรุณากรอก OTP',
            "otp_1.string" => 'กรุณากรอก OTP เป็นข้อความ',
            "otp_1.max" => 'กรุณากรอก OTP :max ตัวอักษร',
            "otp_2.required" => 'กรุณากรอก OTP',
            "otp_2.string" => 'กรุณากรอก OTP เป็นข้อความ',
            "otp_2.max" => 'กรุณากรอก OTP :max ตัวอักษร',
            "otp_3.required" => 'กรุณากรอก OTP',
            "otp_3.string" => 'กรุณากรอก OTP เป็นข้อความ',
            "otp_3.max" => 'กรุณากรอก OTP :max ตัวอักษร',
            "otp_4.required" => 'กรุณากรอก OTP',
            "otp_4.string" => 'กรุณากรอก OTP เป็นข้อความ',
            "otp_4.max" => 'กรุณากรอก OTP :max ตัวอักษร',
            "otp_5.required" => 'กรุณากรอก OTP',
            "otp_5.string" => 'กรุณากรอก OTP เป็นข้อความ',
            "otp_5.max" => 'กรุณากรอก OTP :max ตัวอักษร',
            "otp_6.required" => 'กรุณากรอก OTP',
            "otp_6.string" => 'กรุณากรอก OTP เป็นข้อความ',
            "otp_6.max" => 'กรุณากรอก OTP :max ตัวอักษร',
        ]);

        return redirect()->to('/change_password');
    }

    public function change_password(Request $request){
        $user_id = Session::get('user_id','2');
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

        // อัพเดตรหัสผ่านใหม่
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->to('/success_page')->with(['success'=>'รหัสผ่านถูกเปลี่ยนเรียบร้อยแล้ว']);
    }
}
