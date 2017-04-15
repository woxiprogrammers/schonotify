<?php

namespace App\Http\Requests\WebRequests;

use App\Http\Requests\Request;

class EditParentRequest extends Request
{
    public function authorize()
    {
        return true;
    }
    public function rules()
    {
        return [
            'username' => 'required',
            'firstname' => 'required|min:2|max:20',
            'lastname' => 'required|min:2|max:20',
            'email' => 'required|chk_email',
            'mobile' =>'required|digits:10',
            'address' =>'required',
            'avatar' => 'mimes:jpeg,jpg,png,gif|max:10000',
            'father_first_name'=>'required',
            'father_occupation'=>'required|string',
            'father_income'=>'required|integer',
            'mother_first_name'=>'required|string',
            'mother_occupation'=>'required|string',
            'mother_income'=>'required|integer',
            'mother_contact'=>'required|digits:10'
        ];
    }
}
