<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;
use App\HTTP\Requests\AdminMgeAccountRequest;
use Illuminate\Support\Facades\Hash;

class UsersController extends Controller
{
    function admin_getUsersData(){
        $privilage = "employee";
        $users = Users::where('isactive',true)->where('privilage',$privilage)->get(['id','username','email','fname','lname','privilage','created_at','updated_at']);
        return view('/admin/manage_account',compact('users','privilage'));
    }

    function admin_getUsersDataByPrivilage($privilage){
        $users = Users::where('isactive',true)->where('privilage',$privilage)->get(['id','username','email','fname','lname','privilage','created_at','updated_at']);
        return view('/admin/manage_account',compact('users','privilage'));
    }

    function admin_getUserById($id){
        // dd($id);
        $user = Users::where('id',$id)->get();
        // dd($user);
        return json_encode($user);
    }

    function admin_deleteUser($id){

        Users::where('id',$id)->update(['isactive'=>false]);
        return redirect('/admin/manage_account');
    }

    function admin_createUser(AdminMgeAccountRequest $request){
        date_default_timezone_set("Asia/Bangkok");

        $data = [
            'prefix'=>$request->prefix,
            'fname'=>$request->fname,
            'lname'=>$request->lname,
            'username'=>$request->username,
            'password'=>Hash::make($request->password),
            'privilage'=>$request->privilage,
            'email'=>$request->email,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        // dd($data);
        Users::create($data);

        return redirect('/admin/manage_account');
    }

    function admin_editAccount(Request $request){
        date_default_timezone_set("Asia/Bangkok");

        $user = Users::where('id',$request->id)->first();


        // dd($request);
        $request->validate(
            [
                'prefix' => 'required|string|max:30',
                'fname' => 'required|string|max:50',
                'lname' => 'required|string|max:50',
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
            'fname'=>$request->fname,
            'lname'=>$request->lname,
            'privilage'=>$request->privilage,
            'updated_at'=>date('Y-m-d H:i:s')
        ];

        if($request->username != $user->username){
            $request->validate(
                ['username' => 'required|string|unique:users,username|max:255'],
                [
                    'required' => 'กรุณากรอก :attribute',
                    'string' => 'กรุณากรอก :attribute เป็นข้อความ',
                    'max' => 'กรุณากรอก :attribute ไม่เกิน :max ตัวอักษร',
                    'unique' => ':attribute นี้มีอยู่ในระบบแล้ว',
                ]
            );

            $data['username'] = $request->username;
        }

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
        // dd($data);

        Users::where('id',$request->id)->update($data);
        return redirect('/admin/manage_account');
    }
}
