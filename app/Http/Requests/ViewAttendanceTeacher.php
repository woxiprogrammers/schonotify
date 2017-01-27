<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Log;

class ViewAttendanceTeacher extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        $userToken = $this->request->all();
        $userId = '';
        foreach ($userToken as $userData) {
            $userId=$userData;
        }
        $val1 = User::join('module_acls', 'users.id', '=', 'module_acls.user_id')
            ->Join('acl_master', 'module_acls.acl_id', '=', 'acl_master.id')
            ->Join('modules', 'modules.id', '=', 'module_acls.module_id')
            ->where('users.id','=',$userId->id)
            ->select('users.id','acl_master.title as acl','modules.slug as module_slug')
            ->get();
        $resultArr = array();
        foreach($val1 as $val)
        {
            array_push($resultArr,$val->acl.'_'.$val->module_slug);

        }
        if(in_array('View_attendance',$resultArr) ){
            return true;
        }
        else{
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
                    'date'=>'required|date',
                    'division_id'=>'required'
                ];
    }
}
