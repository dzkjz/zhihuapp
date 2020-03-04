@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card">
                <div class="card-header">
                    你有新的消息！
                </div>
                <div class="card-body">
                    @forelse($user->notifications as $notification)
                        <p class="text text-warning {{($notification->read_at===null)?'unread':'read'}}">
                            @include('notifications.'.snake_case(class_basename($notification->type)))
                        </p>
                    @empty
                    @endforelse
                </div>
            </div>
        </div>
    </div>
@endsection
