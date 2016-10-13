<script>
    <?php
    $hps_characters = [];
    $hps_values = [];
    foreach($stats as $stat => $data) {
        if ($stat == 'hps') {
            foreach ($data as $s) {
                $hps_characters[] = '"' . $s['character']->name . '"';
                $hps_values[] = (object)[
                    'y' => $s['value'],
                    'color' => $s['character']->classColor()
                ];
            }
        }
    }
    $hps_values = json_encode($hps_values);
    ?>

    $(function () {
        $('#hps_chart').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Fight HPS'
            },
            xAxis: {
                categories: [
                    <?php echo join(', ', $hps_characters); ?>
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
                    name: 'HPS',
                    data: <?php echo $hps_values; ?>
                }
            ]
        });
    });
</script>
