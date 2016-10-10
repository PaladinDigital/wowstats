<?php namespace WoWStats\Models;

class RaidBoss extends Model
{
    protected $table = 'raid_bosses';

    protected $hidden = [];

    public static function getRaidBosses($raid_id)
    {
        try {
            return RaidBoss::where('raidzone_id', $raid_id)->get();
        } catch (Exception $e) {
            return false;
        }
    }
}