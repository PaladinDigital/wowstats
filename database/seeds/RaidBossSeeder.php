<?php

class RaidBossSeeder extends Seeder {

    public function run() {
        $bosses = [
            /* Warlords of Draenor */
            /* Highmaul Bosses */
            //994 => [
            //    'Kargath Bladefist',
            //    'The Butcher',
            //    'Brackenspore (Optional)',
            //    'Tectus (Optional)', // Wing 2
            //    'Twin Ogron', // Wing 2
            //    'Ko’ragh', // Wing 2
            //    'Imperator Mar’gok', // Wing 3
            //],

            /* Legion */
            1094 => [
                'Nythendra', // 1st Boss

                'Elerethe Renferal', // 'Spider Boss'
                'Ursoc', // Bear
                'Il\'gynoth, The Heart of Corruption', // Vagina/Eye Boss
                'Dragons of Nightmare',

                'Cenarius',

                'Xavius'
            ]
        ];

        foreach ($bosses as $raid_id => $data) {
            foreach($data as $boss) {
                RaidBoss::create(['raidzone_id' => $raid_id, 'name' => $boss]);
            }
        }
    }
}
