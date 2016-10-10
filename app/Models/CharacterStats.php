<?php namespace WoWStats\Models;

class CharacterStats extends Model
{
    protected $table = 'character_raid_stats';
    /**
     * The fields excluded from the model's JSON form.
     */
    protected $hidden = [];
    protected $fillable = ['fight_id', 'character_id', 'metric_id', 'value'];
    public static function valid($data)
    {
        $rules = [
            'fight_id' => ['required', 'integer', 'min:1'],
            'character_id' => ['required', 'integer', 'min:1'],
            'metric_id' => ['required', 'integer', 'min:1'],
            'value' => ['required', 'integer', 'min:1'],
        ];
        $validator = Validator::make($data, $rules);
        if ($validator->passes())
        {
            return true;
        }
        return false;
    }
    public function character()
    {
        return $this->belongsTo('Character', 'character_id');
    }
    public function raidfight()
    {
        return $this->belongsTo('RaidFight', 'fight_id');
    }
    public static function fightDpsStats($fight_id)
    {
        $stats = CharacterStats::with('character')->where('fight_id', $fight_id);
        return $stats->where('metric_id', '<=', 2)->get();
    }
    public static function fightTankStats($fight_id)
    {
        $stats = CharacterStats::with('character')->where('fight_id', $fight_id);
        return $stats
            ->where('metric_id', '>=', 5)
            ->where('metric_id', '<=', 6)
            ->get();
    }
    public static function fightHpsStats($fight_id)
    {
        $stats = CharacterStats::with('character')->where('fight_id', $fight_id);
        return $stats
            ->where('metric_id', '>=', 3)
            ->where('metric_id', '<=', 4)
            ->get();
    }
    public static function characterMetric($metric_id, $character_id)
    {
        $stats = CharacterStats::with('character')
            ->where('metric_id', $metric_id)
            ->where('character_id', $character_id)
            ->get();
        return $stats->where('metric_id', '<=', 2)->get();
    }
    public static function getStatsCount()
    {
        $results = DB::select('select COUNT(*) as count from character_raid_stats');
        return $results[0]->count;
    }
    public static function deleteCharacterStats($character_id)
    {
        DB::table('character_raid_stats')->where('character_id', $character_id)->delete();
    }
}