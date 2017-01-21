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
        $dps = [
            'Murmundamus', 'Wolirraw',
            'Zenjaquin', 'Vagrasis', 'Labobbob', 'Phanotos', 'Bananael',
            'Glasha', 'Azkadélia',
        ];

        $this->characters = [
            'tanks'   => Character::whereIn('name', $tanks)->get(),
            'healers' => Character::whereIn('name', $healers)->get(),
            'dps'     => Character::whereIn('name', $dps)->get(),
        ];
    }

    public function raiding()
    {
        $data = [
            'progression_team' => [
                /* Officers */
                'Tanks' => $this->characters['tanks'],
                'Healers' => $this->characters['healers'],
            ],
            'raid_team' => [
                (object)[ 'name' => 'Azkadélia', 'class' => 'Mage', 'cssClass' => 'mage' ],
            ],
        ];

        return $this->page('raiding', $data);
    }

    public function officers()
    {
        $data = [
            'officers' => [
                (object)[ 'name' => 'Wolirraw',    'class' => 'Hunter',       'cssClass' => 'hunter'        ],
                (object)[ 'name' => 'Murmundamus', 'class' => 'Warlock',      'cssClass' => 'warlock'       ],
                (object)[ 'name' => 'Nuuruhuine',  'class' => 'Death Knight', 'cssClass' => 'death_knight'  ],
                (object)[ 'name' => 'Azkadélia',   'class' => 'Mage',         'cssClass' => 'mage'          ],
                (object)[ 'name' => 'Sniperdrood', 'class' => 'Druid',        'cssClass' => 'druid'         ],
                (object)[ 'name' => 'Labobbob',    'class' => 'Death Knight', 'cassClass' => 'death_knight' ],
                (object)[ 'name' => 'Wulfar',      'class' => 'Druid',        'cssClass'  => 'druid'        ],
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
