<script>
    $(function () {
        $('#dtps_chart').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Damage Taken / Second Over time'
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
