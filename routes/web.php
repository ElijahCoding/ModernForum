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

Auth::routes();

Route::get('/home', 'HomeController@index');
Route::get('threads', 'ThreadController@index');
Route::get('threads/create', 'ThreadController@create');
Route::get('threads/{channel}/{thread}', 'ThreadController@show');
Route::delete('threads/{channel}/{thread}', 'ThreadController@destroy');
Route::post('threads', 'ThreadController@store');
Route::get('threads/{channel}', 'ThreadController@index');
Route::get('/threads/{channel}/{thread}/replies', 'ReplyController@index');
Route::post('/threads/{channel}/{thread}/replies', 'ReplyController@store');
Route::patch('/replies/{reply}', 'ReplyController@update');
Route::delete('/replies/{reply}', 'ReplyController@destroy');
Route::post('/replies/{reply}/favorites', 'FavoritesController@store');
Route::delete('/replies/{reply}/favorites', 'FavoritesController@destroy');

Route::post('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@store');
Route::delete('/threads/{channel}/{thread}/subscriptions', 'ThreadSubscriptionController@destroy');

Route::get('/profiles/{user}', 'ProfileController@show')->name('profile');
