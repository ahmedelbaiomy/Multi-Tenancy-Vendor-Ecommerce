<?php

namespace App\Http\Controllers\Dashboard;

use App\Http\Controllers\Controller;
use App\Http\Requests\AdminLoginRequest;
use Illuminate\Http\Request;

class LoginController extends Controller
{
    public function login(){
        return view('dashboard.auth.login');
    }
    public function doLogin(AdminLoginRequest $request){

        $remember_me = $request->input('remember_me') ? true : false;
        if(auth()->guard('admin')->attempt(['email'=>$request->input('email'),'password'=>$request->input('password')],$remember_me)){
//          notify()->success('تم الدحول بنجاح');
            return redirect()->route('admin.dashboard');
        }
//        notify()->error('تم الدحول بنجاح');
        return redirect()->back()->with(['error'=>'هناك خطأ بالبيانات']);

    }
    public function logout(){
        $user = auth('admin');
        $user->logout();

        return redirect()->route('admin.login');
    }
}
