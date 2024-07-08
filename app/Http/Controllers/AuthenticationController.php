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
        if($user->activated){
            if (Auth::attempt($credentials)) {
                $request->session()->regenerate();
                // $session = $request->session()->all();
                // dd($session);
     
                return redirect()->intended('/borrower/information/information_list');
            }
        }else{
            $this->send_mail();
            return redirect('/verify_email');
        }
 
        return back()->withErrors([
            'username' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }

    public function send_mail(){
        $email = Session::get('email');
        $code = rand(100000, 999999);
        $register_token = RegisterToken::where('email',$email)->first();
        $register_token = $register_token ?? new RegisterToken();
        $register_token['email'] = $email;
        $register_token['token'] = Hash::make($code.$email); //add email before hash;
        $register_token['expired'] = Carbon::now()->addMinute(5);
        $register_token->save();

        $details = [
            'title' => 'Mail from SSKRU Loan',
            'body' => 'This is a token from SSKRU Loan'
        ];

        Mail::to($email)->send(new SendVerificationMail($details, $code));
    }


}
