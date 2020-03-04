<div>
    <img src="{{ $userable->user->avatar }}" class="card-img img-thumbnail imgWrap "
         style="width: 50px" alt="{{ $userable->user->name }}">
    <span class="text text-info">{{ $userable->user->name }}</span>
</div>
<div class="float-left mt-2">
    <user-follow-button user="{{ $userable->user->id }}"></user-follow-button>
    @if(auth()->check())
        @if(auth()->user()->id!==$userable->user->id)
            <div class="float-right">
                <send-message user="{{ $userable->user->id }}"></send-message>
            </div>
        @endif
    @endif
</div>
