<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\HTTP\Requests\AdminMgeAccountRequest;
use App\Models\Borrower;
use App\Models\Faculties;
use App\Models\FacultyAccounts;
use App\Models\Majors;
use App\Models\TeacherAccounts;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    function index(Request $request){
        $select_privilage = $request->session()->get('select_privilage','employee');
        $users = Users::where('isactive',true)->where('privilage',$select_privilage)->get(['id','email','firstname','lastname','privilage','created_at','updated_at']);
        $request->session()->put('select_privilage', $select_privilage);
        $faculties = Faculties::where('isactive',true)->get();
        return view('/admin/manage_account',compact('users','faculties'));
    }

    function admin_getUsersDataByPrivilage(Request $request, $select_privilage){
        $request->session()->put('select_privilage', $select_privilage);
        $users = Users::where('isactive',true)->where('privilage',$select_privilage)->get(['id','email','firstname','lastname','privilage','created_at','updated_at']);
        $faculties = Faculties::where('isactive',true)->get();
        return view('/admin/manage_account',compact('users','faculties'));
    }

    function admin_get_user_by_id($user_id){
        $user = Users::find($user_id);
        $majors = [];
        if($user->privilage == 'faculty'){
            $faculty_id = FacultyAccounts::where('user_id',$user->id)->value('faculty_id');
            $user->faculty_id = $faculty_id;
        }else if($user->privilage == 'teacher'){
            $teacher_account = TeacherAccounts::where('user_id',$user->id)->first();
            $majors = Majors::where('faculty_id',$teacher_account->faculty_id)->get();
            $user->faculty_id = $teacher_account->faculty_id;
            $user->major_id = $teacher_account->major_id;

        }else if($user->privilage == 'borrower'){
            $borrower_account = Borrower::where('user_id',$user->id)->first();
            $majors = Majors::where('faculty_id',$borrower_account->faculty_id)->get();
            $user->faculty_id = $borrower_account->faculty_id;
            $user->major_id = $borrower_account->major_id;
        }

        return response()->json([
            'user' => $user,
            'majors' => $majors,
        ]);
    }

    function admin_deleteUser($id){
        $user = Users::find($id);
        $user['email'] = '-';
        $user['isactive'] = false;
        $user->save();
        return redirect('/admin/manage_account');
    }

    function admin_createUser(AdminMgeAccountRequest $request){
        date_default_timezone_set("Asia/Bangkok");
        // dd($request);
        $data = [
            'prefix'=>$request->prefix,
            'firstname'=>$request->firstname,
            'lastname'=>$request->lastname,
            'password'=>Hash::make($request->password),
            'privilage'=>$request->privilage,
            'email'=>$request->email,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        // dd($data);
        $create_user = Users::create($data);

        if($request->privilage == 'faculty'){
            $request->validate(
                ['faculty'=>'required|string'],
                [
                    'faculty.required' => 'บัญชีคณะต้องระบุคณะที่สังกัด',
                    'faculty.string' => 'ประเภทข้อมูลไม่ถูกต้อง',
                ]
                );
            $faculty = $request->faculty;
        }
        if($request->privilage == 'teacher'){
            $request->validate(
                [   
                    'major'=>'required|string',
                    'faculty'=>'required|string'
                ],
                [
                    'major.required' => 'บัญชีสาขาต้องระบุสาขาที่สังกัด',
                    'major.string' => 'ประเภทข้อมูลไม่ถูกต้อง',
                    'faculty.required' => 'บัญชีคณะต้องระบุคณะที่สังกัด',
                    'faculty.string' => 'ประเภทข้อมูลไม่ถูกต้อง',
                ]
                );
            $major = $request->major;
            $faculty = $request->faculty;

        }

        if($create_user->privilage == 'faculty'){
            $faculty_account = new FacultyAccounts();
            $faculty_account->user_id = $create_user->id;
            $faculty_account->faculty_id = $faculty;
            $faculty_account->save();
        }else if($create_user->privilage == 'teacher'){
            $teacher_account = new TeacherAccounts();
            $teacher_account->user_id = $create_user->id;
            $teacher_account->faculty_id = $faculty;
            $teacher_account->major_id = $major;
            $teacher_account->save();
        }

        return redirect()->back()->with(['success'=>'เพิ่มข้อมูลผู้ใช้ user_id:'.$create_user->username.'แล้ว']);
    }

    function admin_editAccount(Request $request){
        date_default_timezone_set("Asia/Bangkok");
        $user = Users::where('id',$request->id)->first();
        $request->validate(
            [
                'prefix' => 'required|string|max:30',
                'firstname' => 'required|string|max:50',
                'lastname' => 'required|string|max:50',
                'privilage' => 'required|string|max:50',
            ],
            [
                'required' => 'กรุณากรอก :attribute',
                'string' => 'กรุณากรอก :attribute เป็นข้อความ',
                'max' => 'กรุณากรอก :attribute ไม่เกิน :max ตัวอักษร',
            ]
        );
        $data = [
            'prefix'=>$request->prefix,
            'firstname'=>$request->firstname,
            'lastname'=>$request->lastname,
            'privilage'=>$request->privilage,
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        if($request->email != $user->email){
            $request->validate(
                ['email' => 'required|string|unique:users,email|max:255'],
                [
                    'required' => 'กรุณากรอก :attribute',
                    'email' => 'กรุณากรอก :attribute ให้ถูกต้อง',
                    'max' => 'กรุณากรอก :attribute ไม่เกิน :max ตัวอักษร',
                    'unique' => ':attribute นี้มีอยู่ในระบบแล้ว',
                ]
            );

            $data['email'] = $request->email;
        }
        //check password are input
        if($request->password != null){
            $request->validate(
                ["password"=>'required|string|min:8'],
                [
                    'required' => 'กรุณากรอก :attribute',
                    'string' => 'กรุณากรอก :attribute เป็นข้อความ',
                    'min' => 'กรุณากรอก :attribute อย่างน้อย :min ตัว',
                ]
            );

            $data['password'] = Hash::make($request->password);
        }

        Users::where('id',$request->id)->update($data);

        if($request->privilage == 'faculty' || $request->privilage == 'teacher'){
            $request->validate(
                ['faculty'=>'required|string'],
                [
                    'faculty.required' => 'บัญชีคณะต้องระบุคณะที่สังกัด',
                    'faculty.string' => 'ประเภทข้อมูลไม่ถูกต้อง',
                ]
                );
            $faculty = $request->faculty;
        }
        if($request->privilage == 'teacher'){
            $request->validate(
                ['major'=>'required|string'],
                [
                    'major.required' => 'บัญชีสาขาต้องระบุสาขาที่สังกัด',
                    'major.string' => 'ประเภทข้อมูลไม่ถูกต้อง',
                ]
                );
            $major = $request->major;
        }

        if($user->privilage != $data['privilage']){
            if($user->privilage == 'faculty'){
                $faculty_account = FacultyAccounts::where('user_id',$user->id)->first();
                $faculty_account->delete();
            }else if($user->privilage == 'teacher'){
                $teacher_account = TeacherAccounts::where('user_id',$user->id)->first();
                $teacher_account->delete();
            }

            if($data['privilage'] == 'faculty'){
                $faculty_account = new FacultyAccounts();
                $faculty_account->user_id = $user->id;
                $faculty_account->faculty_id = $faculty;
                $faculty_account->save();
            }else if($data['privilage'] == 'teacher'){
                $teacher_account = new TeacherAccounts();
                $teacher_account->user_id = $user->id;
                $teacher_account->faculty_id = $faculty;
                $teacher_account->major_id = $major;
                $teacher_account->save();
            }
        }else{
            if($user->privilage == 'faculty'){
                $faculty_account = FacultyAccounts::where('user_id',$user->id)->first();
                $faculty_account->faculty_id = $faculty;
                $faculty_account->save();
            }else if($user->privilage == 'teacher'){
                $teacher_account = TeacherAccounts::where('user_id',$user->id)->first();
                dd($teacher_account);
                $teacher_account->faculty_id = $faculty;
                $teacher_account->major_id = $major;
                $teacher_account->save();
            }
        }
        return redirect()->back()->with(['success'=>'แก้ใขข้อมูลผู้ใช้เสร็จสิ้น']);
    }

    public function get_major_by_faculty_id($faculty_id){
        $majors = Majors::where('isactive',true)->where('faculty_id',$faculty_id)->get();
        return json_encode($majors);
    }
}
