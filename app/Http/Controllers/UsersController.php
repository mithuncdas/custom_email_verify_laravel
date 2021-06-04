<?php

namespace App\Http\Controllers;


use App\Mail\VerifyEmail;
use Illuminate\Http\Request;
use Auth;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Hash;

use App\VerifyUser;
use Illuminate\Support\Facades\Mail;

use Illuminate\Support\Str;
class UsersController extends Controller
{
    public function login(){
        return view('auth.login');
    }

    public function validation(Request $request){

        $request->validate([
            'email' => 'required',
            'password' => 'required',
        ]);

        if(Auth::attempt(['email' => $request->email, 'password' => $request->password])){
            if(Auth::user()->email_verified_at == null){
                Auth::logout();
                return \redirect(route('usr.login'))->with('message','please verify your email');
            }
            return \redirect(route('home'))->with('success','login success');

        }
        else{
            return  \redirect()->back();
        }
    }

    public function create(){
        return view('auth.register');
    }

    public function store(Request $request){
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        VerifyUser::create([
            'token' => Str::random(60),
            'user_id'=> $user->id,
        ]);
        Mail::to($user->email)->send(new VerifyEmail($user));
        return \redirect(route('user.login'))->with('register_success','plse verify email');
    }

    public function verifyEmail($token){
        $verifiedUser = VerifyUser::where('token',$token)->first();
        if(isset($verifiedUser)){
            $user = $verifiedUser->user;
            if(!$user->email_verified_at){
                $user->email_verified_at = Carbon::Now();
                $user->save();
                return \redirect()->back()->with('success','Your email has been verifed');
            }
            else{
                return \redirect()->back()->with('info','Your email has been already verified ');
            }
        }
        else{
            return \redirect(route('user.login'))->with('error','Something went wrong!!');
        }
    }
}
