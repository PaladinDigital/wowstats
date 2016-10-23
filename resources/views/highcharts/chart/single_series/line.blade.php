<?php
// Required Fields: container, title, series, values
// Optional Fields: height, y_title, series_title

// Set defaults
if (!isset($height)) { $height = 400; }
?><script>
    $(function () {
        $('#{{ $container }}').highcharts({
            chart: {
                height: {{ $height }}
            },
            title: {
                text: '{{ $title }}'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: '{{ $y_title or '' }}'
                },
            },
            series: [
                {
                    <?php if (isset($character)): ?>
                    color: '<?php echo $character->classColor(); ?>',
                    <?php endif; ?>
                    showInLegend: false,
                    name: '{{ $series_title or '' }}',
                    borderColor: '#111',
                    data: <?php echo $values ?>
                }
            ]
        });
    });
</script>
