<?php

namespace TomatoPHP\TomatoEcommerce\Http\Controllers;

use App\Models\Account;
use Illuminate\Contracts\Support\Renderable;
use Illuminate\Http\Request;
use Illuminate\Routing\Controller;
use ProtoneMedia\Splade\Facades\Toast;
use TomatoPHP\TomatoCrm\Facades\TomatoAuth;

class ProfileController extends Controller
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

    public function index(){
        return view('tomato-ecommerce::profile.index');
    }

    public function edit(){
        return view('tomato-ecommerce::profile.edit');
    }

    public function update(Request $request){
        $request->validate([
            "name" => "sometimes|max:191|string",
            "phone" => "sometimes|max:14|string|unique:accounts,phone,". auth('accounts')->user()->id,
            "email" => "sometimes|email|max:191|string|unique:accounts,email,". auth('accounts')->user()->id,
        ]);

        auth('accounts')->user()->update([
           "name" => $request->name ?? auth('accounts')->user()->name,
           "phone" => $request->phone ?? auth('accounts')->user()->phone,
           "email" => $request->email ?? auth('accounts')->user()->email,
           "username" => $request->email ?? auth('accounts')->user()->email,
        ]);

        Toast::success(__('Profile Update Success'))->autoDismiss(2);
        return redirect()->back();
    }

    public function password(Request $request){
        $request->validate([
          "current_password" => "required|min:6|max:191",
          "password" => "required|min:6|max:191|confirmed"
        ]);

        if($request->get('current_password') == $request->get('password')){
            Toast::danger(__('New password cannot be the same as current password'))->autoDismiss(2);
            return redirect()->back();
        }

        $hasher = app('hash');
        if($hasher->check($request->get('current_password'), auth('accounts')->user()->password)){
            auth('accounts')->user()->update([
                "password" => bcrypt($request->get('password'))
            ]);

            Toast::success(__('Password Update Success'))->autoDismiss(2);
            return redirect()->back();
        }
        else {
            Toast::danger(__('Current password does not match'))->autoDismiss(2);
            return redirect()->back();
        }
    }

    public function close(Request $request){
        auth('accounts')->user()->carts()->delete();
        auth('accounts')->user()->wishlist()->delete();
        auth('accounts')->user()->reviews()->delete();
        auth('accounts')->user()->delete();
        $logout = TomatoAuth::logout(
            request: $request,
            type: 'web'
        );
        if($logout->success){
            Toast::success(__('Your Account Has Been Closed!'))->autoDismiss(2);
            return redirect()->route('login');
        }

    }

    public function logout(Request $request){
        $logout = TomatoAuth::logout(
            request: $request,
            type: 'web'
        );
        if($logout->success){
            Toast::success($logout->message)->autoDismiss(2);
            return redirect()->route('login');
        }
    }
}
