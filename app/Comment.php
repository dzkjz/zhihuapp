<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    //表名
    protected $table = 'comments';

    //必须初始赋值的
    protected $fillable = ['user_id', 'content', 'commentable_id', 'commentable_type'];


    public function commentable()
    {
        return $this->morphTo();
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
