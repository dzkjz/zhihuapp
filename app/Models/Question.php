<?php

namespace App\Models;

use App\Answer;
use App\Comment;
use App\Topic;
use App\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Question extends Model
{
    //软删除 添加
    use SoftDeletes;
    //
    protected $fillable = ['title', 'content', 'user_id'];
    //支持软删除 添加
    protected $dates = ['deleted_at'];

    public function topics()
    {
        return $this->belongsToMany(
            Topic::class,
            'questions_topics' //表名我设置的是questions_topics，可能不是系统自动解析的question_topic
        )->withTimestamps();//withTimestamps操作questions_topics表中create_at及updated_at字段的
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** scope+请求名命名的
     * @return bool
     */
    public function scopePublished($query)
    {
        return $query->where('is_hidden', 'F');//等于F表示不隐藏
    }


    /** 一个问题有多个回答
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


    public function followUsers()
    {
        //默认表名 可以不设置后面三个参数，自定义表名需要设置
        return $this->belongsToMany(Question::class, 'users_questions', 'user_id', 'question_id')->withTimestamps();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }

}
