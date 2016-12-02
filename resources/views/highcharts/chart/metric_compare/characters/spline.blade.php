<?php
// Required Fields: container, title, series, values
// Optional Fields: height, y_title, series_title

// Set defaults
if (!isset($height)) { $height = 400; }
?><script>
    $(function () {
        $('#{{ $container }}').highcharts({
            chart: {
                height: {{ $height }},
                type: 'spline'
            },
            title: {
                text: '{{ $title }}'
            },
            xAxis: {
                categories: {!! $categories !!}
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: '{{ $y_title or '' }}'
                },
            },
            series: {!! $series !!}
        });
    });
</script>
