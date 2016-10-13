@extends('layouts.app')

@section('content')
    <h1 class="{{ $character->cssClass() }}">{{ $character->name }}</h1>
    <p>Main Spec: {{ $character->mainSpec() }}, Off-Spec: {{ $character->offSpec() }}</p>

    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div id="hps_chart"></div>
        </div>

        <div class="col-xs-12 col-md-6">
            <div id="damage_taken_chart"></div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-12">
            <div id="dps_chart"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <?php
    // Chart Defaults
    $borderColor = '#111';
    ?>
    @include('characters.charts._dps')
    @include('characters.charts._hps')
    @include('characters.charts._damage_taken')
@endsection
