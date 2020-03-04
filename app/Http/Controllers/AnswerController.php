<?php

namespace App\Http\Controllers;

use App\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{

    /**
     * AnswerController constructor.
     */
    public function __construct()
    {
        //只有登录用户才能回答问题 但是可以查看 和查看提交创建页面，引导用户去注册
        $this->middleware(['auth',])->except(['index', 'create', 'show']);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }


    /** Store a newly created resource in storage.
     * @param Request $request
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(Request $request, Question $question)
    {
        //

        //初始化回答数据
        $data = $request->validate([
            'content' => 'required|min:30',
        ]);
        $data['user_id'] = auth()->user()->id;

        $data['question_id'] = $question->id;

        //创建回答入库
        $answer = Answer::create($data);
        //更新问题里的数据
        $question->increment('answers_count');
        //更新用户里的数据
        auth()->user()->increment('answers_count');
        return redirect()->back()->with('success', "回答成功！");
    }

    /**
     * Display the specified resource.
     *
     * @param \App\Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function show(Answer $answer)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \App\Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function edit(Answer $answer)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param \App\Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Answer $answer)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param \App\Answer $answer
     * @return \Illuminate\Http\Response
     */
    public function destroy(Answer $answer)
    {
        //
    }
}
