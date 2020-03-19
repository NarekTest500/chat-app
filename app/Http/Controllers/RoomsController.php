<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\StoreRoomRequest;
use App\Room;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\Auth;

class RoomsController extends Controller
{

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
