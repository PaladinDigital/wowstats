<?php namespace WoWStats\Http\Controllers;

use WoWStats\Models\Character;

class PageController extends Controller
{
    public $characters;

    public function __construct()
    {
        $healers = [
            'Sniperdrood',
            'Zonraja', 'Locutor', 'Pepperstash'
        ];
        $tanks = [ 'Nuuruhuine', 'Wulfar' ];

        $progression_dps = [
            'Murmundamus', 'Wolirraw',
            'Zenjaquin', 'Vagrasis', 'Labobbob', 'Phanotos', 'Bananael',
            'Glasha',
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
                    'rank' => 'Officer'
                    'description' => 'Guild Tank',
                ],
                (object)[
                    'name' => 'Murmundamus',
                    'class' => 'Warlock', 'cssClass' => 'warlock',
                    'rank' => 'Officer'
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
                    'description' => '',
                ],
            ]
        ];
        return $this->page('officers', $data);
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
