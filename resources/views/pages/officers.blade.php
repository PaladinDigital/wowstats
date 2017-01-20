@extends('layouts.app')

@section('content')
    <h1>Officers</h1>

    @foreach($officers as $officer)
        <div class="officer">
            <h2>{{ $officer->name }}</h2>
        </div>
    @endforeach
@endsection
