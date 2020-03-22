<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRoomRequest;
use App\{Room, Message, RoomUsers};
use Illuminate\Support\{Str, Arr};
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

        $reqRooms = RoomUsers::orderBy('created_at', 'desc')->where('user_id', Auth::id())->get();

        $roomsArr = [];
        $joinRoom = [];

        foreach ($reqRooms as $room) {
            $roomsArr[] = $room->room_id;
        }

        foreach ($roomsArr as $id) {
            $joinRoom[] = Room::where('id', $id)->get();
        }

        $joinRoom = Arr::flatten($joinRoom);

        return view('rooms.index', compact('joinRoom'));

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

        if ($room->isEmpty()) {
            return redirect('/');
        }

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

        $url = url()->previous();
        $lastElement = explode('/', $url);

        $originalUrl = $lastElement[count($lastElement) - 1];

        $room = Room::where('url', $originalUrl)->get();

        return Message::with('user')->where('room_id', $room[0]->id)->get();
    }

    public function sendMessages (Request $request)
    {
        $url = url()->previous();

        $arr = explode('/', $url);

        $roomUrl = $arr[count($arr) - 1];

        $room = Room::where('url', $roomUrl)->get();

        $message = Auth::user()->messages()->create([
            'message' => $request->message,
            'room_id' => $room[0]->id
        ]);

        broadcast(new MessageSent($message->load('user')))->toOthers();

        return ['status' => 'Success'];
    }

    public function addRoom (AddRoomStore $request)
    {
        $validated = $request->validated();

        $created = RoomUsers::create($validated);

        if ($created) {
            return redirect('room');
        }
    }

    public function leaveRoom ($id)
    {
        $room = RoomUsers::where([
            'user_id' => Auth::id(),
            'room_id' => $id
        ])->delete();

        $message = Message::where([
            'user_id' => Auth::id(),
            'room_id' => $id
        ])->get();

        if (!$message->isEmpty()) {
            Message::where([
                'user_id' => Auth::id(),
                'room_id' => $id
            ])->delete();
        }

        if ($room) {
            return redirect('/room');
        }
    }

}
