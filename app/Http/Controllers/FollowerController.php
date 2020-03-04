<?php

namespace App\Http\Controllers;

use App\Notifications\NewUserFollowNotification;
use App\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;

class FollowerController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth')
            ->except(
                [
                    'getFollowStats',
                    'followThroughApi',
                ]
            );
    }


    public function getFollowStats(Request $request)
    {
        //解析出用户
        $user = User::find($request->get('user'));
        //解析出当前登录用户
        $currentUser = auth()->user();
        //返回能否关注的状态 [follow是FollowPolicy中的follow方法，FollowPolicy已经在AuthServiceProvider中注册]
        return response()->json(
            [
                'followable' => $currentUser->can('follow', $user),
                'self' => $user->id === $currentUser->id,
            ]
        );
    }


    public function followThroughApi(Request $request)
    {
        //解析出用户
        $user = User::find($request->get('user'));

        //解析出当前登录用户
        $currentUser = User::find(auth()->user()->id);

        //执行关注/取关操作 [不能关注自己]
        if ($user->id !== $currentUser->id) {
            //入库操作
            $currentUser->followings()->toggle($user->id);

            if (!($currentUser->can('follow', $user))) //如果关注已经入库成功[可关注状态为false]，那就要通知，否则就是取关，不用通知
            {
                //通知被关注用户
                Notification::send($user, new NewUserFollowNotification($currentUser));
            }
        }

        //返回新能否关注的状态 [follow是FollowPolicy中的follow方法，FollowPolicy已经在AuthServiceProvider中注册]
        return response()->json(
            [
                'followable' => $currentUser->can('follow', $user),
                'self' => $user->id === $currentUser->id,
            ]
        );
    }
}
