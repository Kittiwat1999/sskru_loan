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
    public function index()
    {
        $users = Users::where('isactive', true)->get();
        return view('register_student', compact('users'));
    }

    public function register_student(UserMgeAccountRequest $request)
    {
        $student_registering = new Users();
        $student_registering->prefix = $request->prefix;
        $student_registering->firstname = $request->firstname;
        $student_registering->lastname = $request->lastname;
        $student_registering->email = $request->email;
        $student_registering->password = Hash::make($request->password);
        $student_registering->privilege = 'borrower';
        $student_registering->save();
        return redirect('/register_success')->with(['success' => 'สร้างบัญชี ' . $student_registering->prefix . $student_registering->firstname . ' ' . $student_registering->lastname . ' เรียบร้อยแล้ว']);
    }

    public function register_teacher_page()
    {
        $users = Users::where('isactive', true)->get();
        return view('register_teacher', compact('users'));
    }

    public function register_teacher(UserMgeAccountRequest $request)
    {
        $teacher_registering = new Users();
        $teacher_registering->prefix = $request->prefix;
        $teacher_registering->firstname = $request->firstname;
        $teacher_registering->lastname = $request->lastname;
        $teacher_registering->email = $request->email;
        $teacher_registering->password = Hash::make($request->password);
        $teacher_registering->privilege = 'teacher';
        $teacher_registering->save();
        return redirect('/register_success')->with(['success' => 'สร้างบัญชี ' . $teacher_registering->prefix . $teacher_registering->firstname . ' ' . $teacher_registering->lastname . ' เรียบร้อยแล้ว']);
    }
}
