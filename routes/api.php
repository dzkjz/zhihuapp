<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api')->get('/topics', function (Request $request) {
    $query = $request->query('q');
    return \App\Topic::query()->where('name', 'like', '%' . $query . '%')->get();
});
#region 问题关注
//加载页面时取关注状态
Route::middleware('auth:api')->post('/questions/follow/stats', 'QuestionController@getFollowStats');
//执行关注/取关操作
Route::middleware('auth:api')->post('/questions/follow', 'QuestionController@followThroughApi');
#endregion

#region 用户关注
//加载页面时取关注状态
Route::middleware('auth:api')->post('/users/follow/stats', 'FollowerController@getFollowStats');
//执行关注/取关操作
Route::middleware('auth:api')->post('/users/follow', 'FollowerController@followThroughApi');

#endregion


#region
//加载页面时取赞状态
Route::middleware('auth:api')->post('/answers/vote/stats', 'VoteController@getVoteStats');
//执行赞/取消赞操作
Route::middleware('auth:api')->post('/answers/vote/up', 'VoteController@voteUpThroughApi');
#endregion


#region

Route::middleware('auth:api')->post('/messages/send', 'MessageController@store');

#endregion


#region
Route::middleware('api')->get('/answer/{id}/comments', 'CommentController@showAnswerComment');
Route::middleware('api')->get('/question/{id}/comments', 'CommentController@showQuestionComment');

Route::middleware('auth:api')->post('/comments', 'CommentController@store');
#endregion

