@extends('layouts.app')
@section('content')
    <div class="contaier">
        <div class="row">
            <div class="col-md-8 col-md offset-1">
                @foreach(['success','warning','danger'] as $info)
                    @if(session()->has($info))
                        <div class="card">
                            <div class="card-body">
                                <div class="alert alert-{{$info}}">{{ session()->get($info) }}</div>
                            </div>
                        </div>
                    @endif
                @endforeach
                <div class="card">
                    <div class="card-header">
                        发布问题
                    </div>
                    <div class="card-body">
                        <form action="{{ route('questions.store') }}" method="post">
                            {{--注意要有csrftoken--}}
                            @csrf
                            <div class="form-group">
                                <label for="title">标题</label>
                                <input type="text" name="title" class="form-control" placeholder="标题" id="title"
                                       value="{{ old('title') }}">
                                <p class="text text-danger"> @error('title') {{ $message }} @enderror </p>
                            </div>
                            <!-- Select2 Topic Select -->
                            <div class="form-group">
                                <label for="topic_list">选择主题</label>
                                <select id="topic_list" class="js-example-basic-multiple form-control"
                                        style="width: 100%"
                                        name="topics[]" multiple></select>
                            </div>
                            <!-- 编辑器容器 -->
                            <script id="container" name="content" type="text/plain"
                                    style="width: 100%">{!! old('content') !!}</script>
                            <p class="text text-danger"> @error('content') {{ $message }} @enderror </p>
                            <!--发布按钮-->
                            <button type="submit" class="btn btn-primary mt-2 float-md-right">发布问题</button>
                        </form>
                    </div>
                </div>

                @forelse($questions as $question)
                    <div class="card mt-4">
                        <div class="card-header">
                            <a href="{{ route('questions.show',$question) }}"
                               class="text text-primary">{{ $question->title }}</a>
                            <a href="#"
                               class="btn btn-secondary">{{ $question->user->name }}</a>

                            @can('update',$question)
                                <a href="{{ route('questions.edit',$question) }}"
                                   class="btn btn-info">编辑</a>
                            @endcan

                            @can('destroy',$question)
                                <form action="{{ route('questions.destroy',$question) }}" method="post">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger">删除</button>
                                </form>
                            @endcan

                            @forelse($question->topics as $topic)
                                <p class="badge badge-dark float-md-right m-1">{{ $topic->name }}</p>
                            @empty
                                <p class="badge badge-warning float-md-right "> "No Topics"</p>
                            @endforelse
                        </div>
                        <div class="card-body">
                            {!! $question->content !!}
                        </div>
                    </div>
                @empty
                    <p class="text text-danger">找不到问题</p>
                @endforelse
            </div>

            {{--展示其他信息--}}
            <div class="col-md-3">


            </div>
        </div>
@endsection
@section('footer-js')
    @include('questions._footer_js')
@endsection
