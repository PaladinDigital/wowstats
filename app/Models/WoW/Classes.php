<?php namespace WoWStats\Models\WoW;

class Classes
{
    public $class_data;

    public function __construct()
    {
        $this->class_data = [
            1 => [
                'class' => 'Warrior',
                'color' => '#C79C6E',
                'color_rgb' => [
                    'r' => 199,
                    'g' => 156,
                    'b' => 110
                ]
            ],
            2 => [
                'class' => 'Paladin',
                'color' => '#F58CBA',
                'color_rgb' => [
                    'r' => 245,
                    'g' => 140,
                    'b' => 186
                ]
            ],
            3 => [
                'class' => 'Hunter',
                'color' => '#ABD473',
                'color_rgb' => [
                    'r' => 171,
                    'g' => 212,
                    'b' => 115
                ]
            ],
            4 => [
                'class' => 'Rogue',
                'color' => '#FFF569',
                'color_rgb' => [
                    'r' => 255,
                    'g' => 245,
                    'b' => 105
                ]
            ],
            5 => [
                'class' => 'Priest',
                'color' => '#FFFFFF',
                'color_rgb' => [
                    'r' => 255,
                    'g' => 255,
                    'b' => 255
                ]
            ],
            6 => [
                'class' => 'Death Knight',
                'color' => '#C41F3B',
                'color_rgb' => [
                    'r' => 196,
                    'g' => 31,
                    'b' => 59
                ]
            ],
            7 => [
                'class' => 'Shaman',
                'color' => '#0070DE',
                'color_rgb' => [
                    'r' => 0,
                    'g' => 112,
                    'b' => 222
                ]
            ],
            8 => [
                'class' => 'Mage',
                'color' => '#69CCF0',
                'color_rgb' => [
                    'r' => 105,
                    'g' => 204,
                    'b' => 240
                ]
            ],
            9 => [
                'class' => 'Warlock',
                'color' => '#9482C9',
                'color_rgb' => [
                    'r' => 148,
                    'g' => 130,
                    'b' => 201
                ]
            ],
            10 => [
                'class' => 'Monk',
                'color' => '#00FF96',
                'color_rgb' => [
                    'r' => 0,
                    'g' => 255,
                    'b' => 150
                ]
            ],
            11 => [
                'class' => 'Druid',
                'color' => '#FF7D0A',
                'color_rgb' => [
                    'r' => 255,
                    'g' => 125,
                    'b' => 10
                ]
            ],
            12 => [
                'class' => 'Demon Hunter',
                'color' => '#A330C9',
                'color_rgb' => [
                    'r' => 163,
                    'g' => 48,
                    'b' => 201
                ]
            ]
        ];
    }

    /***
     * Get the textual representation of a characters class
     * @param integer $class_id
     * @return string
     */
    public function getClassName($class_id)
    {
        $classes = $this->class_data;

        if (!array_key_exists($class_id, $classes)) {
            return false;
        }
        if (!array_key_exists('class', $classes[$class_id])) {
            return false;
        }
        return $this->class_data[$class_id]['class'];
    }

    public function getClassId($class_name)
    {
        foreach ($this->class_data as $id => $data) {
            $class = $data['class'];
            if ($class == $class_name) {
                return $id;
            }
        }
        return null;
    }

    public function getDisplayName($class_name)
    {
        switch ($class_name) {
            case 'Death Knight':
                $display_class = 'death_knight';
                break;
            case 'Demon Hunter':
                $display_class = 'demon_hunter';
                break;
            default:
                $display_class = lcfirst($class_name);
                break;
        }

        return $display_class;
    }

    public function getClassColor($identifier)
    {
        if (strlen($identifier) > 2) {
            $identifier = intval($identifier);
        } else {
            /* Convert to class id if a string is passed in */
            if (is_string($identifier)) {
                $identifier = intval($identifier);
                if ($identifier === null) {
                    return '#FFFFFF';
                }
            }
        }

        $color = $this->class_data[$identifier]['color'];
        return $color;
    }

    public function getClassRGBColor($identifier)
    {
        if (strlen($identifier) > 2) {
            $identifier = intval($identifier);
        } else {
            /* Convert to class id if a string is passed in */
            if (is_string($identifier)) {
                $identifier = intval($identifier);
                if ($identifier === null) {
                    return ['r' => 255, 'g' => 255, 'b' => 255];
                }
            }
        }

        $color = $this->class_data[$identifier]['color_rgb'];
        return $color;
    }

    public function getOptions()
    {
        $options = [];

        foreach ($this->class_data as $id => $class) {
            $options[$id] = $class['class'];
        }

        return $options;
    }
}
