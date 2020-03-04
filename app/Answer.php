<?php

namespace App;

use App\Models\Question;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Answer extends Model
{
    #region 支持软删除添加
    use SoftDeletes;
    protected $dates = ['deleted_at'];

    #endregion

    protected $fillable = ['user_id', 'question_id', 'content'];

    /** 一个回答只有一个回答主人
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /** 一个回答只针对一个问题
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function question()
    {
        return $this->belongsTo(Question::class);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function userVotes()
    {
        return $this->belongsToMany(User::class, 'votes')->withTimestamps();
    }

    public function comments()
    {
        return $this->morphMany(Comment::class, 'commentable');
    }
}
