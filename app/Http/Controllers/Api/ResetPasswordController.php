<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\ResetsPasswords;
use Illuminate\Http\Request;
use App\User;
use Illuminate\Support\Str;

class ResetPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset requests
    | and uses a simple trait to include this behavior. You're free to
    | explore this trait and override any methods you wish to tweak.
    |
    */

    // use ResetsPasswords;
    
    function resetPassword(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'email|required',
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required',
            'token' => 'required'
            
        ]);

        $user = User::where('email', $request->email)->where('forgot_password_token', $request->token)->first();
        if ($user != null){
            
            // $response['message'] = 'token valid';
            // $response['data'] = null;
            // return $response;
            $tokenBaru = Str::random(60);
            $password = bcrypt($request->password);

            $user->password = $password;
            $user->remember_token = $tokenBaru;
            $user->save();
            
            $response['message'] = 'Password Berhasil diubah';
        
            $data['name'] = $user->name;
            $data['api_token'] = $user->remember_token; 
            
            $response['data'] = $data;

            return $response;
        }else{
            $response['message'] = 'Password Gagal diUbah';
            return $response;
        }
    
    }
    
}
