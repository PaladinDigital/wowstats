<?php namespace WoWStats\Models;

class CharacterStats extends Model
{
    protected $table = 'character_raid_stats';

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
        return $this->belongsTo(Character::class, 'character_id');
    }

    public function raidfight()
    {
        return $this->belongsTo(RaidFight::class, 'fight_id');
    }

    public static function fightDpsStats($fight_id)
    {
        $stats = CharacterStats::with('character')->where('fight_id', $fight_id);
        // Get metric for dps
        $dps_metric = Metric::where('name', 'dps')->first();
        $damage_metric = Metric::where('name', 'damage')->first();
        return $stats->whereIn('metric_id', [$dps_metric->id, $damage_metric->id])->get();
    }

    public static function fightTankStats($fight_id)
    {
        $stats = CharacterStats::with('character')->where('fight_id', $fight_id);

        $dtps_metric = Metric::where('name', 'dtps')->first();
        $damage_taken_metric = Metric::where('name', 'damage_taken')->first();
        return $stats
            ->whereIn('metric_id', [
                $dtps_metric->id,
                $damage_taken_metric->id
            ])->get();
    }

    public static function fightHpsStats($fight_id)
    {
        $stats = CharacterStats::with('character')->where('fight_id', $fight_id);

        $healing_metric = Metric::where('name', 'healing')->first();
        $hps_metric = Metric::where('name', 'hps')->first();
        return $stats
            ->whereIn('metric_id', [
                $healing_metric->id,
                $hps_metric->id
            ])->get();
    }

    public static function characterMetric($metric_id, $character_id)
    {
        return CharacterStats::with('character')
            ->where('metric_id', $metric_id)
            ->where('character_id', $character_id)
            ->get();
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

    /* Query Scopes */

    // Scope by Metric ID
    public function scopeMetric($query, $metric_id)
    {
        return $query->where('metric_id', $metric_id);
    }

    public function scopeFight($query, $fight_id)
    {
        return $query->where('fight_id', $fight_id);
    }

    // Scope by Character
    public function scopeForCharacter($query, $character)
    {
        if (is_int($character)) {
            $character_id = $character;
        } elseif (is_object($character)) {
            $character_id = $character->id;
        }

        return $query->where('character_id', $character_id);
    }
}
