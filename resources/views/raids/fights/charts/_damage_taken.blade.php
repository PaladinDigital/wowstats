<script>
    $(function () {
        $('#damage_taken_chart').highcharts({
            chart: {
                type: 'column',
                height: 250
            },
            title: {
                text: 'Damage Taken'
            },
            xAxis: {
                categories: [
                    <?php echo $stats['damage_taken_characters']; ?>
                ]
            },
            yAxis: {
                allowDecimals: false,
                title: {
                    text: 'Damage Taken'
                },
            },
            series: [
                {
                    showInLegend: false,
                    name: 'Damage Taken',
                    borderColor: '#111',
                    data: <?php echo $stats['damage_taken_values']; ?>
                }
            ]
        });
    });
</script>
