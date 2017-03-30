<?php

use Illuminate\Database\Seeder;
use WoWStats\Models\CharacterClass;

class CharacterClassesSeeder extends Seeder
{
    public function run()
    {
        $classes = [
            1 => [
                'class' => 'Warrior',
                'css_class' => 'warrior',
                'color' => '#C79C6E',
                'color_rgb' => [
                    'r' => 199,
                    'g' => 156,
                    'b' => 110
                ]
            ],

            2 => [
                'class' => 'Paladin',
                'css_class' => 'paladin',
                'color' => '#F58CBA',
                'color_rgb' => [
                    'r' => 245,
                    'g' => 140,
                    'b' => 186
                ]
            ],

            3 => [
                'class' => 'Hunter',
                'css_class' => 'hunter',
                'color' => '#ABD473',
                'color_rgb' => [
                    'r' => 171,
                    'g' => 212,
                    'b' => 115
                ]
            ],

            4 => [
                'class' => 'Rogue',
                'css_class' => 'rogue',
                'color' => '#FFF569',
                'color_rgb' => [
                    'r' => 255,
                    'g' => 245,
                    'b' => 105
                ]
            ],

            5 => [
                'class' => 'Priest',
                'css_class' => 'priest',
                'color' => '#FFFFFF',
                'color_rgb' => [
                    'r' => 255,
                    'g' => 255,
                    'b' => 255
                ]
            ],

            6 => [
                'class' => 'Death Knight',
                'css_class' => 'death_knight',
                'color' => '#C41F3B',
                'color_rgb' => [
                    'r' => 196,
                    'g' => 31,
                    'b' => 59
                ]
            ],

            7 => [
                'class' => 'Shaman',
                'css_class' => 'shaman',
                'color' => '#0070DE',
                'color_rgb' => [
                    'r' => 0,
                    'g' => 112,
                    'b' => 222
                ]
            ],

            8 => [
                'class' => 'Mage',
                'css_class' => 'mage',
                'color' => '#69CCF0',
                'color_rgb' => [
                    'r' => 105,
                    'g' => 204,
                    'b' => 240
                ]
            ],

            9 => [
                'class' => 'Warlock',
                'css_class' => 'warlock',
                'color' => '#9482C9',
                'color_rgb' => [
                    'r' => 148,
                    'g' => 130,
                    'b' => 201
                ]
            ],

            10 => [
                'class' => 'Monk',
                'css_class' => 'monk',
                'color' => '#00FF96',
                'color_rgb' => [
                    'r' => 0,
                    'g' => 255,
                    'b' => 150
                ]
            ],

            11 => [
                'class' => 'Druid',
                'css_class' => 'druid',
                'color' => '#FF7D0A',
                'color_rgb' => [
                    'r' => 255,
                    'g' => 125,
                    'b' => 10
                ]
            ],

            12 => [
                'class' => 'Demon Hunter',
                'css_class' => 'demon_hunter',
                'color' => '#A330C9',
                'color_rgb' => [
                    'r' => 163,
                    'g' => 48,
                    'b' => 201
                ]
            ],
        ];

        foreach ($classes as $id => $c) {
            if (!CharacterClass::exists($c['class'])) {
                $data = [];

                $data['id']         = $id;
                $data['class_name'] = $c['class'];
                $data['css_name']   = $c['css_class'];
                $data['color_hex']  = $c['color'];
                $data['rgb_r']      = $c['color_rgb']['r'];
                $data['rgb_g']      = $c['color_rgb']['g'];
                $data['rgb_b']      = $c['color_rgb']['b'];

                CharacterClass::create($data);
            }
        }
    }
}
