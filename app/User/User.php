<?php

namespace App\User;

use Illuminate\Database\Eloquent\Model;

class User extends Model
{
    public $table = 'users';

    protected  $fillable = [
        'account',
        'password',
        'dept',
        'auth',
        'name',
    ];

    public function CommentDetails()
    {
        return $this->hasMany('App\Comment\Comment', 'sid', 'id');
    }
}
