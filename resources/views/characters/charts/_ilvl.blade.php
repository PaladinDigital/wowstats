<?php
$options = [
    'container' => 'ilvl_chart',
    'title' => 'Item Level',
    'values' => $stats['item_level_values']
];
?>@include('highcharts.chart.single_series.line', $options)
