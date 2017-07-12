<?php

namespace App\Http\Requests\WebRequests;

use App\Http\Requests\Request;

class EditStudentRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [

            'firstname' => 'required|min:2|max:20',
            'email' => 'email',
            'mobile' =>'required|digits:10',
            'address' =>'required',
            'avatar' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'roll_number'=>'required|integer',
            'DOB'=>'required',
            'birth_place'=>'required',
            'nationality'=>'required',
            'mother_tongue'=>'required'




        ];
    }
}
