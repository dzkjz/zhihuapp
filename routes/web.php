<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

Route::get('/', function () {
    return view('welcome');
});

Auth::routes(['verify' => true]);

Route::get('/home', 'HomeController@index')->name('home');

Route::resource('questions', 'QuestionController');


#region 回答路由CRUD

//查看回答 以及 回答的form 都是在questions详细内容页面

//提交回答
Route::post('questions/{question}/answers', 'AnswerController@store')->name('answers.store');

//更新回答


//删除回答


#endregion


#region
//用户关注 取消关注问题
Route::get('questions/{question}/follow', 'QuestionController@follow')->name('questions.follow');
#endregion


#region

//用户通知消息路由
Route::get('/notifications', 'NotificationController@index')->name('notification.index');
#endregion

#region
//用户查看短消息
Route::get('/inbox', 'InboxController@index')->name('inbox.index');

//展示用户间私信对话具体内容页
Route::get('/inbox/{userId}', 'InboxController@show')->name('inbox.show');

//用户回信息
Route::post('/inbox/{userId}/send', 'InboxController@store')->name('inbox.store');
#endregion


#region
//访问用户详细页面

Route::get('/avatar', 'UserController@avatar')->name('users.avatar');

Route::post('/avatar/upload', 'UserController@avatarStore');

#endregion


#region

Route::get('setting', 'SettingController@index')->name('setting.index');

Route::post('setting', 'SettingController@store')->name('setting.store');
#endregion
