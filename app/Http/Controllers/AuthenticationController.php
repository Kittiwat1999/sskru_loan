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
    public function loginPage(Request $request)
    {

        $user_id = $request->session()->get('user_id', null);
        if ($user_id  == null) {
            return view('login');
        } else {
            return $this->homePage($request);
        }
    }

    public function signout(Request $request)
    {
        $request->session()->flush();
        return redirect('/login');
    }

    public function login(AuthenticationRequest $request)
    {
        $credentials = $request->only('email', 'password');
        $user = Users::where('email', $request->email)->first();
        if($user['isactive'] == false){
            return back()->withErrors([
                'msg' => 'อีเมลล์หรือรหัสผ่านไม่ถูกต้อง',
            ])->onlyInput('email');
        }

        $currentTime = now();

        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();
            $request->session()->put('email', $user['email']);
            if ($user['activated']) {
                $request->session()->put('user_id', $user['id']);
                $request->session()->put('privilege', $user['privilege']);
                $request->session()->put('firstname', $user['firstname']);
                $request->session()->put('lastname', $user['lastname']);
                $request->session()->put('last_activity_time', $currentTime);
                return $this->homePage($request);
            } else {
                $this->send_email();
                return view('verify_email');
            }
        }
        return back()->withErrors([
            'msg' => 'อีเมลล์หรือรหัสผ่านไม่ถูกต้อง',
        ])->onlyInput('email');
    }

    public function send_email()
    {
        $user_email = Session::get('email');
        $user = Users::where('email', $user_email)->first();
        $code = rand(100000, 999999);
        $register_token = RegisterToken::where('email', $user['email'])->first();
        $register_token = $register_token ?? new RegisterToken();
        $register_token['email'] = $user['email'];
        $register_token['token'] = Hash::make($code . $user['email']); //add email before hash;
        $register_token['expired'] = Carbon::now()->addMinute(5);
        $register_token->save();

        Mail::to($user->email)->send(new SendVerificationMail($code));
        return "send email successfuly";
    }

    public function email_confirm(Request $request)
    {
        $request->validate(
            [
                'code' => 'required|array',
                'code.*' => 'required|string|max:1',
            ],
            [
                'code.required' => 'กรุณากรอกรหัสยืนยันตัวตน',
                'code.array' => 'รูปแบบข้อมูลไม่ถูกต้อง',
                'code.*.required' => 'กรุณากรอกรหัสยืนยันตัวตน',
                'code.*.string' => 'รูปแบบข้อมูลไม่ถูกต้อง',
                'code.*.max' => 'รหัสแต่ละช่องต้องมีความยาวไม่เกิน :max ตัวอักษร',
            ]
        );
        $code = implode('', $request->code);
        $now = Carbon::now();
        $user_email = Session::get('email');
        $user = Users::where('email', $user_email)->first();
        $register_token = RegisterToken::where('email', $user['email'])->first();
        $currentTime = now();

        if (Hash::check($code . $user['email'], $register_token['token']) and $now->lt($register_token['expired'])) {
            $student_registering = Users::where('email', $user['email'])->first();
            $student_registering['activated'] = true;
            $student_registering->save();
            $request->session()->put('user_id', $user['id']);
            $request->session()->put('privilege', $user['privilege']);
            $request->session()->put('firstname', $user['firstname']);
            $request->session()->put('lastname', $user['lastname']);
            $request->session()->put('last_activity_time', $currentTime);

            return redirect('/email_comfirm_success');
        } else {
            return redirect('/verify_email')->withErrors('รหัสยืนยันตัวตนไม่ถูกต้อง หรือรหัสอาจหมดอายุไปแล้ว');
        }
    }

    public function index(Request $request)
    {
        $user_id = $request->session()->get('user_id');
        $user = Users::find($user_id) ?? null;
        if ($user != null) {
            if ($user['activated']) {
                //auto login
                return $this->homePage($request);
            } else {
                //verify email page
                $request->session()->regenerate();
                $request->session()->put('email', $user['email']);
                $this->send_email();
                return view('verify_email');
            }
        } else {
            //go login
            return $this->loginPage($request);
        }
    }

    public function homePage($request)
    {
        $privilege = $request->session()->get('privilege');
        if ($privilege == 'admin') {
            return redirect('/admin/dashboard');
        } elseif ($privilege == 'teacher') {
            return redirect('/teacher/index');
        } elseif ($privilege == 'employee') {
            return redirect('/check_document/index');
        } elseif ($privilege == 'borrower') {
            return redirect('/borrower/borrower_document/index');
        } else {
            $request->session()->regenerate();
            return $this->loginPage($request);
        }
    }
}
