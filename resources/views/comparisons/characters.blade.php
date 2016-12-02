@extends('layouts.app')

@section('content')
@if (isset($hps_comparison))
    <div id="hps_comparison"></div>

    <?php $data = [
        'container' => 'hps_comparison',
        'title' => 'HPS Comparison',
        'categories' => $hps_comparison['categories'],
        'series' => $hps_comparison['series'],
    ]; ?>
@endif
@endsection

@section('scripts')
    @include('highcharts.chart.metric_compare.characters.spline', $data)
@endsection