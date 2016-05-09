<?php

namespace App\Comment;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    public $table = 'comments';

    protected  $fillable = [
        'sid',
        'topic',
        'resp_text',
        'resp_expect',
        'resp_time',
        'reply_text',
        'reply_time',
        'reply_major',
        'reply_OK',
        'cancel',
        'cancel_time',
        'cellphone',
        'email'
    ];

    public function UserDetails()
    {
        return $this->belongsTo('App\User\User', 'sid');
    }
}
