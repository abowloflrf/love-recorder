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

Route::get('/record',function (){
    return \App\Record::all();
});

Route::get('/record/{record}','RecordController@getRecord');
Route::put('/records/{id}','RecordController@update');
Route::get('/records/{id}/edit','RecordController@editView');
Route::post('/records/{id}/edit/change-img','RecordController@changeImg');
Route::get('/create','RecordController@index');
Route::post('/create/upload-img','RecordController@imgUpload');
Route::post('/record','RecordController@store');

