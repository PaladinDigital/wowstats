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
            'Azkadélia'
        ];

        $this->characters = [
            'tanks'           => Character::whereIn('name', $tanks)->get(),
            'healers'         => Character::whereIn('name', $healers)->get(),
            'progression_dps' => Character::whereIn('name', $progression_dps)->get(),
            'raid_dps'        => Character::whereIn('name', $raid_dps)->get(),
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
                (object)[ 'name' => 'Wolirraw', 'class' => 'Hunter', 'cssClass' => 'hunter',
                    'description' => '',
                ],
                (object)[ 'name' => 'Murmundamus', 'class' => 'Warlock', 'cssClass' => 'warlock',
                    'description' => '',
                ],
                (object)[ 'name' => 'Nuuruhuine', 'class' => 'Death Knight', 'cssClass' => 'death_knight',
                    'description' => 'Guild Tank',
                ],
                (object)[ 'name' => 'Sniperdrood', 'class' => 'Druid', 'cssClass' => 'druid',
                    'description' => 'Healer',
                ],
                (object)[ 'name' => 'Labobbob', 'class' => 'Death Knight', 'cssClass' => 'death_knight',
                    'description' => '',
                ],
                (object)[ 'name' => 'Wulfar', 'class' => 'Druid', 'cssClass'  => 'druid',
                    'description' => 'Guild Tank',
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
