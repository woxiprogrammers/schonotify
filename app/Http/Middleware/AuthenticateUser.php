<?php

namespace App\Http\Middleware;

use App\TeacherView;
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
	    if($request->has('token')){
	          $teacher = User::where('remember_token',$request->token)->first();
            if (!empty($teacher)){
                if($teacher->role_id == 2){
                    $teacherView = TeacherView::where('user_id',$teacher->id)->select('mobile_view')->first();
                    if($teacherView['mobile_view'] == 1){
                        $request->merge(compact('teacher'));
                        return $next($request);
                    }else{
                        $response = array();
                        $response['status'] = 401;
                        $response['message'] = "Don't Have mobile view permission";
                        return $response;
                    }
                }else{
                    $request->merge(compact('teacher'));
                    return $next($request);
                }
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
