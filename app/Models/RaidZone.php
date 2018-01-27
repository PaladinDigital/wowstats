<?php namespace WoWStats\Models;

class RaidZone extends Model
{
    protected $table = 'raid_zones';

    protected $fillable = ['id', 'name'];

    protected $hidden = [];

    public function getBossCount($zoneId)
    {
        return count(RaidBoss::where('raidzone_id', $zoneId)->get());
    }

    public function scopeById($query, $zoneId)
    {
        return $query->where('id', $zoneId);
    }

    public static function bossCount($zoneId)
    {
        return (new self)->getBossCount($zoneId);
    }

    public static function exists($zone_id)
    {
        $zone = self::byId($zone_id)->first();
        if (count($zone) > 0) {
            return true;
        } else {
            return false;
        }
    }
}
