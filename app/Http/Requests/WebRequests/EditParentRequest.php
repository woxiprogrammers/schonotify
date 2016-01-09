<?php

namespace App\Http\Requests\WebRequests;

use App\Http\Requests\Request;

class EditParentRequest extends Request
{
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
            'username' => 'required|max:20',
            'firstname' => 'required|min:3|max:20',
            'lastname' => 'required|min:3|max:20',
            'email' => 'required|email',
            'mobile' =>'required|digits:10',
            'address' =>'required',
            'avatar' => 'mimes:jpeg,jpg,png,gif|max:10000'
        ];
    }
}
