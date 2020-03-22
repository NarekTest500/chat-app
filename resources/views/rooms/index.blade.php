@extends('layouts.app')

@section('content')

    <h1 class="text-center">My Rooms</h1>

    <div class="container">

        <a href="room/create" class="btn btn-primary mt-5"> Create Room  + </a>

        <div class="row">

            <div class="col-lg-6 mt-5">
                <h1>Joined rooms</h1>
                @if (count($joinRoom) === 0)
                    <p> No roows </p>
                @endif
                @foreach ($joinRoom as $room)
                    <div class="card mt-3">
                        <div class="card-body">
                            <h5 class="card-title">{{$room[0]->title}}</h5>
                            <p class="card-text">{{$room[0]->description}}</p>

                            <div class="row">
                                <div class="col-lg-6">
                                    <a href="room/{{$room[0]->url}}" class="btn btn-primary">Go room</a>
                                </div>
                                <div class="col-lg-6">
                                    {!! Form::open(['action' => ['RoomsController@leaveRoom', $room[0]->id], 'method' => 'POST']) !!}
                                        {!! Form::submit('Leave room', ['class' => "btn btn-danger"]) !!}
                                    {!! Form::close() !!}
                                    {{-- <a href="room/{{$room[0]->url}}" ></a> --}}
                                </div>
                            </div>

                            <code>{{$room[0]->created_at}}</code>
                        </div>
                    </div>
                @endforeach
            </div>

            {{-- <div class="col-lg-6 border border-secondary mt-5">

                <h1>Own rooms</h1>
                @if (count($authRooms) > 0)
                    @foreach ($authRooms as $auth)
                        <div class="card mt-3">
                            <div class="card-body">
                                <h5 class="card-title">{{$auth->title}}</h5>
                                <p class="card-text">{{$auth->description}}</p>
                                <a href="room/{{$auth->url}}" class="btn btn-primary">Go room</a>
                                <code>{{$auth->created_at}}</code>
                            </div>
                        </div>
                    @endforeach

                    @else

                    <p>No own room</p>

                @endif
            </div> --}}

        </div>

    </div>

@endsection
