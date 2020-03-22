<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\{Room, RoomUsers};
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Arr;

class WelcomeController extends Controller
{

    public function index ()
    {
        $rooms = Room::all();
        $arr = [];

        foreach ($rooms as $rum) {
            $arr[] = $rum->id;
        }

        $reqRooms = RoomUsers::where('user_id', Auth::id())->get('room_id');

        $idArray = [];

        foreach ($reqRooms as $room) {
            $idArray[] = $room->room_id;
        }

        $collection = collect($arr);

        $diff = $collection->diff($idArray);

        $array = [];

        foreach ($diff as $value) {
            $array[] = Room::where('id', $value)->get();
        }

        $array = Arr::flatten($array);

        return view('welcome', compact('array'));
    }

}
