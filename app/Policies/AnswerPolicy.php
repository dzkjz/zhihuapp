<?php

namespace App\Policies;

use App\Answer;
use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class AnswerPolicy
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
     * 只能被回答的答主编辑
     * @param User $user
     * @param Answer $answer
     * @return bool
     */
    public function edit(User $user, Answer $answer)
    {
        return $user->id === $answer->user_id;
    }

    /**只能被回答的答主删除
     * @param User $user
     * @param Answer $answer
     * @return bool
     */
    public function destroy(User $user, Answer $answer)
    {
        return $user->id === $answer->user_id;
    }

}

