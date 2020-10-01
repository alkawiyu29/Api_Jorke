<?php

namespace App\Http\Controllers\Api;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\User;
use Illuminate\Support\Str;
use Auth;

class AuthController extends Controller
{
    public function register(Request $request){

        $validatedData = $request->validate([
            'name' => 'required',
            'email' => 'email|required|unique:users',
            'password' => 'required|min:6|confirmed',
            
        ]);

        $validatedData['password'] = bcrypt($request->password);
        $validatedData['remember_token'] = Str::random(60);

        $user = User::create($validatedData);

        $response['message'] = 'Register Berhasil';
        $response['data'] = [
            'email'=>$user->email,
            'name' =>$user->name, 
            'api token'=>$user->remember_token
        ];

        return response($response, 201);
    }

    public function login(Request $request){
       
        $loginData = $request->validate([
            'email' => 'email|required',
            'password' => 'required'
        ]);

        if(!auth()->attempt($loginData)){
            return response(['message' => 'Email & Password doesn\'t match']);
        }
        
        $user = Auth::user();
        $user->remember_token = Str::random(60);
        $user->save();

        $response = [
            'message' => 'Berhasil',
            'api_token'=>$user->remember_token
        ];

        return response($response, 200);
    }
}
