<?php

namespace App\Http\Controllers\Web\Admin;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    public function login(){
        if(Auth::guard('admin')->user()){
            return redirect('admin/dashboard');
        }else{
            return view('admin.auth.login');
        }
    }

    public function record(Request $request){
        $check  =   $request->all();
        if (Auth::guard('admin')->attempt(['email'=>$check['email'],'password'=>$check['password']])) {
            return redirect('admin/dashboard');
        }else{
            return redirect()->back()->with('error', 'Your Credintal is invalid');
        }
    }

    public function updateProfile(Request $request){
        $auth = Auth::guard('admin')->user();
        $auth->name = $request->name;
        $auth->email = $request->email;
        $auth->password = ($request->password) ? Hash::make($request->password) : $auth->password;
        $auth->save();

        return redirect()->back()->with('infoupdated' , 'you have updated your info successfully');
    }
    public function logout(Request $request){
        Auth::guard('admin')->logout();
        return redirect('admin/login');
    }
}
