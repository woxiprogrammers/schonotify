<?php

namespace App\Http\Requests\WebRequests;

use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Session;
use Illuminate\Support\Facades\Redirect;

class EventRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {

        $ch=Request::method();

        $val1=User::join('module_acls', 'users.id', '=', 'module_acls.user_id')
            ->Join('acl_master', 'module_acls.acl_id', '=', 'acl_master.id')
            ->Join('modules', 'modules.id', '=', 'module_acls.module_id')
            ->where('users.id','=',Auth::User()->id)
            ->select('users.id','acl_master.slug as acl','modules.slug as module_slug')
            ->get();
        $resultArr=array();


        foreach($val1 as $val)
        {
            array_push($resultArr,$val->acl.'_'.$val->module_slug);
        }

        switch($ch)
        {
            case 'GET':

                if(in_array('view_event',$resultArr)) {
                    return true;
                } else {

                    Session::flash('message-error','Currently you do not have permission to access this functionality. Please contact administrator to grant you access !');
                    return Redirect::to('/');
                }

            break;

            case 'PUT':

                break;

            case 'POST':
                $request = Input::all();

                if($request['hiddenField'] == "Publish") {
                    if(in_array('create_event',$resultArr)) {
                        return true;
                    } else {

                        Session::flash('message-error','Currently you do not have permission to access this functionality. Please contact administrator to grant you access !');
                        return Redirect::to('/');
                    }
                } else {
                    if(in_array('create_event',$resultArr)) {
                        return true;
                    } else {

                        Session::flash('message-error','Currently you do not have permission to access this functionality. Please contact administrator to grant you access !');
                        return Redirect::to('/');
                    }
                }


                    break;
             default:break;
        }

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {

        if(Request::method()=="POST")
        {
            return [
                'eventName' => 'required',
                'eventDescription' => 'required|string',
                'eventStartDate' => 'required|date',
                'eventEndDate' => 'required|date',
                'image' => 'mimes:jpeg,jpg,png,gif|max:10000'
            ];
        }else{
            return [];
        }
    }
}
