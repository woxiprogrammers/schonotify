<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class Message extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        switch ($this->method()) {
            case 'PUT':
                return true;
                break;
            case 'GET':
                return true;
                break;
            case 'POST':
                return true;
                break;
            default:
                return false;
                break;
        }
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        switch ($this->method()) {
            case 'GET':
                return[
                    'token'=>'required',
                    'user_id' => 'required|integer'
                ];
            case 'PUT':
                return [

                ];
                break;
            case 'POST':
                return [
                    'to_id' => 'required|integer',
                ];
                break;
            default:
                break;
        }
    }
}
