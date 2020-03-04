<?php

namespace App;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;

class Topic extends Model
{
    //
    protected $fillable = ['name', 'questions_count'];


    public function questions()
    {
        return $this->belongsToMany(
            Question::class,
            'questions_topics' //表名我设置的是questions_topics，可能不是系统自动解析的question_topic
        )->withTimestamps();//withTimestamps操作questions_topics表中create_at及updated_at字段的;
    }
}
