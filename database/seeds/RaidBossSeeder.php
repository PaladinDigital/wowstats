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
                102672 => 'Nythendra', // 1st Boss
                106087 => 'Elerethe Renferal', // 'Spider Boss'
                100497 => 'Ursoc', // Bear
                105393 => "Il\'gynoth, The Heart of Corruption", // Vagina/Eye Boss
                102679 => 'Dragons of Nightmare',
                104636 => 'Cenarius',
                103769 => 'Xavius',
            ],
            // Trial of Valor
            1114 => [
                114263 => 'Odyn',
                114537 => 'Guarm',
                114344 => 'Helya',
            ],
            // The Nighthold
            8025 => [
                102263 => 'Skorpyron',
                104415 => 'Chronomatic Anomaly',
                104288 => 'Trilliax',
                107699 => 'Spellblade Aluriel',

                101002 => 'Krosus',
                103758 => 'Star Augur Etraeus',
                104528 => "High Botanist Tel'arn",
                103685 => 'Tichondrius',

                110965 => 'Grand Magistrix Elisande',
                105503 => "Gul'Dan",
            ],
            // Tomb of Sargeras
            8524 => [
                115844 => 'Goroth',
                120996 => 'Demonic Inquisition',
                116407 => 'Harjatan',
                118523 => 'Sisters of the Moon',
                115767 => "Mistress Sassz'ine",
                118460 => 'The Desolate Host',
                118289 => 'Maiden of Vigilance',
                120436 => 'Fallen Avatar',
                117269 => "Kil'jaeden",
            ],
            // Antorus
            8638 => [
                123371 => 'Garothi Worldbreaker',
                126916 => 'Felhounds of Sargeras',
                122367 => 'Antoran High Command',
                131561 => 'Eonar the Life-Binder',
                124393 => 'Portal Keeper Hasabel',

                125055 => 'Imonar the Soulhunter',
                125050 => "Kin'garoth",

                125075 => 'Varimathras',
                122468 => 'The Coven of Shivarra',
                124691 => 'Aggramar',
                124828 => 'Argus the Unmaker',
            ]
        ];

        foreach ($bosses as $raid_id => $data) {
            foreach ($data as $bossId => $boss) {
                if (!RaidBoss::exists($raid_id, $boss)) {
                    RaidBoss::create([
                        'id' => $bossId,
                        'raidzone_id' => $raid_id,
                        'name' => $boss
                    ]);
                }
            }
        }
    }
}
