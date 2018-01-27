<?php namespace WoWStats\Models;

class RaidBoss extends Model
{
    protected $table = 'raid_bosses';

    protected $hidden = [];

    public static function exists($zone_id, $boss_name)
    {
        $boss = RaidBoss::where(['raidzone_id' => $zone_id, 'name' => $boss_name])->get();
        return (count($boss) > 0);
    }

    public static function getRaidBosses($zoneId)
    {
        try {
            return RaidBoss::where('raidzone_id', $zoneId)->get();
        } catch (Exception $e) {
            return false;
        }
    }
}
