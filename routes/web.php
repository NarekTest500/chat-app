<?php

use App\Events\WebsocketDemoEvent;
use Illuminate\Support\Facades\{Route, Auth};

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

Route::get('/', 'IndexController@index');

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/chats/{room}', 'ChatsController@index');
Route::get('/chats', 'ChatsController@index');

Route::get('/messages', 'ChatsController@fetchMessages');
Route::post('/messages', 'ChatsController@sendMessages');

Route::get('/room/create', 'RoomsController@create');
Route::post('/room/create', 'RoomsController@store');
