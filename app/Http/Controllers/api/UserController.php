<?php

namespace App\Http\Controllers\api;

use App\User;
use Illuminate\Http\Request;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;

class UserController extends Controller
{

    public function __construct()
    {
        $this->middleware('db');
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    protected function login(Request $request)
    {
        $user = User::where('email', $request->email)->first();
        if ($user == NULL) {
            $status = 404;
            $response = [
                "message" => "Sorry!! Incorrect email or password",
                "user"=>"",
            ];
        } elseif ($user->is_active == 0) {
            $status = 401;
            $response = [
                "message" => "Please confirm your email id first",
                "user"=>"",
            ];
        } elseif (Auth::attempt([
            'email' => $request->email,
            'password' => $request->password
        ])) {
            // Authentication passed...
            $status = 200;
            $user = Auth::User();
            $response = [
                "message" => "Login Successful",
                "user" => $user
            ];
        } else {
            $status = 404;
            $response = [
                "message" => "Sorry!! Incorrect email or password",
                "user"=>"",
            ];
        }
        return response($response, $status);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
