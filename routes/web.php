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
//msgboard
Route::get('/board','CommentController@index')->name('board');
Route::post('/board','CommentController@store');
//apis
Route::get('/api/records/{record}','RecordController@getRecord');
Route::get('/getToken','RecordController@getSign')->middleware('admin');

