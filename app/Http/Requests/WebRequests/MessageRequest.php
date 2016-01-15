<?php

namespace App\Http\Requests\WebRequests;

use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Session;
use Illuminate\Support\Facades\Redirect;

class MessageRequest extends Request
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

                if(in_array('view_message',$resultArr)) {
                    return true;
                } else {

                    Session::flash('message-error','Currently you do not have permission to access this functionality. Please contact administrator to grant you access !');
                    return Redirect::to('/');
                }

                break;

            case 'PUT':
                dd('put');
                break;

            case 'POST':

                if(in_array('create_message',$resultArr)) {
                    return true;
                } else {

                    Session::flash('message-error','Currently you do not have permission to access this functionality. Please contact administrator to grant you access !');
                    return Redirect::to('/');
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
            $info = $this->request->all();
            $user_id = $info['user_id'];
            $role_id = User::where('id',$user_id)->pluck('role_id');
            if($role_id == 3){
            return [
                'description' => 'required|min:2',
                'user_id' => 'required',
                'batch' => 'required',
                'class' => 'required',
                'division' => 'required'
            ];
            }else{
                return [
                    'description' => 'required|min:2',
                    'user_id' => 'required'
                ];
            }
        }else{
            return [];
        }
    }
}
