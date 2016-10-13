<script>
    $(function () {
        $('#damage_chart').highcharts({
            chart: {
                type: 'column',
                height: 250
            },
            title: {
                text: 'Fight Damage'
            },
            xAxis: {
                categories: [
                    <?php echo $stats['damage_characters']; ?>
                ]
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'damage'
                },
            },
            series: [
                {
                    showInLegend: false,
                    name: 'Damage Done',
                    borderColor: '#111',
                    data: <?php echo $stats['damage_values']; ?>
                }
            ]
        });
    });
</script>
