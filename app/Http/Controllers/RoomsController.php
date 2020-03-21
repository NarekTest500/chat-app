<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRoomRequest;
use App\{Room, Message, RoomUsers};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;
use App\Http\Requests\AddRoomStore;

class RoomsController extends Controller
{

    /**
     * Create a new controller instance.
     *
     * @return void
    */
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index ()
    {
        $authRooms = Room::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->get();
        $reqRooms = RoomUsers::where('user_id', Auth::id())->get();

        $roomsArr = [];
        $joinRoom = [];

        foreach ($reqRooms as $room) {
            $roomsArr[] = $room->room_id;
        }

        foreach ($roomsArr as $id) {
            $joinRoom[] = Room::where('id', $id)->get();
        }

        return view('rooms.index', [
            'authRooms' => $authRooms,
            'joinRoom' => $joinRoom
        ]);

        // $rooms = Room::orderBy('id', 'desc')->where('user_id', Auth::user()->id)->get();

        // return view('rooms.index', compact('rooms'));
    }

    public function create ()
    {
        return view('rooms.create');
    }

    public function store (StoreRoomRequest $request)
    {
        $validated = $request->validated();

        $validated['url'] = Str::random();
        $validated['user_id'] = Auth::id();

        $created = Room::create($validated);

        $room_users_validate = new RoomUsers;
        $room_users_validate->user_id = $created->user_id;
        $room_users_validate->room_id = $created->id;
        $room_users_validate->save();

        if ($created && $room_users_validate) {
            return redirect('/room');
        }

    }

    public function singleRoom ($roomUrl)
    {
        $room = Room::where('url', $roomUrl)->get();

        $roomId = $room[0]->id;
        $userId = Auth::id();

        $room_users = RoomUsers::where([
            ['user_id', '=', $userId],
            ['room_id', '=', $roomId],
        ])->get();

        if ($room_users->isEmpty()) {
            return redirect('/');
        }

        return view('rooms.singleRoom', compact('roomUrl'));
    }

    public function fetchMessages ()
    {
        return Message::with('user')->get();
    }

    public function sendMessages (Request $request)
    {
        $message = Auth::user()->messages()->create([
            'message' => $request->message
        ]);

        broadcast(new MessageSent($message->load('user')))->toOthers();

        return ['status' => 'Success'];
    }

    public function addRoom (AddRoomStore $request)
    {
        $validated = $request->validated();

        $created = RoomUsers::create($validated);

        if ($created) {
            return back();
        }
    }

}
