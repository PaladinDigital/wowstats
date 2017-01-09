<?php

use Illuminate\Database\Seeder;
use WoWStats\Models\Metric;

class MetricSeeder extends Seeder
{
    public function run()
    {
        $metrics = [
            'healing',
            'hps',
            'damage',
            'dps',
            'damage_taken',
            'dtps',
            'dispells',
            'interrupts',
            'deaths'
        ];

        foreach ($metrics as $metric) {
            Metric::createIfNotExist($metric);
        }
    }
}
