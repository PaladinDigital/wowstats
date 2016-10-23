@extends('layouts.app')

@section('content')
    <h1>Raid: {{ $raid->zone->name }} ({{ $raid->difficulty() }})</h1>
    <h2>Date: {{ $raid->date }}</h2>
    <h3<?php if ($fight->killed === 1) { echo ' class="killed"'; } ?>>Fight: {{ $fight->boss->name }} @if ($fight->killed === 1) (Kill) @endif @if ( isset($user) && $user->can('administrate') )<button data-toggle="modal" data-target="#createCharacterStatsModal" class="btn btn-sm btn-primary pull-right">Add Character Stats</button>@endif</h3>
    @if ( isset($user) && $user->can('administrate') )
        @include('raids.fights.view._addCharacterStatsModal')
    @endif

    <?php /* Primary Charts */ ?>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div id="hps_chart"></div>
        </div>

        <div class="col-xs-12 col-md-6">
            <div id="dtps_chart"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div id="dps_chart"></div>
        </div>
    </div>

    <?php /* Secondary Charts */ ?>
    <div class="row">
        <div class="col-xs-12 col-md-4">
            <div id="healing_chart"></div>
        </div>

        <div class="col-xs-12 col-md-4">
            <div id="damage_chart"></div>
        </div>

        <div class="col-xs-4">
            <div id="damage_taken_chart"></div>
        </div>
    </div>
@endsection

@section('scripts')
<!-- DPS Chart -->
@include('raids.fights.charts._hps')
@include('raids.fights.charts._dtps')
@include('raids.fights.charts._dps')

@include('raids.fights.charts._healing')
@include('raids.fights.charts._damage_taken')
@include('raids.fights.charts._damage')
@endsection
