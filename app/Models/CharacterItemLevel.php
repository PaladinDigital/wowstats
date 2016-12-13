<?php namespace WoWStats\Models;

class CharacterItemLevel extends Model
{
    protected $table = 'character_item_levels';

    protected $hidden = [];

    protected $fillable = ['character_id', 'item_level'];

    public static function exist($id, $iLevel)
    {
        try {
            CharacterItemLevel::where('character_id', $id)->where('item_level', $iLevel)->firstOrFail();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

    public static function createIfNotExist($id, $iLevel)
    {
        if(!self::exist($id, $iLevel)) {
            CharacterItemLevel::create([
                'character_id' => $id,
                'item_level' => $iLevel
            ]);
        }
    }
}