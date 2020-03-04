<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class SettingController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $settings = auth()->user()->settings;
        return view('users.setting', compact('settings'));
    }

    public function store(Request $request)
    {
//        $settings = auth()->user()->settings;
//        if (!is_array($settings)) {
//            $settings = [];
//        }
//        $settings = array_merge(
//            $settings,
//            array_only(
//                $request->all(),
//                [
//                    'city',
//                    'info'
//                ]
//            )
//        );
//
//        auth()->user()->update(
//            [
//                'settings' => $settings,
//            ]
//        );

        auth()->user()->settings()->merge($request->all());


        return redirect()->back()->with('success', '更新成功！');
    }
}
