@extends($layout)

@section('content')
    <h1>Leaderboards</h1>

    <div class="row">
        <?php /* DPS */ ?>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">DPS (Top 10)</div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                        <?php $i = 0; ?>
                        @foreach ($dps_leaderboard as $entry)
                            @if ($i < 10)
                                <tr class="{{ $entry['css'] }}">
                                    <td>{{ $entry['character'] }}</td>
                                    <td>{{ number_format($entry['dps'], 0) }}</td>
                                </tr>
                                <?php $i++; ?>
                            @endif
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>

        </div>

        <?php /* HPS */ ?>
        <div class="col-xs-12 col-md-6 col-lg-4">
            <div class="panel panel-default">
                <div class="panel-heading">HPS (Top 10)</div>
                <div class="panel-body">
                    <table class="table">
                        <tbody>
                        <?php $h = 0; ?>
                        @foreach ($hps_leaderboard as $entry)
                            @if ($h < 10)
                                <tr class="{{ $entry['css'] }}">
                                    <td>{{ $entry['character'] }}</td>
                                    <td>{{ number_format($entry['hps'], 0) }}</td>
                                </tr>
                                <?php $h++; ?>
                            @endif
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
                            <tr class="{{ $entry['css'] }}">
                                <td>{{ $entry['character'] }}</td>
                                <td>{{ number_format($entry['damage_taken'], 0) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>

@endsection
