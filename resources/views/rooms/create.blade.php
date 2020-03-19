@extends('layouts.app')

@section('content')

    <div class="container">

        {!! Form::open(['action' => 'RoomsController@store', 'method' => 'POST']) !!}

            <div class="form-group">
                {!! Form::label('titleFor', 'Title') !!}
                {!! Form::text('title', '', ['class' => 'form-control', 'id' => 'titleFor', 'placeholder' => 'Enter title']) !!}

                @if ($errors->has('title'))
                    <small class="form-text text-danger">{{$errors->first('title')}}</small>
                @endif
            </div>

            <div class="form-group">
                {!! Form::label('descriptionFor', 'Description') !!}
                {!! Form::textarea('description', '', ['class' => 'form-control', 'id' => 'descriptionFor', 'placeholder' => 'Enter description']) !!}

                @if ($errors->has('description'))
                    <small class="form-text text-danger">{{$errors->first('description')}}</small>
                @endif
            </div>

            {!! Form::submit('Submit', ['class' => 'btn btn-primary']) !!}

        {!! Form::close() !!}

    </div>

@endsection
