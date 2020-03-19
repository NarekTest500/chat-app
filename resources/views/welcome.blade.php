@extends('layouts.app')

@section('content')

    <h1 class="text-center">All Rooms</h1>

    <div class="container">

        <a href="room/create" class="btn btn-primary mt-5"> Create Room  + </a>

        @foreach ($rooms as $room)
            <div class="card mt-5">
                <div class="card-body">
                    <h5 class="card-title">{{$room->title}}</h5>
                    <p class="card-text">{{$room->description}}</p>
                    <a href="chats/{{$room->url}}" class="btn btn-primary">Go room</a>
                </div>
            </div>
        @endforeach

    </div>

    <script src="js/app.js"></script>

@endsection
