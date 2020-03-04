<?php

namespace App\Policies;

use App\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class FollowPolicy
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

    public function follow(User $currentUser, User $user)
    {
        //用户不能关注自己，也不能关注已经关注的用户
        return $currentUser->id !== $user->id && !($currentUser->followings->contains('id', $user->id));
    }
}
