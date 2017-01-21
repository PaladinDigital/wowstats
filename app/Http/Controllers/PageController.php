<?php namespace WoWStats\Http\Controllers;

use WoWStats\Models\Raid;
use WoWStats\Models\RaidBoss;
use WoWStats\Models\RaidFight;
use WoWStats\Models\Character;
use WoWStats\Models\RaidAttendee;

class PageController extends Controller
{
    public function raiding()
    {
        $data = [
            'progression_team' => [
                /* Officers */
                (object)[ 'name' => 'Wolirraw',    'class' => 'Hunter',       'cssClass'  => 'hunter'       ],
                (object)[ 'name' => 'Murmundamus', 'class' => 'Warlock',      'cssClass'  => 'warlock'      ],
                (object)[ 'name' => 'Nuuruhuine',  'class' => 'Death Knight', 'cssClass'  => 'death_knight' ],
                (object)[ 'name' => 'Sniperdrood', 'class' => 'Druid',        'cssClass'  => 'druid'        ],
                (object)[ 'name' => 'Labobbob',    'class' => 'Death Knight', 'cassClass' => 'death_knight' ],
                (object)[ 'name' => 'Wulfar',      'class' => 'Druid',        'cssClass'  => 'druid'        ],
                /* DPS */
                (object)[ 'name' => 'Vagrasis',    'class' => 'Mage',         'cssClass'  => 'mage'         ],
                (object)[ 'name' => 'Phanotos',    'class' => 'Rogue',        'cssClass'  => 'rogue'        ],
                (object)[ 'name' => 'Bananael',    'class' => 'Demon Hunter', 'cssClass'  => 'demon_hunter' ],
                (object)[ 'name' => 'Glasha',      'class' => 'Warrior',      'cssClass'  => 'warrior'      ],
                (object)[ 'name' => 'Zenjaquin',   'class' => 'Hunter',       'cssClass'  => 'hunter'       ],
                /* Healers */
                (object)[ 'name' => 'Locutor',     'class' => 'Priest',       'cssClass'  => 'priest'       ],
                (object)[ 'name' => 'Pepperstash', 'class' => 'monk',         'cssClass'  => 'monk'         ],
                (object)[ 'name' => 'Zonraja',     'class' => 'druid',        'cssClass'  => 'druid'        ],
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
