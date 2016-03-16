<?php

namespace App\Http\Requests\WebRequests;

use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class NoticeBoardRequest extends Request
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
                if(in_array('view_announcement',$resultArr) && in_array('view_achivement',$resultArr)) {
                    return true;
                } elseif(in_array('view_announcement',$resultArr)) {
                    Session::flash('message-error','Currently you do not have permission to access view achivement functionality. Please contact administrator to grant you access !');
                    return true;
                } elseif(in_array('view_achivement',$resultArr)) {
                    Session::flash('message-error','Currently you do not have permission to access view announcement functionality. Please contact administrator to grant you access !');
                    return true;
                }
                else {
                    Session::flash('message-error','Currently you do not have permission to access this functionality. Please contact administrator to grant you access !');
                    return true;
                }
                break;

            case 'PUT':
                return true;
                break;

            case 'POST':
                return true;
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
        return [
            //
        ];
    }
}
