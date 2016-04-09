<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CommentAssignCheck extends Request
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
            'reply-major' => 'required'
        ];
    }

    public function  messages()
    {
        return [
            'reply-major.required' => '請選擇分派單位'
        ];
    }
}
