<script>
    <?php var_dump($stats); die; ?>
    $(function () {
        $('#hps_chart').highcharts({
            title: {
                text: 'Fight HPS'
            },
            xAxis: {
                categories: [
                    {!! $hps_characters !!}
                ]
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'HPS'
                },
            },
            series: [
                {
                    showInLegend: false,
                    name: 'HPS',
                    borderColor: '#111',
                    color: '<?php echo $class_color; ?>',
                    data: <?php echo $hps_values; ?>
                }
            ]
        });
    });
</script>
