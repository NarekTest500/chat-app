<?php

// use App\Events\WebsocketDemoEvent;
use Illuminate\Support\Facades\{Route, Auth, Broadcast};

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

Route::get('/', 'WelcomeController@index');

Broadcast::routes();

Auth::routes();

Route::get('/home', 'HomeController@index')->name('home');

// Route::get('/chat', 'ChatsController@index');

// Route::get('/messages', 'ChatsController@fetchMessages');
// Route::post('/messages', 'ChatsController@sendMessages');

Route::get('/room', 'RoomsController@index');
Route::get('/room/create', 'RoomsController@create');
Route::post('/room/create', 'RoomsController@store');
Route::get('/room/{room}', 'RoomsController@singleRoom');

Route::get('/messages', 'RoomsController@fetchMessages');
Route::post('/messages', 'RoomsController@sendMessages');

Route::post('/addroom', 'RoomsController@addRoom');
Route::post('/sendRoomId', 'RoomsController@sendRoomId');
