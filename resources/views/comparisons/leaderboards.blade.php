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
            @endcomponent
        </div>

        <?php /* HPS */ ?>
        <div class="col-xs-12 col-md-6 col-lg-4">
            @component('bootstrap4.components._panel')
                @slot('header')HPS (Top 10)@endslot
                    <table class="table table-striped">
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
            @endcomponent
        </div>

        <?php /* Damage Taken */ ?>
        <div class="col-xs-12 col-md-6 col-lg-4">
            @component('bootstrap4.components._panel')
                @slot('header')Damage Taken (Tanks)@endslot
                <table class="table table-striped">
                    <tbody>
                    @foreach ($dt_leaderboard as $entry)
                        <tr class="{{ $entry['css'] }}">
                            <td>{{ $entry['character'] }}</td>
                            <td>{{ number_format($entry['damage_taken'], 0) }}</td>
                        </tr>
                    @endforeach
                    </tbody>
                </table>
            @endcomponent
        </div>
    </div>
@endsection
