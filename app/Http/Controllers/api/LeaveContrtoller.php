<?php

namespace App\Http\Controllers\api;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\User;
use App\Leave;


class LeaveContrtoller extends Controller
{






    public function getApprovedLeaveList(Request $request)
    {
        $teacher = User::where('remember_token', $request->token)->first();
        if ($teacher != null) {
            $division = SubjectClassDivision::where('teacher_id',$teacher['id'])->lists('division_id');
            $leaves = Leave::whereIn('division_id', $division)
                ->where('status', '1')->orderBy('from date', 'asc')->get();

            $message = 'success';
            $status = 200;
            $teacher = $leaves->toArray();
        } else {
            $status = 200;
            $message = 'You are not authorised user';
        }
        $response = [
            "message" => $message,
            "ApprovedList" => $teacher
        ];
        return response($response, $status);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
