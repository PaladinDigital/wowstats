<?php namespace WoWStats\Models;

class RaidFight extends Model
{
    protected $table = 'raid_fights';

    protected $fillable = ['raid_id', 'boss_id', 'kill'];

    protected $hidden = [];

    public static function valid($data)
    {
        $rules = [
            'raid_id' => ['required', 'min:1'],
            'boss_id' => ['required', 'min:1'],
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->passes())
        {
            return true;
        }
        return false;
    }

    public function raid()
    {
        return $this->belongsTo(Raid::class);
    }

    public function boss()
    {
        return $this->belongsTo(RaidBoss::class);
    }
}