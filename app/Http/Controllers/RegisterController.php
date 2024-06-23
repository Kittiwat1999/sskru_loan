<?php

namespace App\Http\Controllers;

use App\Http\Requests\UserMgeAccountRequest;
use App\Models\Users;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;

class RegisterController extends Controller
{
    public function index(){
        $users = Users::where('isactive',true)->get();
        return view('register_student',compact('users'));
    }

    public function register_student(UserMgeAccountRequest $request){
        $student = new Users();
        $student->prefix = $request->prefix;
        $student->firstname = $request->firstname;
        $student->lastname = $request->lastname;
        $student->username = $request->username;
        $student->email = $request->email;
        $student->password = Hash::make($request->password);
        $student->privilage = 'borrower';
        $student->save();
        return redirect()->back()->with(['success'=>'เพิ่มบัญชี '.$student->prefix.$student->firstname.' '.$student->lastname.' เรียบร้อยแล้ว']);
    }
}
