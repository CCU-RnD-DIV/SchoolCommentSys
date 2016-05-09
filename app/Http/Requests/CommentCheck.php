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
        $rules = [
            'topic' => 'required|max:20',
            'email' => 'required|email',
            'cellphone' => 'required',
            'resp-text' => 'required',
            'resp-expect' => 'required',
        ];

        return $rules;
    }

    public function  messages()
    {
        $messages = [
            'topic.required' => '請填寫您的反應主旨事項',
            'cellphone.regex' => '請填寫正確的手機格式',
            'email.required' => '請填寫您的電子郵件',
            'email.email' => '請填寫正確的電子郵件格式',
            'cellphone.required' => '請填寫您的通訊號碼',
            'resp-text.required' => '請填寫您的欲反應事項',
            'resp-expect.required' => '請填寫您希望的合理解決方案',
        ];

        return $messages;
    }
}
