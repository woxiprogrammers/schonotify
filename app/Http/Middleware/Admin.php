<?php

namespace App\Http\Middleware;

use Auth;
use App\User;
use Illuminate\Contracts\Auth\Guard;
use Closure;
use Illuminate\Support\Facades\Redirect;
use Session;
class Admin
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */

    protected $auth;

    public function __construct(Guard $auth)
    {
        $this->auth=$auth;
    }

    public function handle($request, Closure $next)
    {
        if($this->auth->user()->role_id != 1 || $this->auth->user()->role_id !=2)
        {
            Session::flash('message-error','you dont have this privilege');

            return Redirect::to('admin');
        }

        return $next($request);
    }
}
