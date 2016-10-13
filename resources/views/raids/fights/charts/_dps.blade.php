<script>
    <?php
    $dps_characters = [];
    $dps_values = [];
    foreach($stats as $stat => $data) {
        if ($stat == 'dps') {
            foreach ($data as $s) {
                $dps_characters[] = '"' . $s['character']->name . '"';
                $dps_values[] = (object)[
                    'y' => $s['value'],
                    'color' => $s['character']->classColor()
                ];
            }
        }
    }
    $dps_values = json_encode($dps_values);
    ?>

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
                    <?php echo join(', ', $dps_characters); ?>
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
                    data: <?php echo $dps_values; ?>
                }
            ]
        });
    });
</script>
