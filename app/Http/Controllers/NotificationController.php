<?php

namespace App\Http\Controllers;

use App\User;
use Illuminate\Http\Request;

class NotificationController extends Controller
{
    //
    public function index()
    {
        $user = auth()->user();

        //设置已读字段数据
        $user->notifications->map(function ($notification) {
            $notification->forceFill([
                'read_at' => now(),
            ])->save();
        });
        return view('notifications.index', compact('user'));
    }
}
