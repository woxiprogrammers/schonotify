<?php

namespace App\Http\Requests\WebRequests;

use App\Http\Requests\Request;
use App\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Session;

class CreateHomeworkRequest extends Request
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

                if(in_array('create_homework',$resultArr)) {
                    return true;
                } else {

                    Session::flash('message-error','You currently do not have permission to access this functionality. Please contact administrator to grant you access');
                    return Redirect::back();
                }

                break;

            case 'PUT':
               
                break;

            case 'POST':
                if(in_array('create_homework',$resultArr)) {
                    return true;
                } else {

                    Session::flash('message-error','You currently do not have permission to access this functionality. Please contact administrator to grant you access');
                    return Redirect::back();
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
        $ch=Request::method();
        switch($ch)
        {
            case 'GET': return [];
                break;
            case 'POST':return [
                'subjectsDropdown' => 'required',
                'homeworkType' => 'required',
                'title' => 'required|min:2|max:20',
                'description' => 'required',
                'dueDate' =>'required|date',
                'batch' =>'required',
                'pdfFile' => 'mimes:pdf|max:25000000',
                'classDropdown' =>'required',
                'studentinfo' =>'required|min:1',
                'divisions' =>'required',
            ];
                break;
            default:break;
        }

    }
}
