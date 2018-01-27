@extends($layout)

@section('content')

    <div class="row">
        <div class="col-xs-6 col-md-9">
            <h1>Raid: {{ $raid->zone->name }} ({{ $raid->difficulty() }})</h1>
            <h2>Date: {{ $raid->date }}</h2>
            <h3<?php if ($fight->killed === 1) { echo ' class="killed"'; } ?>>Fight: {{ $fight->boss->name }} @if ($fight->killed === 1) (Kill) @endif</h3>
        </div>
        <div class="col-xs-6 col-md-3">
            @if (isset($user) && $user->isAdmin())
            @component('bootstrap4.components._panel')
                @slot('header')
                    Admin
                @endslot
                @slot('body')

                    @can('administrate')
                        @include('raids.fights.view._lock')

                        @if($fight->locked === 0)
                            @include('raids.fights.view.importStats._button')
                            @include('raids.fights.view.addCharacterStats._button')
                            @include('raids.fights.view.addCharacterStats._modal')
                        @endif
                    @endcan
                @endslot
            @endcomponent
            @endif
        </div>
    </div>





    <?php /* Primary Charts */ ?>

    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12">
            <div id="dps_chart"></div>
        </div>
    </div>

    <div class="row">

        <div class="col-xs-12 col-md-7">
            <div id="hps_chart"></div>
        </div>

        <div class="col-xs-12 col-md-5">
            <div id="damage_taken_chart"></div>
        </div>

    </div>

    <?php /* Stats */ ?>
    <div class="row">
        <div class="col-xs-4">
            <div id="interrupts">
                {!! $interrupts !!}
            </div>
        </div>

        <div class="col-xs-4">
            <div id="dispells">
                {!! $dispells !!}
            </div>
        </div>

        <div class="col-xs-4">
            <div id="deaths">
                {!! $deaths !!}
            </div>
        </div>
    </div>
@endsection

@section('scripts')
<!-- DPS Chart -->
@include('raids.fights.charts._hps')
@include('raids.fights.charts._dtps')
@include('raids.fights.charts._dps')

@include('raids.fights.charts._damage_taken')
@endsection
