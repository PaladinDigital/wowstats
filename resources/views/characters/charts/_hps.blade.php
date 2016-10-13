<?php
    $options = [
        'container' => 'hps_chart',
        'title' => 'HPS Over Time',
        'values' => $stats['hps_values']
    ];
?>@include('highcharts.chart.single_series.line', $options)
