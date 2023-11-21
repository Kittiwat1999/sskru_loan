<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\facades\DB;

class UsersController extends Controller
{
    function getUsersData(){
        $users = DB::table('users')->get();
        return view('admin_manage_account',compact('users'));
    }

    function getUserById($id){
        $user = DB::table('users')->where('id',$id)->get();
        return json_encode($user);
    }

    function deleteUser($id){

        DB::table('users')->where('id',$id)->delete();
        return redirect('/admin_manage_account');
    }

    function createUser(Request $request){
        date_default_timezone_set("Asia/Bangkok");
        $request->validate(
            [
                'fname'=>'required|max:50',
                'lname'=>'required|max:50',
                'username'=>'required|max:50',
                'password'=>'required|max:50',
                'privilage'=>'required|max:50'
            ]
        );
        $data = [
            'fname'=>$request->fname,
            'lname'=>$request->lname,
            'username'=>$request->username,
            'password'=>$request->password,
            'privilage'=>$request->privilage,
            'created_at'=>date('Y-m-d H:i:s'),
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        // dd($data);
        DB::table('users')->insert($data);

        return redirect('/admin_manage_account');
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
                'privilage'=>'required|max:50'
            ]
        );
        $data = [
            'fname'=>$request->fname,
            'lname'=>$request->lname,
            'username'=>$request->username,
            'password'=>$request->password,
            'privilage'=>$request->privilage,
            'updated_at'=>date('Y-m-d H:i:s')
        ];
        // dd($data);

        DB::table('users')->where('id',$request->id)->update($data);
        return redirect('/admin_manage_account');
    }
}
