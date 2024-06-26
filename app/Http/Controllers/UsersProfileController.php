<?php

namespace App\Http\Controllers;

use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class UsersProfileController extends Controller
{
    public function index(){
        $user_id = Session::get('user_id','1');
        $user = Users::find($user_id);
        return view('users_profile',compact('user'));
    }

    public function edit_profile(Request $request,$user_id){
        $request->validate([
            'prefix' => 'required|string|max:30',
            'firstname' => 'required|string|max:50',
            'lastname' => 'required|string|max:50',
        ],[
            "prefix.required" => 'กรุณาเลือกคำนำหน้า',
            "firstname.required" => 'กรุณากรอกชื่อจริง',
            "firstname.string" => 'กรุณากรอกชื่อจริงเป็นข้อความ',
            "firstname.max" => 'กรุณากรอกชื่อจริงไม่เกิน :max ตัวอักษร',
            "lastname.required" => 'กรุณากรอกนามสกุล',
            "lastname.string" => 'กรุณากรอกนามสกุลเป็นข้อความ',
            "lastname.max" => 'กรุณากรอกนามสกุลไม่เกิน :max ตัวอักษร',
        ]);

        $user = Users::find($user_id);

        if($user->username != $request->username){
            $request->validate([
                'username' => 'required|string|unique:users,username|max:255',
            ],[
                "username.required" => 'กรุณากรอกชื่อผู้ใช้',
                "username.string" => 'กรุณากรอกชื่อผู้ใช้เป็นข้อความ',
                "username.unique" => 'ชื่อผู้ใช้นี้มีอยู่ในระบบแล้ว',
                "username.max" => 'กรุณากรอกชื่อผู้ใช้ไม่เกิน :max ตัวอักษร',
            ]);
        }

        if($user->email != $request->email){
            $request->validate([
                'email' => 'required|email|unique:users,email|max:255',
            ],[
                "email.required" => 'กรุณากรอกอีเมล',
                "email.email" => 'กรุณากรอกรูปแบบอีเมลที่ถูกต้อง',
                "email.unique" => 'อีเมลนี้มีอยู่ในระบบแล้ว',
                "email.max" => 'กรุณากรอกอีเมลไม่เกิน :max ตัวอักษร',
            ]);
        }

        $user->username = $request->input('username');
        $user->prefix = $request->input('prefix');
        $user->firstname = $request->input('firstname');
        $user->lastname = $request->input('lastname');
        $user->email = $request->input('email');
        $user->save();
        return redirect()->back()->with(['success'=>'แก้ไขบัญชีเรียบร้อยแล้ว']);
    }

    public function change_password(Request $request,$user_id)
    {
        // ตรวจสอบข้อมูลที่ส่งมา
        $request->validate([
            'current_password' => 'required|string',
            'new_password' => 'required|string|min:8|confirmed',
        ],[
            "current_password.required" => 'กรุณากรอกรหัสผ่านปัจจุบัน',
            "current_password.string" => 'กรุณากรอกรหัสผ่านปัจจุบันเป็นข้อความ',
            "new_password.required" => 'กรุณากรอกรหัสผ่านใหม่',
            "new_password.string" => 'กรุณากรอกรหัสผ่านใหม่เป็นข้อความ',
            "new_password.min" => 'กรุณากรอกรหัสผ่านใหม่อย่างน้อย :min ตัวอักษร',
            "new_password.confirmed" => 'รหัสผ่านไม่ตรงกัน',
        ]);

        $user = Users::find($user_id);

        // ตรวจสอบรหัสผ่านปัจจุบัน
        if (!Hash::check($request->current_password, $user->password)) {
            return back()->withErrors(['current_password' => 'รหัสผ่านปัจจุบันไม่ถูกต้อง']);
        }

        // อัพเดตรหัสผ่านใหม่
        $user->password = Hash::make($request->new_password);
        $user->save();

        return redirect()->back()->with(['success'=>'รหัสผ่านถูกเปลี่ยนเรียบร้อยแล้ว']);
    }
}
