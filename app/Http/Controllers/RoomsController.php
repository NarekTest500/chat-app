<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRoomRequest;
use App\Room;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

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
            return redirect('/');
        }

    }

}
