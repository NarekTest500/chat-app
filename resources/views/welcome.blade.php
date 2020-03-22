@extends('layouts.app')

@section('content')

    <h1 class="text-center">Welcome Chat App</h1>

    <div class="container">

        <div class="row">
            @foreach ($array as $room)
                <div class="card col-lg-6 mt-5">
                    <div class="card-body">
                        <h5 class="card-title">{{$room->title}}</h5>
                        <p class="card-text">{{$room->description}}</p>

                        @if (Auth::check())
                            <form action="addroom" method="post">
                                @csrf
                                <input type="hidden" name="room_id" value="{{$room->id}}">
                                <input type="hidden" name="user_id" value="{{Auth::id()}}">

                                <button type="submit" class="btn btn-primary">Enter Request</button>
                            </form>
                        @endif
                    </div>
                </div>
            @endforeach
        </div>


    </div>

@endsection
