<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRoomRequest;
use App\{Room, Message};
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;
use App\Events\MessageSent;

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
        $rooms = Room::orderBy('id', 'desc')->get();

        return view('rooms.index', compact('rooms'));
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

        if ($created) {
            return redirect('/room');
        }

    }

    public function singleRoom ($roomId)
    {
        return view('rooms.singleRoom', compact('roomId'));
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

}
