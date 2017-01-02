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

    public function metric()
    {
        return $this->belongsTo(Metric::class, 'metric_id');
    }

    public function raidfight()
    {
        return $this->belongsTo(RaidFight::class, 'fight_id');
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

    public function __debugInfo() {
        return [
            'fight_id'    => $this->fight_id,
            'character_id' => $this->character_id,
            'metric_id' => $this->metric_id,
            'value' => $this->value,
            'character' => $this->character,
            'fight' => $this->raidfight,
        ];
    }

    public static function buildCharacterStats($stats)
    {
        $stats_array = [];
        $metrics = Metric::all();
        foreach ($metrics as $m) {
            $stats_array[$m->name . '_values'] = [];
            $stats_array[$m->name . '_characters'] = [];
        }

        $stats = $stats->sortBy('fight_id');

        foreach($stats as $stat) {
            $metric = $stat->metric->name;
            $stats_array[$metric . '_values'][] = (object)[
                'color' => $stat->character->classColor(),
                'y' => $stat->value,
                'x' => $stat->raidfight->id,
            ];
            $stats_array[$metric . '_characters'][] = $stat->character->name;
        }

        foreach ($metrics as $m) {
            $stats_array[$m->name . '_characters'] = json_encode($stats_array[$m->name . '_characters']);
            $stats_array[$m->name . '_values'] = json_encode($stats_array[$m->name . '_values']);
        }

        return $stats_array;
    }

    public static function buildFightStats($stats)
    {
        $stats_array = [];
        $metrics = Metric::all();
        foreach ($metrics as $m) {
            $stats_array[$m->name . '_values'] = [];
            $stats_array[$m->name . '_characters'] = [];
        }

        foreach($stats as $stat) {
            $metric = $stat->metric->name;
            $stats_array[$metric . '_values'][] = (object)[
                'color' => $stat->character->classColor(),
                'y' => $stat->value,
            ];
            $stats_array[$metric . '_characters'][] = $stat->character->name;
        }

        foreach ($metrics as $m) {
            $stats_array[$m->name . '_characters'] = json_encode($stats_array[$m->name . '_characters']);
            $stats_array[$m->name . '_values'] = json_encode($stats_array[$m->name . '_values']);
        }

        $stats_array = self::convertChartToTabular($stats_array, ['interrupts', 'dispells', 'deaths']);

        return $stats_array;
    }

    public static function convertChartToTabular($stats, $metric)
    {
        foreach ($metric as $m) {
            // Create a variable for that values tabular data
            $stats[$m . '_table'] = [];
            $valueCount = count($stats[$m . '_characters']);
            // Loop through each character and their value.
            for ($i = 0; $i < $valueCount; $i++) {
                $char = $stats[$m . '_characters'][$i]; // Character
                $value = $stats[$m . '_values'][$i]; // Value;
                $stats[$m . '_table'][$stats[$i]][$char] = $value;
            }
        }
        return $stats;
    }
}
