<?php
$options = [
        'container' => 'damage_taken_chart',
        'title' => 'Damage Taken - Over Time',
        'values' => $stats['damage_taken_values']
];
?>@include('highcharts.chart.single_series.line', $options)
