<?php namespace WoWStats\Models;

use Exception;

class Character extends Model
{
    protected $table = 'characters';

    // Hidden from API (json) output.
    protected $hidden = ['main_role_id', 'os_role_id'];

    protected $fillable = ['name', 'class_id', 'rank'];

    public function stats()
    {
        return $this->hasMany('CharactereStats');
    }

    public function getClassName()
    {
        $classes = new Classes();
        $class_name = $classes->getClassName($this->class_id);
        return $class_name;
    }

    public function get_attributes()
    {
        $attributes = CharacterAttributes::where('character_id', $this->id)->get();
        return $attributes;
    }

    public function has_attribute($attr)
    {
        try {
            $attr_id = Attributes::getAttributeId($attr);
            if ($attr_id === false) { return false; }
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
        }
        catch (Exception $e) {
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

    public static function getNameSortedActiveRaiders()
    {
        try {
            $characters = Character::where('active', 1)->get()->sortBy('name');
            return $characters;
        } catch (Exception $e) {
            return null;
        }
    }

    public static function getRaiders()
    {
        try {
            $characters = Character::where('active', 1)->get()->sortBy('rank');
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
}