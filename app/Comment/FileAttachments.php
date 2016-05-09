<?php

namespace App\Comment;

use Illuminate\Database\Eloquent\Model;

class FileAttachments extends Model
{
    public $table = 'fileAttachment';

    protected  $fillable = [
        'id',
        'comments_id',
        'attachment',
        'attachment_type'
    ];
}
