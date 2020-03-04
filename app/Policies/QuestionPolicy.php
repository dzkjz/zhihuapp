<?php

namespace App\Policies;

use App\Models\Question;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class QuestionPolicy
{
    use HandlesAuthorization;

    /**
     * Create a new policy instance.
     *
     * @return void
     */
    public function __construct()
    {
        //

    }


    /**
     * 判断用户是否有权编辑更新问题
     * @param User $user
     * @param Question $question
     * @return bool
     */
    public function update(User $user, Question $question)
    {
        return $user->id === $question->user_id;
    }


    /**
     * 判断用户是否有权删除问题
     * @param User $user
     * @param Question $question
     * @return bool
     */
    public function destroy(User $user, Question $question)
    {
        return $user->id === $question->user_id;
    }


    /** 用户是否可以关注问题，未登录不行，关注了不行
     * @param User $user
     * @param Question $question
     * @return bool
     */
    public function follow(User $user, Question $question)
    {
        //axiox api 需要auth:api 先不实现，注释掉
        if (auth()->check()) {
            return !($user->followQuestions->contains('id', $question->id));
        } else {

        }
    }
}
