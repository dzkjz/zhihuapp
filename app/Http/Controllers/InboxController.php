<?php

namespace App\Http\Controllers;

use App\Message;

use App\Notifications\NewMessageNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Notification;


class InboxController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    //
    public function index()
    {
        $messages = auth()->user()->messages->groupBy('from_user_id');
//        $messages->map(function ($message) {
//            return $message->map(function ($item) {
////                return $item->with('user');
//                return $item->fromUser;
//            });
//        });
        return view('inbox.index', compact('messages'));
    }

    public function show($userId)
    {
        if (auth()->user()->id == $userId) {
            return redirect()->back()->with('不能回复自己');
        }
        $messages = auth()->user()->messages->where('from_user_id', $userId);

        //设置信息已读
        $messages->markAsRead();

        //获取回复信息
        $replies = Message::query()->where('to_user_id', $userId)
            ->where('from_user_id', auth()->user()->id)
            ->get();
        if ($replies) {
            //整合
            foreach ($replies as $reply) {
                $messages->push($reply);
            }
        }
        //排序
        $messages = $messages->sortBy('created_at');
        return view('inbox.show', compact('messages'));
    }

    public function store(Request $request, $userId)
    {

        if (auth()->user()->id == $userId) {
            return redirect()->back()->with('不能回复自己');
        }
        $message = Message::create(
            [
                'from_user_id' => auth()->user()->id,
                'to_user_id' => $userId,
                'content' => $request->get('content')
            ]
        );

        //发送通知
        $message
            ->toUser //通知接受方，所以是toUser
            ->notify(new NewMessageNotification($message));//用户类使用了Notifiable这个 trait

        return redirect()->route('inbox.show', $userId)->with('success', '发送成功');
    }
}
