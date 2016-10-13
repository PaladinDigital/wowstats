<?php
$options = [
        'container' => 'dps_chart',
        'title' => 'DPS Over Time',
        'values' => $stats['dps_values']
];
?>@include('highcharts.chart.single_series.line', $options)
