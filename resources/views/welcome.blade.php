@extends('layouts.app')

@section('content')

    <h1 class="text-center">Welcome Chat App</h1>

    <div class="container">

        <div class="row">
            @foreach ($rooms as $room)
                <div class="card col-lg-6 mt-5">
                    <div class="card-body">
                        <h5 class="card-title">{{$room->title}}</h5>
                        <p class="card-text">{{$room->description}}</p>

                        @if (Auth::check() && $room->user_id !== Auth::id())
                            <form action="addroom" method="post">
                                @csrf
                                <input type="hidden" name="room_id" value="{{$room->id}}">
                                <input type="hidden" name="user_id" value="{{Auth::id()}}">

                                <button type="submit" class="btn btn-primary">Enter Request</button>
                            </form>
                            {{-- <a href="room/{{$room->url}}" class="btn btn-primary">Enter Request</a> --}}
                        @endif
                    </div>
                </div>
            @endforeach
        </div>


    </div>

    {{-- <script src="js/app.js"></script> --}}

@endsection
