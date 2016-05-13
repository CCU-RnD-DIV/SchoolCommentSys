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
        $mime = 'mimes:jpeg,bmp,png,gif,doc,docx,xls,xlsx,ppt,pptx,pdf,zip,rar,7z|max:7100';
        $rules = [
            'topic' => 'required|max:20',
            'email' => 'required|email',
            'cellphone' => 'required',
            'resp-text' => 'required',
            'resp-expect' => 'required',
            'resp-attachment1' => $mime,
            'resp-attachment2' => $mime,
            'resp-attachment3' => $mime,
            'resp-attachment4' => $mime,
            'resp-attachment5' => $mime,
            
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
            'resp-attachment1.mimes' => '您第1個檔案上傳了系統所不允許的檔案格式',
            'resp-attachment2.mimes' => '您第2個檔案上傳了系統所不允許的檔案格式',
            'resp-attachment3.mimes' => '您第3個檔案上傳了系統所不允許的檔案格式',
            'resp-attachment4.mimes' => '您第4個檔案上傳了系統所不允許的檔案格式',
            'resp-attachment5.mimes' => '您第5個檔案上傳了系統所不允許的檔案格式',
            'resp-attachment1.max' => '您第1個檔案超過7MB',
            'resp-attachment2.max' => '您第2個檔案超過7MB',
            'resp-attachment3.max' => '您第3個檔案超過7MB',
            'resp-attachment4.max' => '您第4個檔案超過7MB',
            'resp-attachment5.max' => '您第5個檔案超過7MB',
        ];

        return $messages;
    }
}
