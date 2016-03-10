<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;

class Leave extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $userToken = $this->request->all();
        $userId='';
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
        switch ($this->method()) {
            case 'GET':
                if(in_array('View_leave',$resultArr) ){
                    return true;
                }
                else{
                    return false;
                }
                break;
            case 'PUT':
                if(in_array('Publish_leave',$resultArr) ){
                    return true;
                }
                else{
                    return false;
                }
                break;
            case 'POST':
                if(in_array('Create_leave',$resultArr) ){
                    return true;
                }
                else{
                    return false;
                }
                break;
            default:
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
                return [];
                break;
            case 'POST':
                return [
                    'student_id' => 'required|integer',
                    'title' => 'required',
                    'leave_type_id' => 'required|integer',
                    'reason' => 'required',
                    'from_date' => 'required|date',
                    'end_date' => 'required|date',
                ];
                break;
            case 'PUT':
                return [];
            break;
            default:
                break;
        }
    }
}
