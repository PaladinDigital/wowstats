<script>
    $(function () {
        $('#dps_chart').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Fight DPS'
            },
            xAxis: {
                categories: [
                    <?php echo $stats['dps_characters']; ?>
                ]
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'DPS'
                },
            },
            series: [
                {
                    showInLegend: false,
                    name: 'DPS',
                    borderColor: '#111',
                    data: <?php echo $stats['dps_values']; ?>
                }
            ]
        });
    });
</script>
