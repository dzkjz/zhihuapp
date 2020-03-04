<?php

namespace App\Http\Controllers;

use App\Message;
use App\User;
use Illuminate\Http\Request;

class MessageController extends Controller
{
    //

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function store(Request $request)
    {
        $toUser = $request->get('user');

        $currentUser = auth()->user()->id;

        $content = $request->get('message');

        if ($content) {
            $data = [
                'from_user_id' => $currentUser,
                'to_user_id' => $toUser,
                'content' => $content,
            ];
            $message = Message::create($data);
            if ($message) {
                return response()->json(['success' => true]);
            }
        }
        return response()->json(['success' => false]);
    }
}
