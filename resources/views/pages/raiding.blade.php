@extends('layouts.app')

@section('content')
    <h1>Raiding Teams</h1>

    <h2>Progression Team</h2>
    <p>Our progression team trailblaze new content to learn the tactics and get boss kills under out belt prior to opening up the raid to the guild raid team.</p>
    @if (isset($progression_team) && !empty($progression_team))
        <h3>Roster</h3>

        @foreach($progression_team as $role => $characters)
            <h4>{{ $role }}</h4>
            <ul>
                @foreach ($characters as $c)
                    <li class="{{ $c->cssClass() }}">{{ $c->name }}</li>
                @endforeach
            </ul>
        @endforeach
    @endif

    <h2>Guild Raid Team</h2>
    <p>The guild raid team raids regularly as well, consists of a large amount of our progression team as well as guild members who want to raid and trial for the progression team.</p>
    @if (isset($raid_team) && !empty($raid_team))
        <h3>Roster</h3>
        @foreach($raid_team as $role => $characters)
            <h4>{{ $role }}</h4>
            <ul>
                @foreach ($characters as $c)
                    <li class="{{ $c->cssClass() }}">{{ $c->name }}</li>
                @endforeach
            </ul>
        @endforeach
    @endif
@endsection
