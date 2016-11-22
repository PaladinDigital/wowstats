@extends('layouts.app')

@section('content')
    <h1 class="{{ $character->cssClass() }}">{{ $character->name }}
        @include('characters.claim._button')</h1>
    <p>Main Spec: {{ $character->mainSpec() }}, Off-Spec: {{ $character->offSpec() }}</p>

    <?php
        // Set variables as default if not set.
        $heal_chart_heights = 0;
        $dps_chart_heights = 0;
        $tank_chart_heights = 0;
        switch($character->mainSpec()) {
            case 'Healer':
                $primary_chart_1 = 'hps_chart';
                $primary_chart_2 = 'healing_chart';
                $heal_chart_heights = 400;
                break;
            case 'DPS':
                $primary_chart_1 = 'dps_chart';
                $primary_chart_2 = 'damage_chart';
                $dps_chart_heights = 400;
                break;
            case 'Tank':
                $primary_chart_1 = 'dtps_chart';
                $primary_chart_2 = 'damage_taken_chart';
                $tank_chart_heights = 400;
                break;
            default:
                $primary_chart_1 = '';
                $primary_chart_2 = '';
                break;
        }
        switch($character->offSpec()) {
            case 'Healer':
                $secondary_chart_1 = 'hps_chart';
                $secondary_chart_2 = 'healing_chart';
                $heal_chart_heights = 200;
                break;
            case 'DPS':
                $secondary_chart_1 = 'dps_chart';
                $secondary_chart_2 = 'damage_chart';
                $dps_chart_heights = 200;
                break;
            case 'Tank':
                $secondary_chart_1 = 'dtps_chart';
                $secondary_chart_2 = 'damage_taken_chart';
                $tank_chart_heights = 200;
                break;
            default:
                $secondary_chart_1 = '';
                $secondary_chart_2 = '';
                break;
        }
    ?>

    <?php /* Primary Charts */ ?>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div id="{{ $primary_chart_1 }}"></div>
        </div>

        <div class="col-xs-12 col-md-6">
            <div id="{{ $primary_chart_2 }}"></div>
        </div>
    </div>

    <?php /* Secondary Charts */ ?>
    <div class="row">
        <div class="col-xs-12 col-md-6">
            <div id="{{ $secondary_chart_1 }}"></div>
        </div>

        <div class="col-xs-12 col-md-6">
            <div id="{{ $secondary_chart_2 }}"></div>
        </div>
    </div>
@endsection

@section('scripts')
    <?php
    // Chart Defaults
    $borderColor = '#111';
    ?>
    @include('characters.charts._hps',     ['height' => $heal_chart_heights])
    @include('characters.charts._healing', ['height' => $heal_chart_heights])

    @include('characters.charts._dps',    ['height' => $dps_chart_heights])
    @include('characters.charts._damage', ['height' => $dps_chart_heights])

    @include('characters.charts._dtps',         ['height' => $tank_chart_heights])
    @include('characters.charts._damage_taken', ['height' => $tank_chart_heights])
@endsection
