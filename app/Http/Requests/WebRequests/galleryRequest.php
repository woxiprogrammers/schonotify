<?php

namespace App\Http\Requests\WebRequests;

use App\Http\Requests\Request;

class galleryRequest extends Request
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            /*'video'=>'size:1000',
            'gallery_images'=>'size:1000'*/
        ];
    }
}
