<div class="card-footer float">
    <div class="text-center float-left mr-4">
        <div class="text">提问数</div>
        <div class="number">{{ $question->user->questions_count }}</div>
    </div>
    <div class="text-center float-left mr-4">
        <div class="text">回答数</div>
        <div class="number">{{ $question->user->answers->count() }}</div>
    </div>
    <div class="text-center float-left ">
        <div class="text">粉丝数</div>
        <div class="number">{{ $question->user->followers->count() }}</div>
    </div>
</div>
