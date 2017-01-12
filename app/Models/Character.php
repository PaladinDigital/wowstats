<?php namespace WoWStats\Models;

use Exception;
use WoWStats\Models\CharacterRole;
use WoWStats\Models\WoW\Classes;

class Character extends Model
{
    protected $table = 'characters';

    // Hidden from API (json) output.
    protected $hidden = [];

    protected $fillable = [
        'name',
        'class_id',
        'rank',
        'main_role_id',
        'os_role_id',
        'user_id'
    ];

    public function stats()
    {
        return $this->hasMany('CharacterStats');
    }

    public function className()
    {
        $classes = new Classes();
        $class_name = $classes->getClassName((int)$this->class_id);
        return $class_name;
    }

    public function classColor()
    {
        $classes = new Classes();
        $color = $classes->getClassColor((int)$this->class_id);
        return $color;
    }

    public function classRGBColor()
    {
        $classes = new Classes();
        $color = $classes->getClassRGBColor((int)$this->class_id);
        return $color;
    }

    public function cssClass()
    {
        $classes = new Classes();
        $css_class = $classes->getDisplayName($this->className());
        return $css_class;
    }

    public function mainSpec()
    {
        if (!isset($this->main_role_id) || $this->main_role_id == 0) {
            return 'Unknown';
        }
        $role = CharacterRole::where('id', $this->main_role_id)->first();
        return $role->name;
    }

    public function offSpec()
    {
        if (!isset($this->os_role_id) || $this->os_role_id == 0) {
            return 'Unknown';
        }
        $role = CharacterRole::where('id', $this->os_role_id)->first();
        return $role->name;
    }

    public function get_attributes()
    {
        $attributes = CharacterAttributes::where('character_id', $this->id)->get();
        return $attributes;
    }

    public function getRecentRaidStats($fightCount = 10)
    {
        $fight_ids = [];
        // Get last N raid fights
        $fights = RaidFight::orderBy('id', 'desc')->take($fightCount)->get();
        foreach ($fights as $f) {
            $fight_ids[] = $f->id;
        }
        // Get the character stats
        $stats = CharacterStats::where('character_id', $this->id)->whereIn('fight_id', $fight_ids)->get();
        return $stats;
    }

    public function buildRecentRaidStats()
    {
        $mainSpec = $this->mainSpec();
        $offSpec = $this->offSpec();

        $output = [];
        $deaths = 0;
        $stats = $this->getRecentRaidStats(10);
        $hps = [];
        $dps = [];
        $dtps = [];

        // Build Stats
        foreach ($stats as $s) {
            $metricName = $s->metric->name;

            switch ($metricName) {
                case 'deaths':
                    $deaths = $deaths + $s->value;
                    break;
                case 'hps':
                    $hps[] = $s->value;
                    break;
                case 'dps':
                    $dps[] = $s->value;
                    break;
                default:
                    break;
            }
        }

        // Output Stats
        $output['deaths'] = $deaths;

        if ($mainSpec == 'Healer' || $offSpec == 'Healer') {
            // Average HPS
            $average_hps = array_sum($hps) / count($hps);
            $output['average_hps'] = $average_hps;
        }

        if ($mainSpec == 'DPS') {
            // Average DPS
            $average_dps = array_sum($dps) / count($dps);
            $output['average_dps'] = $average_dps;
        }

        if ($mainSpec == 'Tank' || $offSpec == 'Tank') {
            // Average DTPS
        }

        return $output;
    }

    public function has_attribute($attr)
    {
        try {
            $attr_id = Attributes::getAttributeId($attr);
            if ($attr_id === false) {
                return false;
            }
            $attr = CharacterAttributes::where('character_id', $this->id)->where('attribute_id', $attr_id)->get();
            return $attr;
        } catch (Exception $e) {
            return false;
        }
    }

    public function current_item_level()
    {
        try {
            $ilvl = CharacterItemLevel::where('character_id', $this->id)->orderBy('item_level', 'DESC')->firstOrFail();
            return $ilvl->item_level;
        } catch (Exception $e) {
            return 0;
        }
    }

    public function item_level_history()
    {
        return CharacterItemLevel::where('character_id', $this->id)->orderBy('item_level', 'ASC')->get();
    }

    public function hasStats()
    {
        try {
            CharacterStats::where('character_id', $this->id)->firstOrFail();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function getStats($type = null)
    {
        if (isset($type)) {
            $stats = CharacterStats::where('character_id', $this->id)->where('metric_id', $type)->get();
        } else {
            $stats = CharacterStats::where('character_id', $this->id)->get();
        }
        return $stats;
    }

    public function scopeByName($query, $order = 'ASC')
    {
        return $query->orderBy('name', $order);
    }

    public function scopeNotId($query, $ids = [])
    {
        return $query->whereNotIn('id', $ids);
    }

    public static function getNameSortedActiveRaiders()
    {
        try {
            $characters = Character::all();
            return $characters->sortBy(function ($character) {
                return $character->name;
            });
        } catch (Exception $e) {
            return null;
        }
    }

    public static function getRaiders()
    {
        try {
            $characters = Character::where('active', 1)->get()->sortBy('name', 'ASC');
            return $characters;
        } catch (Exception $e) {
            return null;
        }
    }

    public static function characterExists($name)
    {
        try {
            $character = Character::where('name', $name)->firstOrFail();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public function __debugInfo()
    {
        return [
            'name' => $this->name,
            'class' => $this->className(),
            'main_spec' => $this->mainSpec(),
            'off_spec' => $this->offSpec(),
        ];
    }
}
