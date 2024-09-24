<?php

namespace App\Http\Controllers;

use App\Http\Requests\StudentRegisterRequest;
use App\Http\Requests\TeacherRegisterRequest;
use App\Models\Faculties;
use App\Models\Majors;
use App\Models\Users;
use Illuminate\Support\Facades\Hash;
use App\Models\TeacherAccounts;


class RegisterController extends Controller
{
    public function index()
    {
        $users = Users::where('isactive', true)->get();
        return view('register_student', compact('users'));
    }

    public function register_student(StudentRegisterRequest $request)
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
        $faculties = Faculties::where('isactive', true)->get();
        $majors = Majors::where('isactive', true)->get();
        $teacheraccounts = TeacherAccounts::where('isactive', true)->get();
        return view('register_teacher', compact('users','faculties','majors'));
    }

    public function register_teacher(TeacherRegisterRequest $request)
    {
        $teacher_registering = new Users();
        $teacher_registering->prefix = $request->prefix;
        $teacher_registering->firstname = $request->firstname;
        $teacher_registering->lastname = $request->lastname;
        $teacher_registering->email = $request->email;
        $teacher_registering->password = Hash::make($request->password);
        $teacher_registering->privilege = 'teacher';
        $teacher_registering->save();

        $teacher_account = new TeacherAccounts();
        $teacher_account->user_id = $teacher_registering->id;
        $teacher_account->faculty_id = $request->faculty;
        $teacher_account->major_id = $request->major;
        $teacher_account->save();

        return redirect('/register_success')->with(['success' => 'สร้างบัญชี ' . $teacher_registering->prefix . $teacher_registering->firstname . ' ' . $teacher_registering->lastname . ' เรียบร้อยแล้ว']);
    }

    public function getMajorsByFacultyId($faculty_id)
    {
        $majors = Majors::where('isactive', true)->where('faculty_id', $faculty_id)->get();
        return json_encode($majors);
    }
}
