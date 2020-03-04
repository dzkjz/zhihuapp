@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    @if($messages->filter(function ($value, $key){ return $value->where('read_at',null)->count()>0;})->count()>0)
                        <div class="alert alert-danger">
                            你有新的消息！
                        </div>
                    @endif
                </div>
                <div class="card-body">

                    @forelse($messages as $messageGroup)
                        <div class="card">
                            <div class="card-header">
                                <a href="#">
                                    <img src="{{ $messageGroup->first()->fromUser->avatar }}"
                                         alt="{{ $messageGroup->first()->fromUser->name }}"
                                         class="img-thumbnail img-fluid card-img" style="height: 30px;width: 30px">
                                    {{ $messageGroup->first()->fromUser->name }}
                                </a>
                            </div>
                            <div class="card-body">
                                <p class="text-success "> 查看详细对话请点击：</p>
                                @if($messageGroup->where('read_at',null)->count()>0)
                                    <p class="alert alert-warning">{{$messageGroup->where('read_at',null)->count()}}
                                        条未读消息</p>
                                @endif
                                <a href=" {{ route('inbox.show', $messageGroup->first()->fromUser->id) }}"
                                   class="btn btn-block bg-light"> {{ $messageGroup->first()->content }}</a>
                            </div>
                        </div>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
