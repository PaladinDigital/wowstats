<?php namespace WoWStats\Models;

use \DB;
use \Validator;
use WoWStats\Services\WarcraftLogs\Importer;

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

    /**
     * Raid difficulty.
     * @return string
     */
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
        if ($validator->passes()) {
            return true;
        }
        return false;
    }

    public function getLogsUrl()
    {
        $url = $this->fights->first()->logs_url;
        if (isset($url) && !empty($url)) {
            return $url;
        }
        return false;
    }

    // Eloquent Relations

    public function zone()
    {
        return $this->belongsTo(RaidZone::class, 'raidzone_id', 'id');
    }

    public function attendees()
    {
        return $this->hasMany(RaidAttendee::class);
    }

    public function fights()
    {
        return $this->hasMany(RaidFight::class);
    }

    // Helper Methods

    /**
     * Get raid attendees.
     * @return static
     */
    public function getAttendees()
    {
        $attendees = RaidAttendee::with('character')
            ->where('raid_id', $this->id)
            ->get();
        return $attendees->sortBy(function ($item) {
            return $item->character->name;
        });
    }

    /**
     * Get the raids fight count.
     * @return int
     */
    public function getFightCount()
    {
        $fights = RaidFight::where('raid_id', $this->id)->get();
        return count($fights);
    }

    /**
     * Get the killed bosses count.
     * @return int
     */
    public function getBossKillCount()
    {
        $kills = RaidFight::where('raid_id', $this->id)->where('killed', 1)->get();
        return count($kills);
    }

    // Static Methods

    /**
     * Get the count of stored raids.
     * @return mixed
     */
    public static function getRaidCount()
    {
        $results = DB::select('select COUNT(*) as count from raids');
        return $results[0]->count;
    }

    /**
     * Get the last created raid.
     * @return mixed
     */
    public static function getLastRaid()
    {
        $raid = DB::select('SELECT `id`, `date`, `created_at`, `difficulty_id`, `raidzone_id` FROM raids ORDER BY created_at DESC LIMIT 0 , 1');
        return $raid[0];
    }
}
