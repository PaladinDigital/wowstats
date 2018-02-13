@extends($layout)

@section('content')
    <h1>Leaderboards</h1>

    <div class="row">
        <?php /* DPS */ ?>
        <div class="col-xs-12 col-md-6 col-lg-4">
            @component('bootstrap4.components._panel')
                @slot('header')DPS (Top 10)@endslot
                    <table class="table table-striped">
                        <tbody>
                        <?php $i = 0; ?>
                        @foreach ($dps_leaderboard as $entry)
                            @if($i < 10)
                            <?php
                            $data = [
                                'rowClass' => $entry['css'],
                                'counter' => $i+1,
                                'character' => $entry['character'],
                                'characterUrl' => route('character.view', $entry['character']),
                                'value' => number_format($entry['dps'], 0)
                            ];
                            $i++;
                            ?>
                            @include('comparisons.leaderboards._metricEntry', $data)
                            @endif
                        @endforeach
                        </tbody>
                    </table>
            @endcomponent
        </div>

        <?php /* HPS */ ?>
        <div class="col-xs-12 col-md-6 col-lg-4">
            @component('bootstrap4.components._panel')
                @slot('header')HPS (Top 10)@endslot
                    <table class="table table-striped">
                        <tbody>
                        <?php $i = 0; ?>

                        @foreach ($hps_leaderboard as $entry)
                        @if($i < 10)
                            <?php
                            $data = [
                            'rowClass' => $entry['css'],
                            'counter' => $i+1,
                            'character' => $entry['character'],
                            'characterUrl' => route('character.view', $entry['character']),
                            'value' => number_format($entry['hps'], 0)
                            ];
                            $i++;
                            ?>
                            @include('comparisons.leaderboards._metricEntry', $data)
                        @endif
                        @endforeach
                        </tbody>
                    </table>
            @endcomponent
        </div>

        <?php /* Damage Taken */ ?>
        <div class="col-xs-12 col-md-6 col-lg-4">
            @component('bootstrap4.components._panel')
                @slot('header')Damage Taken (Tanks)@endslot
                <table class="table table-striped">
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach ($dt_leaderboard as $entry)
                        @if($i < 10)
                            <?php
                            $data = [
                            'rowClass' => $entry['css'],
                            'counter' => $i+1,
                            'character' => $entry['character'],
                            'characterUrl' => route('character.view', $entry['character']),
                            'value' => number_format($entry['damage_taken'], 0)
                            ];
                            $i++;
                            ?>
                            @include('comparisons.leaderboards._metricEntry', $data)
                        @endif
                    @endforeach
                    </tbody>
                </table>
            @endcomponent
        </div>
    </div>

    <div class="row">
        <?php /* Deaths */ ?>
        <div class="col-xs-12 col-md-6 col-lg-4">
            @component('bootstrap4.components._panel')
                @slot('header')Deaths (Top 10) [Includes Wipes]@endslot
                <table class="table table-striped">
                    <tbody>
                    <?php $i = 0; ?>
                    @foreach ($death_leaderboard as $entry)
                        @if($i < 10)
                            <?php
                            $data = [
                            'rowClass' => $entry['css'],
                            'counter' => $i+1,
                            'character' => $entry['character'],
                            'characterUrl' => route('character.view', $entry['character']),
                            'value' => number_format($entry['deaths'], 0)
                            ];
                            $i++;
                            ?>
                            @include('comparisons.leaderboards._metricEntry', $data)
                        @endif
                    @endforeach
                    </tbody>
                </table>
            @endcomponent
        </div>
    </div>
@endsection
