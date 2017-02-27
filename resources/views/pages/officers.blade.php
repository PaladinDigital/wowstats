@extends('layouts.app')

@section('content')
    <h1>Officers</h1>

    @foreach($officers as $officer)
        <div class="officer">
            <img src="{{ asset('images/characters/' . $officer->name . '.jpg') }}" width="370">
            <h2 class="{{ $officer->cssClass }}">{{ $officer->name }} <small>Rank: {{ $officer->rank or '' }}</small></h2>
            <p>{{ $officer->description }}</p>
        </div>
    @endforeach
@endsection
