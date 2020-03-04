<?php

namespace App;

use App\Models\Question;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;

class User extends Authenticatable implements MustVerifyEmail
{
    use Notifiable;
    #region 支持软删除
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    #endregion
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name', 'email', 'password', 'avatar', 'activation_token', 'api_token', 'settings',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'settings' => 'array',
    ];


    /**添加用户模型和问题模型的模型关联
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function questions()
    {
        return $this->hasMany(Question::class);
    }


    /** 添加用户模型和回答模型的模型关联 一个用户可以有多个回答
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function answers()
    {
        return $this->hasMany(Answer::class);
    }


    public function followQuestions()
    {
        //默认表名 可以不设置后面三个参数，自定义表名需要设置
        return $this->belongsToMany(Question::class, 'users_questions', 'question_id', 'user_id')->withTimestamps();
    }


    /** 用户的粉丝
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followers()
    {

        return $this->belongsToMany
        (
            self::class,
            'followers',
            'user_id', //foreignPivotKey:当前模型在中间表的字段(当前模型类的外键) //【当前模型是leader】的外键id
            'follower_id'//relatedPivotKey:另一模型在中间表的字段(另一模型类的外键)
        )->withTimestamps();
    }


    /** 用户关注的作者
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function followings()
    {
        return $this->belongsToMany
        (
            self::class,
            'followers',
            'follower_id',//foreignPivotKey:当前模型在中间表的字段(当前模型类的外键) //【当前模型是粉丝】的外键id
            'user_id'//relatedPivotKey:另一模型在中间表的字段(另一模型类的外键)
        )
            ->withTimestamps();
    }


    /**
     * @return \Illuminate\Database\Eloquent\Relations\BelongsToMany
     */
    public function votes()
    {
        return $this->belongsToMany(Answer::class, 'votes')->withTimestamps();
    }


    /**
     * @param $answer_id
     * @return array
     */
    public function voteAnswer($answer_id)
    {
        return $this->votes()->toggle($answer_id);
    }


    public function messages()
    {
        return $this->hasMany(Message::class, 'to_user_id');
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function settings()
    {
        return new Setting($this);
    }
}
