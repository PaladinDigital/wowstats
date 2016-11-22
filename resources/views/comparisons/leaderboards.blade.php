@extends('layouts.app')

@section('content')
    <h1>Leaderboards</h1>

    <?php /* DPS */ ?>
    <div class="col-xs-12 col-md-6 col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">DPS</div>
            <div class="panel-body">
                <table class="table">
                    <tbody>
                    @foreach ($dps_leaderboard as $entry)
                        <tr class="{{ $entry['character']->cssClass() }}">
                            <td>{{ $entry['character']->name }}</td>
                            <td>{{ $entry['dps'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>

    </div>

    <?php /* HPS */ ?>
    <div class="col-xs-12 col-md-6 col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">HPS</div>
            <div class="panel-body">
                <table class="table">
                    <tbody>
                    @foreach ($hps_leaderboard as $entry)
                        <tr class="{{ $entry['character']->cssClass() }}">
                            <td>{{ $entry['character']->name }}</td>
                            <td>{{ $entry['hps'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

    <?php /* Damage Taken */ ?>
    <div class="col-xs-12 col-md-6 col-lg-4">
        <div class="panel panel-default">
            <div class="panel-heading">Damage Taken</div>
            <div class="panel-body">
                <table class="table">
                    <tbody>
                    @foreach ($dt_leaderboard as $entry)
                        <tr class="{{ $entry['character']->cssClass() }}">
                            <td>{{ $entry['character']->name }}</td>
                            <td>{{ $entry['damage_taken'] }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>

@endsection
