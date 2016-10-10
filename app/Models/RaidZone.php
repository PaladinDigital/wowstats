<?php namespace WoWStats\Models;

class RaidZone extends Model
{
    protected $table = 'raid_zones';

    protected $fillable = [];

    protected $hidden = [];

    public static function exists($zone_id)
    {
        try {
            $zone = RaidZone::where('id', $zone_id)->firstOrFail();
            return true;
        } catch (Exception $e) {
            return false;
        }
    }
}