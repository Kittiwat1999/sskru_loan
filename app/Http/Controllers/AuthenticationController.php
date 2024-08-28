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
use App\Http\Requests\AuthenticationRequest;

class AuthenticationController extends Controller
{
    public function index(){
        return view('login');
    }

    public function signout(){
        Session::regenerate();
        return redirect('/login');
    }

    public function login(AuthenticationRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $user = Users::where('email',$request->email)->first();
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('user_id',$user['id']);
            $request->session()->put('email',$user['email']);

            dd($user['privilege']);
            if($user['activated']){
                return redirect()->intended('/borrower/information/information_list');
            }else{
                $this->send_email();
                return view('verify_email');
            }
        }
        return back()->withErrors([
            'username' => 'อีเมลล์หรือรหัสผ่านไม่ถูกต้อง',
        ])->onlyInput('username');
    }

    public function send_email(){
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
        $request->validate(
            [
                'code' => 'required|array',
                'code.*' => 'required|string|max:1',
            ],[
                'code.required' => 'กรุณากรอกรหัสยืนยันตัวตน',
                'code.array' => 'รูปแบบข้อมูลไม่ถูกต้อง',
                'code.*.required' => 'กรุณากรอกรหัสยืนยันตัวตน',
                'code.*.string' => 'รูปแบบข้อมูลไม่ถูกต้อง',
                'code.*.max' => 'รหัสแต่ละช่องต้องมีความยาวไม่เกิน :max ตัวอักษร',
            ]
        );
        $code = implode('', $request->code);
        $now = Carbon::now();
        $user_id = Session::get('user_id');
        $user = Users::find($user_id);
        $register_token = RegisterToken::where('email',$user['email'])->first();
        if(Hash::check($code.$user['email'], $register_token['token']) and $now->lt($register_token['expired'])){
            $student_registering = Users::where('email',$user['email'])->first();
            $student_registering['activated'] = true;
            $student_registering->save();

            return redirect('/register-success');
        }else{
            return back()->withErrors('รหัสยืนยันตัวตนไม่ถูกต้อง หรือรหัสอาจหมดอายุไปแล้ว');
        }
    }

    public function go_to_home_page(){
        $user_id = Session::get('user_id');
        $user = Users::find($user_id);
        if($user != null){
            if($user['activated']){
                //auto login
                return redirect()->intended('/borrower/information/information_list');
            }else{
                //go verify email page
                Session::regenerate();
                Session::put('user_id',$user['id']);
                Session::put('email',$user['email']);
                $this->send_email();
                return view('verify_email');
            }
        }else{
            //go login
           return $this->index();
        }
    }

}
