<script>
    $(function () {
        $('#dps_chart').highcharts({
            title: {
                text: 'DPS Over Time'
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
