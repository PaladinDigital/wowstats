<script>
    $(function () {
        $('#dtps_chart').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Damage Taken / Second'
            },
            xAxis: {
                categories: [
                    <?php echo $stats['dtps_characters']; ?>
                ]
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'DTPS'
                },
            },
            series: [
                {
                    showInLegend: false,
                    name: 'Damage Done',
                    borderColor: '#111',
                    data: <?php echo $stats['dtps_values']; ?>
                }
            ]
        });
    });
</script>
