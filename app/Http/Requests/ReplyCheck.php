<?php

namespace App\Http\Requests;

use App\Http\Requests\Request;

class ReplyCheck extends Request
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
        return [
            'comment_id' => 'required',
            'status' => 'required',
            //'reply-text' => 'required_if:status,1'
            'resp-attachment1' => $mime,
            'resp-attachment2' => $mime,
            'resp-attachment3' => $mime,
            'resp-attachment4' => $mime,
            'resp-attachment5' => $mime,

        ];
    }

    public function  messages()
    {
        $messages = [
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
