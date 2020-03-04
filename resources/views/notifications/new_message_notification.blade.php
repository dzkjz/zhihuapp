<li class="badge badge-light text-primary">
    <p> "你好!"
        <a href="{{ route('inbox.show',$notification->data['id']) }}">
            {{ $notification->data['fromUser']."给你发来了新私信：" }}
        </a>
    </p>
    <p>  {{ $notification->data['content'] }} </p>
</li>
