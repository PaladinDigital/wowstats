<?php namespace WoWStats\Models;

use Exception;
use WoWStats\Models\WoW\Classes;

class CharacterClass extends Model
{
    protected $table = 'character_classes';

    protected $hidden = [];

    protected $fillable = [
        'id',
        'class_name',
        'css_name',
        'color_hex',
        'rgb_r',
        'rgb_g',
        'rgb_b',
    ];

    public static function exists($name)
    {
        try {
            $class = CharacterClass::where('class_name', $name)->firstOrFail();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function getOptions()
    {
        $options = [];
        $classes = CharacterClass::all();
        $options[0] = 'Please Select';
        foreach ($classes as $c) {
            $options[$c->id] = $c->class_name;
        }
        return $options;
    }

    public function __debugInfo()
    {
        return [
            'name' => $this->class_name,
            'css_class' => $this->css_class,
            'colors' => [
                'hex' => $this->color_hex,
                'rgb' => [
                    'r' => $this->rgb_r,
                    'g' => $this->rgb_g,
                    'b' => $this->rgb_b,
                ]
            ]
        ];
    }
}
