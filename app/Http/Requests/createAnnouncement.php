<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;

class CreateAnnouncement extends Request
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
        $users=User::join('module_acls', 'users.id', '=', 'module_acls.user_id')
            ->Join('acl_master', 'module_acls.acl_id', '=', 'acl_master.id')
            ->Join('modules', 'modules.id', '=', 'module_acls.module_id')
            ->where('users.id','=',$userId->id)
            ->select('users.id','acl_master.title as acl','modules.slug as module_slug')
            ->get();
        $resultArray=array();
        foreach($users as $value)
        {
            array_push($resultArray,$value->acl.'_'.$value->module_slug);
        }
        if(in_array('Create_event',$resultArray) ){
            return true;
        }else{
            return false;
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
            'title' => 'required|min:5|max:100',
            'detail' => 'required',
            'start_date' => 'required',
            'end_date' => 'required',
            'batch'=>'required',
            'class'=>'required',
            'division'=>'required',
            'User'=>'required|integer'
        ];
    }
}
