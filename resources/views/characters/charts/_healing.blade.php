<?php
$options = [
    'container' => 'healing_chart',
    'title' => 'Healing Over Time',
    'values' => $stats['healing_values']
];
?>@include('highcharts.chart.single_series.line', $options)
