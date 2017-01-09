<?php namespace WoWStats\Models;

class RaidFight extends Model
{
    protected $table = 'raid_fights';

    protected $fillable = ['raid_id', 'boss_id', 'killed', 'length', 'logs_url'];

    protected $hidden = [];

    public function raid()
    {
        return $this->belongsTo(Raid::class);
    }

    public function boss()
    {
        return $this->belongsTo(RaidBoss::class);
    }
}
