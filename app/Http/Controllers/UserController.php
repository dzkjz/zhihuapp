<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }


    /** 返回用户avatar页面视图
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function avatar()
    {
        return view('users._avatar');
    }

    public function avatarStore(Request $request)
    {
        $user = auth()->user();
        $file = $request->file('img');
        $fileName = md5(time() . $user->id) . '.' . $file->getClientOriginalExtension();
        $file->move('uploads/image/avatars', $fileName);

        $user->avatar = asset('uploads/image/avatars/' . $fileName);

        $user->save();

        return response()->json(
            [
                'url' => $user->avatar,
            ]);
    }
}
