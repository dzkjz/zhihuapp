<?php

namespace App\Http\Controllers;

use App\Http\Requests\QuestionStoreRequest;
use App\Models\Question;
use App\Repositories\QuestionRepository;
use App\User;
use Illuminate\Http\Request;

class QuestionController extends Controller
{

    /**
     * @var QuestionRepository
     */
    private $questionRepository;

    public function __construct(QuestionRepository $questionRepository)
    {
        $this->middleware(
            'auth',
            [
                'except' =>
                    [
                        'index',
                        'show',
                        'followThroughApi'
                    ]//非注册用户只能查看不能编辑添加更改删除
            ]
        );

        $this->questionRepository = $questionRepository;
    }


    /** Display a listing of the resource.
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function index()
    {
        //
        $questions = $this->questionRepository->getQuestionPublished();
        return view('questions.index', compact('questions'));
    }


    /**
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function create()
    {
        //
        return view('questions.create');
    }


    /**
     * @param QuestionStoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(QuestionStoreRequest $request)//依赖注入QuestionStoreRequest实例
    {
        //
//        $data = $request->validate([
//            'title' => 'required|min:8',
//            'content' => 'required|min:28',
//        ]);
        //存储topics
        $topics = $this->questionRepository->normalizeTopics($request->get('topics'));
        //初始化question要用到的数据
        $data = $request->all();
        $data['user_id'] = auth()->user()->id;

//        $question=Question::create($data); 被下方代码取代
        $question = $this->questionRepository->create($data);

        //使用我们再question model里面添加的topics方法获得 topics关联，再使用attach方法
        $question->topics()->attach($topics);

        return redirect()->route('questions.show', $question);
    }


    /**
     * @param Question $question
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\View\View
     */
    public function show(Question $question)
    {
        //使用关系关联加载，with方法会将分类之下的主题一起查询出来，而且不会出现N+1影响性能的问题
        $question->with('topics')->get();
        //使用关系关联加载，with方法会将分类之下的回答一起查询出来，而且不会出现N+1影响性能的问题
        $question->with('answers')->get();

        return view('questions.show', compact('question'));
    }


    /**判断权限 返回视图
     * @param Question $question
     * @return \Illuminate\Contracts\View\Factory|\Illuminate\Http\RedirectResponse|\Illuminate\View\View
     */
    public function edit(Question $question)
    {
        if (auth()->user()->can('update', $question)) //判断当前用户是否有权编辑更新该question实例
        {
            //返回编辑视图
            return view('questions.edit', compact('question'));
        } else {
            //返回警告 没有权限
            return redirect()->back()->with('warning', '你不能编辑不属于你的问题！');
        }
    }


    /** Update the specified resource in storage.
     * @param QuestionStoreRequest $questionStoreRequest
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(QuestionStoreRequest $questionStoreRequest, Question $question)
    {
        //更新前 判断下权限
        if (!(auth()->user()->can('update', $question))) {
            //返回警告 没有权限
            return redirect()->back()->with('warning', '你不能编辑不属于你的问题！');
        }
        //取得更新的字段 使用Eloquent提供的update方法执行问题更新
        $question->update([
            'title' => $questionStoreRequest->get('title'),
            'content' => $questionStoreRequest->get('content'),
        ]);


        //topics的操作这时候看起来有点臃肿 可以使用TopicController来管理，暂时省略
        //存储topics
        $topics = $this->questionRepository->normalizeTopics($questionStoreRequest->get('topics'));
        //使用我们再question model里面添加的topics方法获得 topics关联，
        //再使用sync方法同步tag 【删除的会被删除掉，没删除的就保留，新的就增加】
        $question->topics()->sync($topics);

        //更新完成，跳转回去
        return redirect()->back();
    }


    /**Remove the specified resource from storage.
     * @param Question $question
     * @return \Illuminate\Http\RedirectResponse
     * @throws \Exception
     */
    public function destroy(Question $question)
    {
        //
        if (auth()->user()->can('destroy', $question)) {
            $question->delete();
            return redirect()->route('questions.index')->with('success', "删除成功！");
        }
        return redirect()->back()->with('danger', "你不能删除不属于你的问题！");
    }


    public function follow(Question $question)
    {
        if (auth()->user()->can('follow', $question)) //通过QuestionPolicy的follow方法判断用户是否可以关注问题
        {
            $message = "关注";
        } else {
            $message = "取关";
        }
        //同步记录
        auth()->user()->followQuestions()->toggle($question);
        $question->followers_count = $question->followUsers()->count();
        $question->save();
        return redirect()->back()->with('success', $message . '成功！');
    }

    public function getFollowStats(Request $request)
    {
        $user = auth()->guard('api')->user();
        $question = Question::find($request->get('question'));

        $followable = $user->can('follow', $question);

        return response()->json([
            'followable' => $followable,
        ]);
    }

    public function followThroughApi(Request $request)
    {
        $user = auth()->guard('api')->user();
        $question = Question::find($request->get('question'));

        //同步记录
        $user->followQuestions()->toggle($question->id);
        $question->followers_count = $question->followUsers()->count();
        $question->update();
        //判断用户关注状态
        $followable = $user->can('follow', $question);

        return response()->json([
            'followable' => $followable,
        ]);
    }
}
