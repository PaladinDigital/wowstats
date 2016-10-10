<?php namespace WoWStats\Models;

class Raid extends Model
{
    protected $table = 'raids';

    protected static $rules = [
        'date' => ['required', 'min:6'],
        'raidzone_id' => ['required', 'min:2'],
    ];

    protected $hidden = [];

    protected $fillable = ['date','raidzone_id'];

    public static function valid($data)
    {
        $validator = Validator::make($data, self::$rules);
        if ($validator->passes())
        {
            return true;
        }
        return false;
    }

    public function zone()
    {
        return $this->belongsTo('RaidZone', 'raidzone_id', 'id');
    }

    public static function getRaidCount()
    {
        $results = DB::select('select COUNT(*) as count from raids');
        return $results[0]->count;
    }

    public static function getLastRaid()
    {
        $raid = DB::select('SELECT `id`, `date`, `created_at`, `difficulty_id`, `raidzone_id` FROM raids ORDER BY created_at DESC LIMIT 0 , 1');
        return $results[0];
    }
}