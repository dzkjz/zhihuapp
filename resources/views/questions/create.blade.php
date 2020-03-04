@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="col-md-8 col-md-offset-2">
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
            </div>
        </div>
    </div>
@endsection
@section('footer-js')
    @include('questions._footer_js')
@endsection
