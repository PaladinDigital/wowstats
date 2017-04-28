<?php

use Illuminate\Database\Seeder;
use WoWStats\Models\RaidZone;

class RaidZoneSeeder extends Seeder
{
    public function run()
    {
        $zones = [
            /* Warlords of Draenor */
            //994  => 'Highmaul',
            //988  => 'Blackrock Foundry',
            /* Legion */
            1094 => 'The Emerald Nightmare', /* 8026 */
            1114 => 'Trial of Valor',
            8025 => 'The Nighthold',
            8524 => 'Tomb of Sargeras',
        ];

        foreach ($zones as $zid => $name) {
            /* Create Zone if !Exists */
            if (!RaidZone::exists($zid)) {
                RaidZone::create(['id' => $zid, 'name' => $name]);
            }
        }
    }
}
