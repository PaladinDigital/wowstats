<?php

class RaidZoneSeeder extends Seeder {

    public function run() {
        $zones = [
            /* Warlords of Draenor */
            //994  => 'Highmaul',
            //988  => 'Blackrock Foundry',
            /* Legion */
            1088 => 'The Nighthold',
            1094 => 'The Emerald Nightmare',
        ];

        foreach ($zones as $zid => $name) {
            /* Create Zone if !Exists */
            if (!RaidZone::exists($zid)) {
                RaidZone::create(['id' => $zid, 'zone_name' => $name]);
            }

        }
    }
}
