<?php namespace WoWStats\Models;

use \Validator;
use Illuminate\Support\Facades\DB;

class Raid extends Model
{
    protected $table = 'raids';

    protected static $rules = [
        'date' => ['required', 'min:6'],
        'raidzone_id' => ['required', 'min:2'],
        'difficulty_id' => ['required', 'min:0', 'max:3']
    ];

    protected $hidden = [];

    protected $fillable = [ 'date', 'raidzone_id', 'difficulty_id' ];

    public function difficulty()
    {
        switch ($this->difficulty_id) {
            case 0:
                $difficulty = 'LFR';
                break;
            case 1:
                $difficulty = 'Normal';
                break;
            case 2:
                $difficulty = 'Heroic';
                break;
            case 3:
                $difficulty = 'Mythic';
                break;
        }
        return $difficulty;
    }

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
        return $this->belongsTo(RaidZone::class, 'raidzone_id', 'id');
    }

    public function attendees()
    {
        return $this->hasMany(RaidAttendee::class);
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