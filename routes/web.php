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

Route::prefix('room')->group(function () {
    Route::get('/', 'RoomsController@index');
    Route::get('/create', 'RoomsController@create');
    Route::post('/create', 'RoomsController@store');
    Route::get('/{room}', 'RoomsController@singleRoom');
    Route::post('/sendRoomId/{id}', 'RoomsController@leaveRoom');
});

Route::get('/messages', 'RoomsController@fetchMessages');
Route::post('/messages', 'RoomsController@sendMessages');

Route::post('/addroom', 'RoomsController@addRoom');
Route::post('/sendRoomId', 'RoomsController@sendRoomId');
