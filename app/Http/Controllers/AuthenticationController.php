<?php

namespace App\Http\Controllers;

use App\Models\RegisterToken;
use App\Models\Users;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Mail;
use App\Mail\SendVerificationMail;

class AuthenticationController extends Controller
{
    public function index(){
        return view('login');
    }

    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'username' => ['required'],
            'password' => ['required'],
        ]);

        $user = Users::where('username',$request->username)->first();
        if($user == null){
            return back()->withErrors('The provided credentials do not match our records.');
        }

        if($user['activated']){
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
     
                return redirect()->intended('/borrower/information/information_list');
            }
        }else{
            Session::put('user_id',$user['id']);
            Session::put('email',$user['email']);
            $this->send_mail();
            return redirect('/verify_email');
        }
 
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('username');
    }

    public function send_mail(){
        $user_id = Session::get('user_id');
        $user = Users::find($user_id);
        $code = rand(100000, 999999);
        $register_token = RegisterToken::where('email',$user['email'])->first();
        $register_token = $register_token ?? new RegisterToken();
        $register_token['email'] = $user['email'];
        $register_token['token'] = Hash::make($code.$user['email']); //add email before hash;
        $register_token['expired'] = Carbon::now()->addMinute(5);
        $register_token->save();

        Mail::to($user->email)->send(new SendVerificationMail($code));
        return "send email successfuly";
    }

    public function email_confirm(Request $request){
        $code = implode('', $request->code);
        $now = Carbon::now();
        $user_id = Session::get('user_id');
        $user = Users::find($user_id);
        $register_token = RegisterToken::where('email',$user['email'])->first();
        if(Hash::check($code.$user['email'], $register_token['token']) and $now->lt($register_token['expired'])){
            $student_registering = Users::where('email',$user['email'])->first();
            $student_registering['activated'] = true;
            $student_registering->save();
            $register_token->delete();

            return redirect('/register-success');
        }else{
            return back()->withErrors('รหัสยืนยันตัวตนไม่ถูกต้อง หรือรหัสอาจหมดอายุไปแล้ว');
        }
    }

    public function login_after_email_comfirmation($user){
        $custom_request = new Request();
        $custom_request->merge([
            'username' => $user['username'],
            'password' => $user['password'],
        ]);

        $this->authenticate($custom_request);
    }

    public function register_success_page(){
        $user_id = Session::get('user_id');
        $user = Users::find($user_id);
        if($user != null){
            if($user['activated']){
                $this->login_after_email_comfirmation($user);
            }else{
                Session::regenerate();
                Session::put('user_id',$user['id']);
                Session::put('email',$user['email']);
                $this->send_mail();
                return redirect('/verify_email');
            }
        }else{
            $this->index();
        }
    }

}
