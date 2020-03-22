@extends('layouts.app')

@section('content')

    <h1 class="text-center">My Rooms</h1>

    <div class="container">

        <a href="room/create" class="btn btn-primary mt-5"> Create Room  + </a>

            <div class="mt-5">
                <h1>Joined rooms</h1>
                @if (count($joinRoom) === 0)
                    <p> No roows </p>
                @endif
                @foreach ($joinRoom as $room)
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">{{$room->title}}</h5>
                            <p class="card-text">{{$room->description}}</p>

                            <div class="row">
                                <div class="col-lg-2">
                                    <a href="room/{{$room->url}}" class="btn btn-primary">Go room</a>
                                </div>
                                <div class="col-lg-2">
                                    {!! Form::open(['action' => ['RoomsController@leaveRoom', $room->id], 'method' => 'POST']) !!}
                                        {!! Form::submit('Leave room', ['class' => "btn btn-danger"]) !!}
                                    {!! Form::close() !!}
                                </div>
                            </div>

                            <code>{{$room->created_at}}</code>
                        </div>
                    </div>
                @endforeach
            </div>

    </div>

@endsection
