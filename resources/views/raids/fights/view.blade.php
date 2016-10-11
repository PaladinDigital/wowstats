@extends('layouts.app')

@section('content')
    <h1>Raid: {{ $raid->zone->name }}</h1>
    <h2>Date: {{ $raid->date }}</h2>
    <h3<?php if ($fight->killed === 1) { echo ' class="killed"'; } ?>>Fight: {{ $fight->boss->name }} @if ($fight->killed === 1) (Kill) @endif @if ( isset($user) && $user->can('administrate') )<button data-toggle="modal" data-target="#createCharacterStatsModal" class="btn btn-sm btn-primary pull-right">Add Character Stats</button>@endif</h3>
    @if ( isset($user) && $user->can('administrate') )
        @include('raids.fights.view._addCharacterStatsModal')
    @endif

    <div class="row">

    </div>
@endsection
