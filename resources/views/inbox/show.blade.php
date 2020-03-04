@extends('layouts.app')
@section('content')
    <div class="container">
        <div class="row">
            <div class="card">
                @if($messages->first())
                    <div class="card-header">
                        <a href="#">

                            <img src="{{ $messages->first()->fromUser->avatar }}"
                                 alt="{{ $messages->first()->fromUser->name }}"
                                 class="img-thumbnail img-fluid card-img" style="height: 30px;width: 30px">
                            {{ $messages->first()->fromUser->name }}

                        </a>
                    </div>
                    <div class="card-body">
                        <div class="messaging">
                            <div class="inbox_msg">

                                <div class="mesgs">
                                    <div class="msg_history">
                                        @forelse($messages as $message)
                                            @if($message->fromUser->id===auth()->user()->id)
                                                <div class="outgoing_msg">
                                                    <div class="sent_msg">
                                                        @if($message->read_at)
                                                            <span class="text-black-50">已读</span>
                                                        @endif
                                                        <p> {{$message->content}}</p>
                                                        <span
                                                            class="time_date"> {{$message->created_at->diffForHumans()}}</span>
                                                    </div>
                                                </div>
                                            @else
                                                <div class="incoming_msg">
                                                    <div class="incoming_msg_img"><img
                                                            src="{{ $messages->first()->fromUser->avatar }}"
                                                            alt="{{ $messages->first()->fromUser->name }}">
                                                    </div>
                                                    <div class="received_msg">
                                                        <div class="received_withd_msg">
                                                            <p> {{$message->content}}</p>
                                                            <span
                                                                class="time_date">  {{$message->created_at->diffForHumans()}}</span>
                                                        </div>
                                                    </div>
                                                </div>
                                            @endif
                                        @empty
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="type_msg mt-2">
                            <div class="input_msg_write">
                                <form
                                    action="{{ route('inbox.store',($message->fromUser->id===auth()->user()->id)?$message->toUser->id:$message->fromUser->id) }}"
                                    method="post">
                                    @csrf
                                    <input type="text" class="write_msg" name="content" placeholder="输入信息回复"/>
                                    <button class="msg_send_btn" type="submit">
                                        <i class="fa fa-paper-plane-o"
                                           aria-hidden="true"></i>
                                    </button>
                                </form>
                            </div>
                        </div>
                    </div>
                @else
                    <div class="card-header">不好意思！找不到你要的数据！</div>
                @endif
            </div>
        </div>
    </div>
@endsection
<style>
    .container {
        margin: auto;
    }

    img {
        max-width: 100%;
    }

    .inbox_people {
        background: #f8f8f8 none repeat scroll 0 0;
        float: left;
        overflow: hidden;
        width: 40%;
        border-right: 1px solid #c4c4c4;
    }

    .inbox_msg {
        border: 1px solid #c4c4c4;
        clear: both;
        overflow: hidden;
    }

    .top_spac {
        margin: 20px 0 0;
    }

    .recent_heading {
        float: left;
        width: 40%;
    }

    .srch_bar {
        display: inline-block;
        text-align: right;
        width: 60%;
    }

    .recent_heading h4 {
        color: #05728f;
        font-size: 21px;
        margin: auto;
    }

    .srch_bar input {
        border: 1px solid #cdcdcd;
        border-width: 0 0 1px 0;
        width: 80%;
        padding: 2px 0 4px 6px;
        background: none;
    }

    .srch_bar .input-group-addon button {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        padding: 0;
        color: #707070;
        font-size: 18px;
    }

    .srch_bar .input-group-addon {
        margin: 0 0 0 -27px;
    }

    .chat_ib h5 {
        font-size: 15px;
        color: #464646;
        margin: 0 0 8px 0;
    }

    .chat_ib h5 span {
        font-size: 13px;
        float: right;
    }

    .chat_ib p {
        font-size: 14px;
        color: #989898;
        margin: auto
    }

    .chat_img {
        float: left;
        width: 11%;
    }

    .chat_ib {
        float: left;
        padding: 0 0 0 15px;
        width: 88%;
    }

    .chat_people {
        overflow: hidden;
        clear: both;
    }

    .chat_list {
        border-bottom: 1px solid #c4c4c4;
        margin: 0;
        padding: 18px 16px 10px;
    }

    .inbox_chat {
        height: 550px;
        overflow-y: scroll;
    }

    .active_chat {
        background: #ebebeb;
    }

    .incoming_msg_img {
        display: inline-block;
        width: 6%;
    }

    .received_msg {
        display: inline-block;
        padding: 0 0 0 10px;
        vertical-align: top;
        width: 92%;
    }

    .received_withd_msg p {
        background: #ebebeb none repeat scroll 0 0;
        border-radius: 3px;
        color: #646464;
        font-size: 14px;
        margin: 0;
        padding: 5px 10px 5px 12px;
        width: 100%;
    }

    .time_date {
        color: #747474;
        display: block;
        font-size: 12px;
        margin: 8px 0 0;
    }

    .received_withd_msg {
        width: 57%;
    }

    .mesgs {
        float: left;
        padding: 30px 15px 0 25px;
        width: 60%;
    }

    .sent_msg p {
        background: #05728f none repeat scroll 0 0;
        border-radius: 3px;
        font-size: 14px;
        margin: 0;
        color: #fff;
        padding: 5px 10px 5px 12px;
        width: 100%;
    }

    .outgoing_msg {
        overflow: hidden;
        margin: 26px 0 26px;
    }

    .sent_msg {
        float: right;
        width: 46%;
    }

    .input_msg_write input {
        background: rgba(0, 0, 0, 0) none repeat scroll 0 0;
        border: medium none;
        color: #4c4c4c;
        font-size: 15px;
        min-height: 48px;
        width: 100%;
    }

    .type_msg {
        border-top: 1px solid #c4c4c4;
        position: relative;
    }

    .msg_send_btn {
        background: #05728f none repeat scroll 0 0;
        border: medium none;
        border-radius: 50%;
        color: #fff;
        cursor: pointer;
        font-size: 17px;
        height: 33px;
        position: absolute;
        right: 0;
        top: 11px;
        width: 33px;
    }

    .msg_history {
        height: 516px;
        overflow-y: auto;
    }
</style>
