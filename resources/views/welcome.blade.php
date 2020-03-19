@extends('layouts.app')

@section('content')

    <h1 class="text-center">All Rooms</h1>

    <div class="container">

        <a href="room/create" class="btn btn-primary mt-5"> Create Room  + </a>

        <div class="card mt-5">
            <div class="card-body">
              <h5 class="card-title">Room Name</h5>
              <p class="card-text">Some quick example text to build on the card title and make up the bulk of the card's content.</p>
              <a href="#" class="btn btn-primary">Go room</a>
            </div>
          </div>

    </div>

@endsection
