<?php namespace WoWStats\Models;

class CharacterRole extends Model
{
    protected $table = 'character_roles';

    protected $hidden = [];

    public static function exists($role)
    {
        $zone = CharacterRole::where('name', $role)->first();
        if (count($zone) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
