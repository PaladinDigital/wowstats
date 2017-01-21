<?php

use Illuminate\Database\Seeder;
use WoWStats\Models\RaidBoss;

class RaidBossSeeder extends Seeder
{
    public function run()
    {
        $bosses = [
            /* Legion */
            // Emerald Nightmare
            1094 => [
                'Nythendra', // 1st Boss

                'Elerethe Renferal', // 'Spider Boss'
                'Ursoc', // Bear
                'Il\'gynoth, The Heart of Corruption', // Vagina/Eye Boss
                'Dragons of Nightmare',

                'Cenarius',

                'Xavius'
            ],
            // Trial of Valor
            1114 => [
                'Odyn',
                'Guarm',
                'Helya',
            ],
            // The Nighthold
            8025 => [
                'Skorpyron',
                'Chronomatic Anomaly',
                'Trillax',
                'Spellblade Aluriel',

                'Krosus',
                'Star Augur Etraeus',
                "High Botanist Tel'arn",
                'Tichondrius',

                'Grand Magistrix Elisande',
                "Gul'Dan",
            ]
        ];

        foreach ($bosses as $raid_id => $data) {
            foreach ($data as $boss) {
                if (!RaidBoss::exists($raid_id, $boss)) {
                    RaidBoss::create(['raidzone_id' => $raid_id, 'name' => $boss]);
                }
            }
        }
    }
}
