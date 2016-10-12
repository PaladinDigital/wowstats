@extends('layouts.app')

@section('content')
    <h1>Raid: {{ $raid->zone->name }}</h1>
    <h2>Date: {{ $raid->date }}</h2>
    <h3<?php if ($fight->killed === 1) { echo ' class="killed"'; } ?>>Fight: {{ $fight->boss->name }} @if ($fight->killed === 1) (Kill) @endif @if ( isset($user) && $user->can('administrate') )<button data-toggle="modal" data-target="#createCharacterStatsModal" class="btn btn-sm btn-primary pull-right">Add Character Stats</button>@endif</h3>
    @if ( isset($user) && $user->can('administrate') )
        @include('raids.fights.view._addCharacterStatsModal')
    @endif

    <!-- Display each stats -->
    @foreach($stats as $stat => $data)
        @if (count($data) > 0)
            <div class="col-xs-12 col-sm-6 col-md-4">
            <div class="panel panel-default">
                <div class="panel-heading">{{ $stat }}</div>
                <div class="panel-body">
                    <ul>
                    @foreach($data as $s)
                    <li >{{ $s['character']->name }} - {{ $s['value'] }}</li>
                    @endforeach
                    </ul>
                </div>
            </div>
            </div>
        @endif
    @endforeach

    <div class="row">
    </div>
@endsection
