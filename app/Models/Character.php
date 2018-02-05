<?php namespace WoWStats\Models;

use Auth;
use Exception;

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

    public function isOwned()
    {
        return $this->user_id !== NULL;
    }

    public function isUsers()
    {
        if (Auth::check()) {
            $user = Auth::user();
            return $this->user_id === $user->id;
        }
        return false;
    }

    public function stats()
    {
        return $this->hasMany(CharacterStats::class);
    }

    public function characterClass()
    {
        return $this->hasOne(CharacterClass::class, 'id', 'class_id');
    }

    public function className()
    {
        return $this->characterClass->class_name;
    }

    public function classColor()
    {
        return $this->characterClass->color_hex;
    }

    public function classRGBColor()
    {
        $class = $this->characterClass;
        return [
            'r' => $class->rgb_r,
            'g' => $class->rgb_g,
            'b' => $class->rgb_b
        ];
    }

    public function cssClass()
    {
        return $this->characterClass->css_name;
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

    public function mainSpecIcon()
    {
        if ($this->isDpsOnly()) {
            return $this->specIcon('DPS');
        }

        $spec = $this->mainSpec();
        return $this->specIcon($spec);
    }

    public function offSpecIcon()
    {
        if (!$this->isDpsOnly()) {
            $spec = $this->offSpec();
            return $this->specIcon($spec);
        } else {
            return 'fa fa-minus';
        }
    }

    public function specIcon($spec)
    {
        switch ($spec) {
            case 'Healer':
                return 'fa fa-plus';
                break;
            case 'Tank':
                return 'fa fa-shield';
                break;
            case 'DPS':
                return 'fa fa-bomb';
                break;
            default:
                return 'fa fa-question';
                break;
        }
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
                case 'dtps':
                    $dtps[] = $s->value;
                    break;
                default:
                    break;
            }
        }

        // Output Stats
        $output['deaths'] = $deaths;

        if ($mainSpec == 'Healer' || $offSpec == 'Healer') {
            // Average HPS
            $count = count($hps);
            if ($count > 0) {
                $output['average_hps'] = number_format(array_sum($hps) / count($hps));
                $output['max_hps'] = number_format(max($hps));
            }
        }

        if ($mainSpec == 'DPS' || $offSpec == 'DPS') {
            $count = count($dps);
            if ($count > 0) {
                // Average DPS
                $output['average_dps'] = number_format(array_sum($dps) / count($dps));
                $output['max_dps'] = number_format(max($dps));
            }
        }

        if ($mainSpec == 'Tank' || $offSpec == 'Tank') {
            $count = count($dtps);
            // Average DTPS
            if ($count > 0) {
                $output['average_dtps'] = number_format(array_sum($dtps) / count($dtps));
                $output['max_dtps'] = number_format(max($dtps));
            }
        }

        return $output;
    }

    public function getLinks()
    {
        $name = $this->name;
        $region = config('wow.guild.region', '');
        $realm = config('wow.guild.realm', '');

        $armory = "http://{$region}.battle.net/wow/en/character/{$realm}/{$name}/simple";
        $mrRobot = "http://www.askmrrobot.com/wow/gear/{$region}/{$realm}/{$name}";
        $raiderIo = "https://raider.io/characters/{$region}/{$realm}/{$name}";

        return [
            'armory' => $armory,
            'askmrrobot' => $mrRobot,
            'raider.io' => $raiderIo
        ];
    }

    public function getLink($key)
    {
        $links = $this->getLinks();
        return array_key_exists($key, $links) ? $links[$key] : false;
    }

    public function hasLink($key)
    {
        $links = $this->getLinks();
        return array_key_exists($key, $links);
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

    public function isDpsOnly()
    {
        $dpsOnlyChars = ['mage','warlock', 'rogue', 'hunter'];
        return in_array($this->cssClass(), $dpsOnlyChars);
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
