<?php /*print_r($stats); die;*/ ?>
<script>
    $(function () {
        $('#hps_chart').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Healing / Second Over Time'
            },
            xAxis: {
                categories: [
                    <?php echo $stats['hps_characters']; ?>
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
                    data: <?php echo $stats['hps_values']; ?>
                }
            ]
        });
    });
</script>
