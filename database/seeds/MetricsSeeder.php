<?php

use Illuminate\Database\Seeder;
use WoWStats\Models\Metric;

class MetricsSeeder extends Seeder
{
    public function run() {
        $metrics = [
            'healing',
            'hps',
            'damage',
            'dps',
            'damage_taken',
            'dtps',
        ];

        foreach ($metrics as $metric) {
            Metric::createIfNotExist(['name' => $metric]);
        }
    }
}
