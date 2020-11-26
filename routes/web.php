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
    return redirect('index');
    //return view('welcome');
});

Route::get('/index', 'ImageController@index');

Route::get('/upload', function () {
    return view('images.upload');
});
Route::post('/upload', 'ImageController@store');

Route::get('/image/{id}', 'ImageController@show');
