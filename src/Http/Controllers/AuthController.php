<?php

namespace TomatoPHP\TomatoEcommerce\Http\Controllers;

use App\Models\Account;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ProtoneMedia\Splade\Facades\Toast;
use TomatoPHP\TomatoCrm\Facades\TomatoAuth;

class AuthController extends Controller
{
    public function __construct()
    {
        TomatoAuth::loginBy('email');
        TomatoAuth::guard('accounts');
        TomatoAuth::requiredOtp(false);
        TomatoAuth::model(Account::class);
        TomatoAuth::createValidation([
            "name" => "required|max:191|string",
            "phone" => "required|max:14|string|unique:accounts,phone",
            "email" => "required|email|max:191|string|unique:accounts,email",
            "password" => "required|confirmed|min:6|max:191"
        ]);
    }

    public function login(){
        if(!auth('accounts')->user()){
            return view('tomato-ecommerce::auth.login');
        }

        return redirect()->route('profile.index');
    }

    public function check(Request $request){
        $login = TomatoAuth::login(
            request: $request,
            type:'web'
        );
        if($login->success){
            Toast::success($login->message)->autoDismiss(2);
            return redirect()->route('profile.index');
        }
        else {
            Toast::danger($login->message)->autoDismiss(2);
            return back();
        }
    }

    public function register(){
        return view('tomato-ecommerce::auth.register');
    }

    public function store(Request $request){
        $register = TomatoAuth::register(
            request: $request,
            type: 'web'
        );
        if($register->success){
            Toast::success($register->message)->autoDismiss(2);
            return redirect()->route('login');
        }
        else {
            Toast::danger($register->message)->autoDismiss(2);
            return redirect()->back();
        }
    }

    public function otp(){
        return view('tomato-ecommerce::auth.otp');
    }

    public function reset(){
        return view('tomato-ecommerce::auth.reset');
    }

    public function forget(){
        return view('tomato-ecommerce::auth.forget');
    }
}
