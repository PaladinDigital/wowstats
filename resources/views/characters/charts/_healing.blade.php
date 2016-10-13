<?php /*print_r($stats); die;*/ ?>
<script>
    $(function () {
        $('#healing_chart').highcharts({
            chart: {
                type: 'column',
                height: 250
            },
            title: {
                text: 'Healing Done Over Time'
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Healing'
                },
            },
            series: [
                {
                    showInLegend: false,
                    name: 'Healing',
                    borderColor: '#111',
                    data: <?php echo $stats['healing_values']; ?>
                }
            ]
        });
    });
</script>
