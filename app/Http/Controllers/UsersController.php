<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\HTTP\Requests\AdminMgeAccountRequest;
use App\Models\Borrower;
use App\Models\Faculties;
use Yajra\DataTables\Facades\DataTables;
use App\Models\Majors;
use App\Models\TeacherAccounts;
use Illuminate\Contracts\Session\Session;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    protected $privilage = [
        'admin' => 'แอดมิน',
        'employee' => 'พนักงานทุนฯ',
        'teacher' => 'อาจารย์ที่ปรึกษา',
        'borrower' => 'ผู้กู้',
    ];

    function index(Request $request){
        $select_privilage = $request->session()->get('select_privilage','employee');
        $faculties = Faculties::where('isactive',true)->get();
        return view('/admin/manage_account',compact('faculties'));
    }

    function admin_getUsersDataByPrivilage(Request $request, $select_privilage){
        $request->session()->put('select_privilage', $select_privilage);
        return redirect('/admin/manage_account');
    }

    function getUsers(Request $request){
        $select_privilage = $request->session()->get('select_privilage','employee');
        if ($request->ajax()) {
            $data = Users::where('isactive',true)->where('privilage',$select_privilage)->get(['id','email','firstname','lastname','privilage','created_at','updated_at']);
            return DataTables::of($data)
                ->addIndexColumn()
                ->addColumn('thai-privilage', function($row){
                    return $this->privilage[$row->privilage];
                })
                ->addColumn('fullname', function($row){
                    return $row->prefix . $row->firstname . $row->lastname;
                })
                ->addColumn('action', function($row){
                    $editBtn = '<button type="button" class="btn btn-sm btn-primary" onclick="showUserModal('.$row->id.')" ><i class="bi bi-search"></i></button>';
                    $deleteBtn = '<button id="button-delete-modal" type="button" class="btn btn-sm btn-secondary" onclick="showDeleteModal( \''.$row->id.'\',\''.$row->firstname.'\',\''.$row->lastname.'\' )"><i class="bi bi-trash"></i></button> ';
                    return $editBtn . ' <div class="mt-2"></div> ' . $deleteBtn;
                })
                ->rawColumns(['thai-privilage','fullname','action'])
                ->make(true);
        }
    }

    function admin_get_user_by_id($user_id){
        $user = Users::find($user_id);
        $majors = [];
        if($user->privilage == 'teacher'){
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
        $user = new Users();
        $user['prefix'] = $request->prefix;
        $user['firstname'] = $request->firstname;
        $user['lastname'] = $request->lastname;
        $user['email'] = $request->email;
        $user['password'] = Hash::make($request->password);
        $user['privilage'] = $request->privilage;
        $user['activated'] = true;
        $user->save();

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
            $teacher_account = new TeacherAccounts();
            $teacher_account->user_id = $user['id'];
            $teacher_account->faculty_id = $faculty;
            $teacher_account->major_id = $major;
            $teacher_account->save();

        }

        return redirect()->back()->with(['success'=>'เพิ่มข้อมูลผู้ใช้ '. $user['firstname'] . ' '. $user['lastname'] . ' แล้ว']);
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
        if($request->privilage == 'teacher'){
            $request->validate(
                ['major'=>'required|string'],
                [
                    'major.required' => 'บัญชีสาขาต้องระบุสาขาที่สังกัด',
                    'major.string' => 'ประเภทข้อมูลไม่ถูกต้อง',
                ]
                );
            $major = $request->major;
            $faculty = $request->faculty;
        }

        return redirect()->back()->with(['success'=>'แก้ใขข้อมูลผู้ใช้เสร็จสิ้น']);
    }

    public function get_major_by_faculty_id($faculty_id){
        $majors = Majors::where('isactive',true)->where('faculty_id',$faculty_id)->get();
        return json_encode($majors);
    }
}
