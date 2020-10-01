<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use Illuminate\Foundation\Auth\SendsPasswordResetEmails;
use Illuminate\Http\Request;
use App\User;
use App\Notifications\PasswordResetNotification;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\DB;
use Carbon\Carbon;

class ForgotPasswordController extends Controller
{
    /*
    |--------------------------------------------------------------------------
    | Password Reset Controller
    |--------------------------------------------------------------------------
    |
    | This controller is responsible for handling password reset emails and
    | includes a trait which assists in sending these notifications from
    | your application to your users. Feel free to explore this trait.
    |
    */

    // use SendsPasswordResetEmails;

    protected function sendResetLinkResponse(Request $request, $response)
    {
        return response(['message'=> 'Reset Password Berhasil, silahkan cek email anda']);
    }

    function kirimEmail(Request $request)
    {
        $validatedData = $request->validate([
            'email' => 'email|required'
            
        ]);

        $user = User::where('email', $request->email)->first();
        if ($user != null){
            $response['message'] = 'User ada';
            $response['data'] = $user;

            $token = Str::random(12);
            DB::table('password_resets')->updateOrInsert(
                [
                    'token' => $token,
                    'created_at' => Carbon::now('Asia/Jakarta')
                ],
                [
                    'email' => $user->email
                ]
            );

            $user->forgot_password_token = $token;
            $user->save();

            $user->notify(new PasswordResetNotification($token));
            
            $response['message'] = 'Reset Password Berhasil, silahkan cek email anda';
            return $response;
        }else{
            $response['message'] = 'User not found';
            return $response;
        }
    
    }
    
}
