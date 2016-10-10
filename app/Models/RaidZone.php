<?php namespace WoWStats\Models;

class RaidZone extends Model
{
    protected $table = 'raid_zones';

    protected $fillable = ['id', 'name'];

    protected $hidden = [];

    public static function exists($zone_id)
    {
        $zone = RaidZone::where('id', $zone_id)->first();
        if (count($zone) > 0) {
            return true;
        } else {
            return false;
        }
    }
}