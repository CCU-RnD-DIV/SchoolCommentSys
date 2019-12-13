<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class RegCheck extends Request
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
            'account' => 'required',
            'password' => 'required|min:6',
            'name' => 'required',
            'crm_password' => 'required|min:6|same:password'
        ];
    }

    public function  messages()
    {
        return [
            'account.required' => '請填寫您的帳號',
            'password.required' => '請填寫您的密碼',
            'password.min' => '密碼最少6個字元',
            'name.required' => '必須填入姓名',
            'crm_password.required' => '必須確認密碼',
            'crm_password.min' => '密碼最少6個字元',
            'crm_password.same' => '密碼不一致',
        ];
    }
}
