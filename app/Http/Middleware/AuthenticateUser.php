<?php

namespace App\Http\Middleware;

use App\User;
use Closure;

class AuthenticateUser
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if(isset($request->token)){
            $teacher = User::where('remember_token',$request->token)->first();
            if (!empty($teacher)){
            $request->merge(compact('teacher'));
            return $next($request);
            } else {
                $response = array();
                $response['status'] = 500;
                $response['message'] = "Token Mismatch";
                return $response;
            }
        }else{
            $response = array();
            $response['status'] = 401;
            $response['message'] = "Unauthorised User";
            return $response;
        }
    }
}
