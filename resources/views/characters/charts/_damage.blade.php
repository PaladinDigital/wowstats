<?php
$options = [
        'container' => 'damage_chart',
        'title' => 'Damage - Over Time',
        'values' => $stats['damage_values']
];
?>@include('highcharts.chart.single_series.line', $options)
