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
Route::get('/records/create','RecordController@create')->name('create');
Route::post('/records/create/upload-img','RecordController@imgUpload');
Route::post('/records','RecordController@store');
//edit
Route::get('/records/{id}/edit','RecordController@editView')->name('edit');
Route::post('/records/{id}/edit/change-img','RecordController@changeImg');
Route::put('/records/{id}','RecordController@update');
Route::delete('/records/{record}','RecordController@delete')->middleware('admin');

//apis
Route::get('/api/records/{record}','RecordController@getRecord');

