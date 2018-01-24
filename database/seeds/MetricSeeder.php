<?php

use Illuminate\Database\Seeder;
use WoWStats\Models\Metric;

class MetricSeeder extends Seeder
{
    public function run()
    {
        $metrics = [
            'healing',
            'hps', // This is effective HPS (excluding overheal).
            'damage',
            'dps',
            'damage_taken',
            'dtps',
            'dispells',
            'interrupts',
            'deaths',
            'hps_raw', // Raw HPS (including overheal).
            'item_level',
        ];

        foreach ($metrics as $metric) {
            Metric::createIfNotExist($metric);
        }
    }
}
