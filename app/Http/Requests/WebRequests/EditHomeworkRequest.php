<?php

namespace App\Http\Requests\WebRequests;

use App\Http\Requests\Request;

class EditHomeworkRequest extends Request
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
            'subjectsDropdown' => 'required',
            'homeworkType' => 'required',
            'title' => 'required|min:3|max:20',
            'description' => 'required',
            'dueDate' =>'required|date',
            'batch' =>'required',
            'pdfFile' => 'mimes:pdf|max:25000000',
            'classDropdown' =>'required',
            'studentinfo' =>'required|min:1',
            'divisions' =>'required',
        ];
    }
}
