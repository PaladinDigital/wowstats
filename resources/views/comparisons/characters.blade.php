@extends($layout)

@section('content')
@if (isset($hps_comparison))
    <div id="hps_comparison"></div>
@endif
@if (isset($tank_comparison))
    <div id="tank_comparison"></div>
@endif
@if (isset($dps_comparison))
    <div id="dps_comparison"></div>
@endif
<?php
$data = [];
    $data['height'] = 600;
    if (isset($hps_comparison)) {
        $data['container'] = 'hps_comparison';
        $data['title'] = 'HPS Comparison';
        $data['categories'] = $hps_comparison['categories'];
        $data['series'] = $hps_comparison['series'];
    } elseif (isset($tank_comparison)) {
        $data['container'] = 'tank_comparison';
        $data['title'] = 'DTPS Comparison';
        $data['categories'] = $dtps_comparison['categories'];
        $data['series'] = $dtps_comparison['series'];
    } elseif (isset($dps_comparison)) {
        $data['container'] = 'dps_comparison';
        $data['title'] = 'DPS Comparison';
        $data['categories'] = $dps_comparison['categories'];
        $data['series'] = $dps_comparison['series'];
    }
?>
@endsection

@section('scripts')
    @if (isset($data['container']))
        @include('highcharts.chart.metric_compare.characters.spline', $data)
    @endif
@endsection