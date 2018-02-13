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
        type: 'column'
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
      plotOptions: {
        column: {
          pointPadding: 0,
          borderWidth: 0
        }
      },
      series: {!! $series !!}
    });
  });
</script>
