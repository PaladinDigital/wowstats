<?php namespace WoWStats\Http\Controllers;

use WoWStats\Models\Character;

class PageController extends Controller
{
    public $characters;

    public function __construct()
    {
        $healers = [
            'Sniperdrood',
            'Zonraja', 'Locutor',
        ];
        $tanks = [ 'Nuuruhuine', 'Wulfar' ];

        $progression_dps = [
            'Murmundamus', 'Wolirraw',
            'Zenjaquin', 'Vagrasis', 'Labobbob', 'Phanotos', 'Bananael',
            'Glasha', 'Xquall'
        ];

        $raid_dps = [
            'Azkadélia',
            'Bonny',
            'Euphi',
        ];

        $raid_tanks = [
            'Glasha',
            'Snipedin',
        ];

        $this->characters = [
            'tanks'           => Character::whereIn('name', $tanks)->get(),
            'healers'         => Character::whereIn('name', $healers)->get(),
            'progression_dps' => Character::whereIn('name', $progression_dps)->get(),
            'raid_dps'        => Character::whereIn('name', $raid_dps)->get(),
            'raid_tanks'      => Character::whereIn('name', $raid_tanks)->get(),
        ];
    }

    public function raiding()
    {
        $data = [
            'progression_team' => [
                /* Officers */
                'Tanks'   => $this->characters['tanks'],
                'Healers' => $this->characters['healers'],
                'DPS'     => $this->characters['progression_dps'],
            ],
            'raid_team' => [
                'DPS'     => $this->characters['raid_dps'],
            ],
        ];

        return $this->page('raiding', $data);
    }

    public function officers()
    {
        $data = [
            'officers' => [
                (object)[
                    'name' => 'Wolirraw',
                    'class' => 'Hunter', 'cssClass' => 'hunter',
                    'rank' => 'Overlord',
                    'description' => 'Guild Master',
                ],
                (object)[
                    'name' => 'Nuuruhuine',
                    'class' => 'Death Knight', 'cssClass' => 'death_knight',
                    'rank' => 'Warlord',
                    'description' => 'Guild Tank',
                ],
                (object)[
                    'name' => 'Murmundamus',
                    'class' => 'Warlock', 'cssClass' => 'warlock',
                    'rank' => 'Warlord',
                    'description' => 'Raid Leader',
                ],
                (object)[
                    'name' => 'Sniperdrood', 'class' => 'Druid', 'cssClass' => 'druid',
                    'rank' => 'Officer',
                    'description' => 'Healer',
                ],
                (object)[
                    'name' => 'Wulfar',
                    'class' => 'Druid', 'cssClass'  => 'druid',
                    'rank' => 'Officer',
                    'description' => 'Guild Tank',
                ],
                (object)[
                    'name' => 'Labobbob',
                    'class' => 'Death Knight', 'cssClass' => 'death_knight',
                    'rank' => 'Officer',
                    'description' => 'Frost DPS',
                ],
            ]
        ];
        return $this->page('officers', $data);
    }

    public function progression()
    {
        // 7.0.0
        $emeraldNightmare = [
            "Xavius"                         => ['n' => true, 'h' => true, 'm' => false],
            "Cenarius"                       => ['n' => true, 'h' => true, 'm' => false],
            "Elerethe Renferal"              => ['n' => true, 'h' => true, 'm' => false],
            "Il'gynoth, Heart of Corruption" => ['n' => true, 'h' => true, 'm' => false],
            "Dragons of Nightmare"           => ['n' => true, 'h' => true, 'm' => false],
            "Ursoc"                          => ['n' => true, 'h' => true, 'm' => false],
            "Nythendra"                      => ['n' => true, 'h' => true, 'm' => false]
        ];

        // 7.1.0
        $trialOfValor = [
            "Helya" => ['n' => true, 'h' => false, 'm' => false],
            "Guarm" => ['n' => true, 'h' => true,  'm' => false],
            "Odyn"  => ['n' => true, 'h' => true,  'm' => false]
        ];

        // 7.1.5
        $theNighthold = [
            "Gul'dan"               => ['n' => true, 'h' => false, 'm' => false],
            "Elisande"              => ['n' => true, 'h' => false, 'm' => false],
            "Tichondrius"           => ['n' => true, 'h' => false, 'm' => false],
            "Krosus"                => ['n' => true, 'h' => false, 'm' => false],
            "High Botanist Tel'arn" => ['n' => true, 'h' => false, 'm' => false],
            "Star Augur Etraeus"    => ['n' => true, 'h' => false, 'm' => false],
            "Spellblade Aluriel"    => ['n' => true, 'h' => false, 'm' => false],
            "Trillax"               => ['n' => true, 'h' => true, 'm' => false],
            "Chronomatic Anomaly"   => ['n' => true, 'h' => true, 'm' => false],
            "Skorpyron"             => ['n' => true, 'h' => true, 'm' => false],
        ];

        // 7.2
        $tombOfSargeras = [];


        $data = [
            'progression' => [
                // 7.1.5
                'The Nighthold'     => $theNighthold,
                // 7.1.0
                'Trial of Valor'    => $trialOfValor,
                // 7.0.0
                'Emerald Nightmare' => $emeraldNightmare,
            ]
        ];

        return $this->page('progression', $data);
    }

    public function page($page, $additionalData = [])
    {
        $data = $this->getData();
        if (!empty($additionalData)) {
            $data = array_merge($data, $additionalData);
        }

        return view('pages.' . $page, $data);
    }
}
