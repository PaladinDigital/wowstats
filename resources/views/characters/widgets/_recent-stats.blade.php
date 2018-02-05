@component('bootstrap4.components._panel')
    @slot('header')
        Stats: Recent Fights (Last 10 Fights)
    @endslot
    <ul class="list-group list-group-flush">

        @if ($recentStats['deaths'] > 0)
            <li class="list-group-item">Deaths: {{ $recentStats['deaths'] }}</li>
        @endif

        @if (array_key_exists('average_hps', $recentStats))
            <li class="list-group-item">Average HPS: {{ $recentStats['average_hps'] }}</li>
        @endif
        @if (array_key_exists('max_hps', $recentStats))
            <li class="list-group-item">Max HPS: {{ $recentStats['max_hps'] }}</li>
        @endif

        @if (array_key_exists('average_dps', $recentStats))
            <li class="list-group-item">Average DPS: {{ $recentStats['average_dps'] }}</li>
        @endif
        @if (array_key_exists('max_dps', $recentStats))
            <li class="list-group-item">Max DPS: {{ $recentStats['max_dps'] }}</li>
        @endif

        @if (array_key_exists('average_dtps', $recentStats) && $recentStats['average_dtps'] > 0)
            <li class="list-group-item">Average DTPS: {{ $recentStats['average_dtps'] }}</li>
        @endif
    </ul>
@endcomponent