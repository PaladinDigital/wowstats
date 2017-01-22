@extends('layouts.app')

@section('content')
    <h1>Officers</h1>

    @foreach($officers as $officer)
        <div class="officer">
            <h2 class="{{ $officer->cssClass }}">{{ $officer->name }}</h2>
            <p>{{ $officer->description }}</p>
        </div>
    @endforeach
@endsection
