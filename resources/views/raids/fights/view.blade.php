@extends('layouts.app')

@section('content')
    <h1>Raid: {{ $raid->zone->name }} ({{ $raid->difficulty() }}) @include('raids.fights.view._lock')</h1>
    <h2>Date: {{ $raid->date }}</h2>
    <h3<?php if ($fight->killed === 1) { echo ' class="killed"'; } ?>>Fight: {{ $fight->boss->name }} @if ($fight->killed === 1) (Kill) @endif @include('raids.fights.view.addCharacterStats._button')</h3>
    @if ( isset($user) && $user->can('administrate') && ($fight->locked === 0) )
        @include('raids.fights.view.addCharacterStats._modal')
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

    <?php /* Stats */ ?>
    <div class="row">
        <div class="col-xs-4">
            <div id="interrupts">
            </div>
        </div>

        <div class="col-xs-4">
            <div id="dispells">

            </div>
        </div>

        <div class="col-xs-4">
            <div id="deaths">
                {{ var_dump($deaths) }}
            </div>
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
