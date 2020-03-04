<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Builder;

class CommentController extends Controller
{
    //

    public function showAnswerComment($id)
    {
        //https://laravel.com/docs/5.8/eloquent-relationships#querying-polymorphic-relationships
        $comments = Comment::whereHasMorph('commentable', ['App\Answer'], function (Builder $query) use ($id) {
            $query->where('id', '=', $id);
        })->with('user')->get();

        return response()->json(
            [
                'comments' => $comments,
            ]
        );
    }

    public function showQuestionComment($id)
    {
        $comments = Comment::query()->whereHasMorph('commentable', 'App\Models\Question', function (Builder $query) use ($id) {
            $query->where('id', $id);
        })->with('user')->get();
        return response()->json(
            [
                'comments' => $comments,
            ]
        );
    }

    public function store(Request $request)
    {
        $type = ($request->get('type') === 'answer') ? 'App\Answer' : 'App\Models\Question';
        $comment = Comment::create([
            'commentable_type' => $type,
            'commentable_id' => $request->get('commentable_id'),
            'user_id' => auth()->user()->id,
            'content' => $request->get('postComment'),
        ]);
        $comment = Comment::query()->where('id', $comment->id)->with('user')->get();
        return response()->json(
            [
                'comment' => $comment,
            ]
        );
    }

}
