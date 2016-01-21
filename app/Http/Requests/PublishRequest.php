<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;

class PublishRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $userToken=$this->request->all();
        $userId='';
        foreach($userToken as $userData)
        {
            $userId=$userData;
        }
        $val1=User::join('module_acls', 'users.id', '=', 'module_acls.user_id')
            ->Join('acl_master', 'module_acls.acl_id', '=', 'acl_master.id')
            ->Join('modules', 'modules.id', '=', 'module_acls.module_id')
            ->where('users.remember_token','=',$userId)
            ->select('users.id','acl_master.title as acl','modules.slug as module_slug')
            ->get();
        $resultArr=array();
        foreach($val1 as $val)
        {
            array_push($resultArr,$val->acl.'_'.$val->module_slug);

        }
        //if(in_array('Publish_homework',$resultArr) ){
            return true;
       /* }else{
            return false;
        }*/
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'homework_id' =>'required|integer',
        ];
    }
}
