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
Route::get('/home', 'HomeController@index')->name('home');
//create
Route::get('/records/create','RecordController@createView')->name('create');
Route::post('/records','RecordController@store');
//edit
Route::get('/records/{id}/edit','RecordController@editView')->name('edit');
Route::put('/records/{id}','RecordController@update');
Route::delete('/records/{record}','RecordController@delete')->middleware('admin');
//love
Route::post('/records/{record}/love-up','RecordController@loveUp');
//board
Route::get('/board','CommentController@index')->name('board');
Route::post('/board','CommentController@store');
Route::post('/board/reply','CommentController@reply')->middleware('admin');
Route::delete('/board/comment/{comment}','CommentController@delete')->middleware('admin');
//about
Route::get('/about',function(){
    return view('about');
})->name('about');
//profile&settings
Route::get('/profile/{user}','ProfileController@viewProfile');
Route::get('/settings','ProfileController@viewSettings')->middleware('auth')->name('settings');
Route::post('/settings','ProfileController@update')->middleware('auth');
//apis
Route::get('/api/records/{record}','RecordController@getRecord');
//new cos token
Route::get('/reusableToken','CosTokenController@reusable')->middleware('auth');
Route::get('/onceToken','CosTokenController@once')->middleware('auth');

