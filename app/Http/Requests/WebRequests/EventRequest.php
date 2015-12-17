<?php

namespace App\Http\Requests\WebRequests;

use App\Http\Requests\Request;

class EventRequest extends Request
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
            'eventName' => 'required',
            'eventDescription' => 'required|text',
            'eventStartDate' => 'required|date|after:tomorrow',
            'eventEndDate' => 'required|date|after:start_date',
            'image' => 'mimes:jpeg,jpg,png,gif|max:10000'
        ];
    }
}
