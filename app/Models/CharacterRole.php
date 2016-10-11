<?php namespace WoWStats\Models;

class CharacterRole extends Model
{
    protected $table = 'character_roles';

    protected $hidden = [];

    public static function exists($role)
    {
        $roles = CharacterRole::where('name', $role)->first();
        if (count($roles) > 0) {
            return true;
        } else {
            return false;
        }
    }

    public static function getOptions()
    {
        $options = [];
        $roles = CharacterRole::all();
        $options[0] = 'Please Select';
        foreach ($roles as $role)
        {
            $options[$role->id] = $role->name;
        }
        return $options;
    }
}
