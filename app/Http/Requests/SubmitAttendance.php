<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class SubmitAttendance extends Request
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
            'batch_id'=>'required',
            'class_id'=>'required',
            'division_id'=>'required',
            'date'=>'required|date',

        ];
    }
}
