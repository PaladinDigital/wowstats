<?php
$options = [
        'container' => 'dtps_chart',
        'title' => 'Damage Taken / Second - Over Time',
        'values' => $stats['dtps_values']
];
?>@include('highcharts.chart.single_series.line', $options)
