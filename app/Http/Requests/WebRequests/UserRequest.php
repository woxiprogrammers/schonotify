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

                    Session::flash('message-error','Currently you do not have permission to access this functionality. Please contact administrator to grant you access !');
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

    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        $ch=Request::method();
        $userToken=$this->request->all();
        switch($ch)
        {
            case 'GET': return [];
                break;

            case 'POST':
                if($userToken){
                if($userToken['role_name'] == 'student'){
                    return [
                        'firstName'=>'required|min:2',
                        'lastName' => 'min:2',
                        'password' => 'required|min:6',
                        'password2' => 'required|min:6',
                        'mobile' => 'required|min:10',
                        'alt_number' => 'min:10',
                        'email' => 'email',
                        'address' => 'required|min:15'
                    ];
                    break;
                }else{
                    return [
                        'firstName'=>'required|min:2',
                        'lastName' => 'required|min:2',
                        'password' => 'required|min:6',
                        'password2' => 'required|min:6',
                        'mobile' => 'required|min:10',
                        'alt_number' => 'min:10',
                        'email' => 'required|email',
                        'address' => 'required|min:15'
                    ];
                    break;
                }
                }else{
                    return [
                        'firstName'=>'required|min:2',
                        'lastName' => 'required|min:2',
                        'password' => 'required|min:6',
                        'password2' => 'required|min:6',
                        'mobile' => 'required|min:10',
                        'alt_number' => 'min:10',
                        'email' => 'required|email',
                        'address' => 'required|min:15'
                    ];
                    break;
                }


            default:break;
        }

    }

    public function messages()
    {
        $ch=Request::method();
        switch($ch)
        {
            case 'GET': return [];
                break;
            case 'POST':return [
                'modules.required'=>'Please check at least one Module Acls.',
            ];
                break;
            default:break;
        }
    }
}
