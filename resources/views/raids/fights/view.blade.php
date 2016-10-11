@extends('layouts.app')

@section('content')
    <h1>Raid: {{ $raid->zone->name }}</h1>
    <h2>Date: {{ $raid->date }}</h2>
    <h3>Fight: {{ $fight->boss->name }} @if ($fight->killed === 1) (Kill) @endif</h3>

    <div class="row">

    </div>
@endsection
