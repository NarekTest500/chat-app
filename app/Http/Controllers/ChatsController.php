<?php

namespace App\Http\Controllers;

use App\Events\MessageSent;
use App\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Room;

class ChatsController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index ()
    {
        return view('chats');
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
