@extends('layouts.app')

@section('content')

    <h1 class="text-center">My Rooms</h1>

    <div class="container">

        <a href="room/create" class="btn btn-primary mt-5"> Create Room  + </a>

        <div class="row">

            <div class="col-lg-6 border border-secondary mt-5">
                <h1>Joined rooms</h1>
                @foreach ($joinRoom as $room)
                    <div class="card">
                        <div class="card-body">
                            <h5 class="card-title">{{$room[0]->title}}</h5>
                            <p class="card-text">{{$room[0]->description}}</p>
                            <a href="room/{{$room[0]->url}}" class="btn btn-primary">Go room</a>
                            <code>{{$room[0]->created_at}}</code>
                        </div>
                    </div>
                @endforeach
            </div>

            <div class="col-lg-6 border border-secondary mt-5">

                <h1>Own rooms</h1>
                @if (count($authRooms) > 0)
                    @foreach ($joinRoom as $join)
                        <div class="card mt-5">
                            <div class="card-body">
                                <h5 class="card-title">{{$join->title}}</h5>
                                <p class="card-text">{{$join->description}}</p>
                                <a href="room/{{$join->url}}" class="btn btn-primary">Go room</a>
                                <code>{{$join->created_at}}</code>
                            </div>
                        </div>
                    @endforeach

                    @else

                    <p>No own room</p>

                @endif
            </div>

        </div>

    </div>

@endsection
