<script>
    <?php
    $dt_characters = [];
    $dt_values = [];
    foreach($stats as $stat => $data) {
        if ($stat == 'damage_taken') {
            foreach ($data as $s) {
                $dt_characters[] = '"' . $s['character']->name . '"';
                $dt_values[] = (object)[
                    'y' => $s['value'],
                    'color' => $s['character']->classColor()
                ];
            }
        }
    }
    $dt_values = json_encode($dt_values);
    ?>

    $(function () {
        $('#damage_taken_chart').highcharts({
            chart: {
                type: 'column'
            },
            title: {
                text: 'Damage Taken'
            },
            xAxis: {
                categories: [
                    <?php echo join(', ', $dt_characters); ?>
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
                    name: 'Damage Taken',
                    borderColor: '#111',
                    data: <?php echo $dt_values; ?>
                }
            ]
        });
    });
</script>
