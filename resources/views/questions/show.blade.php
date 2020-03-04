@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md offset-1">
                {{--问题--}}
                <div class="card">
                    <div class="card-header">
                        {{ $question->title }}

                        @foreach(['success','warning','danger'] as $info)
                            @if(session()->has($info))
                                <div class="alert alert-{{$info}}">{{ session()->get($info) }}</div>
                            @endif
                        @endforeach

                        @can('update',$question)
                            <a href="{{ route('questions.edit',$question) }}" class="btn btn-warning">编辑</a>
                        @endcan

                        @can('destroy',$question)
                            <form action="{{ route('questions.destroy',$question) }}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger">删除</button>
                            </form>
                        @endcan

                        @forelse($question->topics as $topic)
                            <button class="btn btn-secondary float-md-right m-1">{{ $topic->name }}</button>
                        @empty
                            <p class="text text-warning float-md-right"> "No Topics"</p>
                        @endforelse

                        <p class="text text-info float-md-right"> 已有{{ count($question->answers) }}个回答</p>

                    </div>
                    <div class="card-body">
                        {!! $question->content !!}
                    </div>
                </div>


                {{--回答提交form--}}
                {{--只有登录用户可以提交回答--}}
                @if(auth()->check())
                    <div class="card mt-2">
                        <div class="card-header">
                            提交回答
                        </div>
                        <div class="card-body">
                            <form action="{{ route('answers.store',$question) }}" method="post">
                            @csrf
                            <!-- 回答编辑器容器 -->
                                <script id="container" name="content" type="text/plain"
                                        style="width: 100%;height: 200px">{!! old('content') !!}</script>
                                <p class="text text-danger"> @error('content') {{ $message }} @enderror </p>
                                <!--提交按钮-->
                                <button type="submit" class="btn btn-primary float-md-right mt-2">提交回答</button>
                            </form>
                        </div>
                    </div>
                @else
                    {{--显示请登录--}}
                    <a href="{{ route('login') }}" class="btn btn-success btn-block mt-4">登录提交答案</a>
                @endif
                {{--展示答案--}}
                @forelse($question->answers as $answer)
                    <div class="card mt-4">
                        <div class="card-header">
                            @include('users._small_icon',['userable'=>$answer])
                            <span class="float-right text text-info text-center">
                                {{ $answer->updated_at->diffForHumans() }}</span>
                            @if(auth()->check())
                                <user-vote-button answer="{{ $answer->id }}"
                                                  vote_count="{{ $answer->userVotes->count() }}"
                                                  class="float-right"></user-vote-button>
                            @endif
                        </div>

                        <div class="card-body">
                            {!!  $answer->content  !!}
                        </div>
                        <div class="card-footer">
                            <comments type="answer" commentable_id="{{  $answer->id }}"></comments>
                        </div>
                    </div>

                @empty

                @endforelse
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-header">
                        <h2> {{ $question->followers_count }}</h2>
                        <span>关注者</span>
                    </div>
                    <div class="card-body">
                        <question-follow-button question="{{$question->id}}">
                        </question-follow-button>
                    </div>
                </div>

                <div class="card mt-4">
                    <div class="card-header">
                        <h2> 提问者 </h2>
                    </div>
                    <div class="card-body">
                        @include('users._small_icon',['userable'=>$question])
                    </div>
                    @include('users._user_stats')
                </div>
            </div>


        </div>
    </div>
@endsection
@section('footer-js')
    @include('questions._footer_js')
@endsection
