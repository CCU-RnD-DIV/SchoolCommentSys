<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class CommentCheck extends Request
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
            /*'topic' => 'required|max:20',
            'cellphone' => 'required|regex:/^09\d{2}?\d{3}?\d{3}$/',
            'email' => 'required|email',
            'resp-text' => 'required',
            'resp-expect' => 'required'*/
        ];
    }

    public function  messages()
    {
        return [
            'topic.required' => '請填寫您的反應主旨事項',
            'cellphone.required' => '請填寫您的聯絡手機',
            'cellphone.regex' => '請填寫正確的手機格式',
            'email.required' => '請填寫您的電子郵件',
            'email.email' => '請填寫正確的電子郵件格式',
            'resp-text.required' => '請填寫您的欲反應事項',
            'resp-expect.required' => '請填寫您希望的合理解決方案',
        ];
    }
}
