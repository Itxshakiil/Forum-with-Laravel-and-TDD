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

Route::get('/threads', 'ThreadsController@index')->name('threads.index');
Route::post('/threads', 'ThreadsController@store')->middleware('verified')->name('threads.store');
Route::get('/threads/create', 'ThreadsController@create')->name('threads.create');
Route::get('/threads/{channel}', 'ThreadsController@index');
Route::get('/threads/{channel}/{thread}', 'ThreadsController@show')->name('threads.show');
Route::patch('/threads/{channel}/{thread}', 'ThreadsController@update')->name('threads.update');
Route::delete('/threads/{channel}/{thread}', 'ThreadsController@destroy')->name('threads.destroy');
Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@store')->name('subscribe');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionsController@destroy')->name('unsubscribe');

Route::get('/threads/{channel}/{thread}/replies', 'RepliesController@index')->name('reply.index');
Route::post('/threads/{channel}/{thread}/replies', 'RepliesController@store')->name('reply.store');
Route::post('/replies/{reply}/favorites', 'FavoritesController@store')->name('reply.favorite');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy')->name('reply.unfavorite');
Route::patch('/replies/{reply}', 'RepliesController@update')->name('reply.update');
Route::delete('/replies/{reply}', 'RepliesController@destroy')->name('reply.destroy');
Route::post('/replies/{reply}/best', 'BestRepliesController@store')->name('best-replies.store');

Route::get('/profiles/{user}', 'ProfilesController@show')->name('profile.show');
Route::get('/profiles/{user}/notifications', 'UserNotificationsController@index')->name('notifications.index');
Route::delete('/profiles/{user}/notifications/{notification}', 'UserNotificationsController@destroy')->name('notifications.destroy');

Route::get('/api/users', 'Api\UsersController@index');
Route::post('/api/users/{user}/avatar', 'Api\UserAvatarController@store')->middleware('auth');

Route::post('/locked-threads/{thread}', 'LockedThreadsController@store')->name('locked-threads.store')->middleware('admin');
Route::delete('/locked-threads/{thread}', 'LockedThreadsController@destroy')->name('locked-threads.destroy')->middleware('admin');
