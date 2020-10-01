<?php

namespace App\Http\Middleware;

use App\User;
use Closure;
use Illuminate\Support\Str;

class VerifyApiToken {

    public function handle($request, Closure $next)
    {
        if (!$this->verify($request)) {

            $response['message'] = "Token tidak valid";
            return response($response);
        }

        return $next($request);
    }

    public function verify($request) {
        $header = $request->header('Authorization');
        if (Str::startsWith($header, 'Bearer ')) {
            $token = Str::substr($header, 7);
            return User::select('id')->where([    // add select so Eloquent does not query for all fields
                'remember_token'  => $token,  // remove variable that is used only once
            ])->exists();
        }else{
            return false;
        }
    }
}