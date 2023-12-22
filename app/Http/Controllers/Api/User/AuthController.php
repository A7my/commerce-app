<?php

namespace App\Http\Controllers\Api\User;

use App\Models\User;
use App\Helpers\helper;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\Api\LoginRequest;
use App\Http\Requests\Api\RegisterRequest;

class AuthController extends Controller
{
    public $helper;

    public function __construct()
    {
        $this->helper = new helper();
    }

    public function register(RegisterRequest $request)
    {
        $user = new User();
        $user->name = $request->name;
        $user->email = $request->email;
        $user->phone = $request->phone;
        $user->password = Hash::make($request->password);
        $user->save();
        $token = $user->createToken('UserToken')->plainTextToken;

        return $this->helper->ResponseJson(1 , 'account created successfully' , ['data' => $user , 'token' => $token]);
    }

    public function login(LoginRequest $request)
    {
        $user = User::where('email' , $request->email)->first();
        if($user){
            if(Hash::check($request->password , $user->password)){
                $token = $user->createToken('UserToken')->plainTextToken;
                return $this->helper->ResponseJson(1 , 'login successfully' , ['data' => $user , 'token' => $token]);
            }else{
                return $this->helper->ResponseJson(0 , 'invalid password');
            }
        }else{
            return $this->helper->ResponseJson(0 , 'invalid Email');
        }
    }

    public function logout()
    {
        auth()->user()->tokens()->delete();
        return $this->helper->ResponseJson(1 , 'logged out successfully');
    }
}
