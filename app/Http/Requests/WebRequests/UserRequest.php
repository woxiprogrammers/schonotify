<?php

namespace App\Http\Requests\WebRequests;

use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Redirect;

class UserRequest extends Request
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

                if(in_array('create_user',$resultArr)) {
                    return true;
                } else {

                    Session::flash('message-error','you don`t have access');
                    return Redirect::to('/');
                }

                break;

            case 'PUT':
                dd('put');
                break;

            case 'POST':
                    return true;
                break;
            default:break;
        }


        /*$userId='';
        foreach($userToken as $userData)
        {
            $userId=$userData;
        }
        $val1=User::join('module_acls', 'users.id', '=', 'module_acls.user_id')
            ->Join('acl_master', 'module_acls.acl_id', '=', 'acl_master.id')
            ->Join('modules', 'modules.id', '=', 'module_acls.module_id')
            ->where('users.id','=',$userId->id)
            ->select('users.id','acl_master.title as acl','modules.slug as module_slug')
            ->get();
        $resultArr=array();
        foreach($val1 as $val)
        {
            array_push($resultArr,$val->acl.'_'.$val->module_slug);

        }
        if(in_array('Publish_leave',$resultArr)) {
            return true;
        } else {
            return false;
        }*/

        //return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ch=Request::method();
        switch($ch)
        {
            case 'GET': return [];
                break;
            case 'POST':return [
                'firstName'=>'required|min:2',
                'lastName' => 'required|min:2',
                'password' => 'required|min:6',
                'password2' => 'required|min:6',
                'mobile' => 'required|min:10',
                'alt_number' => 'required|min:10',
                'email' => 'required|email',
                'address' => 'required|min:15'
            ];
                break;
            default:break;
        }

    }
}
