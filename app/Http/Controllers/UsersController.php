<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Users;

class UsersController extends Controller
{
    function getUsersData(){
        $users = Users::get();
        return view('/admin/manage_account',compact('users'));
    }

    function getUserById($id){
        $user = Users::where('id',$id)->get();
        return json_encode($user);
    }

    function deleteUser($id){

        Users::where('id',$id)->delete();
        return redirect('/admin/manage_account');
    }

    function createUser(Request $request){
        date_default_timezone_set("Asia/Bangkok");
        $request->validate(
            [
                'fname'=>'required|max:50',
                'lname'=>'required|max:50',
                'username'=>'required|max:50',
                'password'=>'required|max:50',
                'privilage'=>'required|max:50',
                'email'=>'required|max:100'
            ]
        );
        $data = [
            'fname'=>$request->fname,
            'lname'=>$request->lname,
            'username'=>$request->username,
            'password'=>$request->password,
            'privilage'=>$request->privilage,
            'email'=>$request->email,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        // dd($data);
        Users::insert($data);

        return redirect('/admin/manage_account');
    }

    function editAccount(Request $request){
        date_default_timezone_set("Asia/Bangkok");
        // dd($request);
        $request->validate(
            [
                'fname'=>'required|max:50',
                'lname'=>'required|max:50',
                'username'=>'required|max:50',
                'password'=>'required|max:50',
                'privilage'=>'required|max:50',
                'email'=>'required|max:100'
            ]
        );
        $data = [
            'fname'=>$request->fname,
            'lname'=>$request->lname,
            'username'=>$request->username,
            'password'=>$request->password,
            'email'=>$request->email,
            'privilage'=>$request->privilage,
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        // dd($data);

        Users::where('id',$request->id)->update($data);
        return redirect('/admin/manage_account');
    }
}
