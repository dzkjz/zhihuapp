<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    //
    public function __construct()
    {
        $this->middleware('auth');
    }


    public function getVoteStats(Request $request)
    {
        $answer = Answer::find($request->get('answer'));

        $user = auth()->user();

        //是否可以点赞
        return response()->json(
            [
                'voteable' => !($user->votes->contains('id', $answer->id)),
                'vote_count' => $answer->userVotes->count(),
            ]
        );
    }

    public function voteUpThroughApi(Request $request)
    {
        $answer = Answer::find($request->get('answer'));

        $user = auth()->user();

        $user->voteAnswer($answer->id);

        //是否可以点赞
        return response()->json(
            [
                'voteable' => !($user->votes->contains('id', $answer->id)),
                'vote_count' => $answer->userVotes->count(),
            ]
        );
    }
}
