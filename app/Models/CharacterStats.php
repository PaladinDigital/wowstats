<?php namespace WoWStats\Models;

use Illuminate\Database\Eloquent\ModelNotFoundException;

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
        if ($validator->passes()) {
            return true;
        }
        return false;
    }

    public static function exists($fight_id, $character_id, $metric_id)
    {
        try {
            $stats = CharacterStats::where('metric_id', $metric_id)
                ->where('character_id', $character_id)
                ->where('fight_id', $fight_id)->firstOrFail();

            return true;
        } catch (ModelNotFoundException $e) {
            return false;
        }
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
    public function scopeMetricId($query, $metric_id)
    {
        return $query->where('metric_id', $metric_id);
    }

    public function scopeFight($query, $fight_id)
    {
        return $query->where('fight_id', $fight_id);
    }

    public function scopeOrderByValue($query)
    {
        return $query->orderBy('value', 'DESC');
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

    public function __debugInfo()
    {
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

        foreach ($stats as $stat) {
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

        foreach ($stats as $stat) {
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

        return $stats_array;
    }

    public static function buildFightStatsTable($stats, $metric)
    {
        try {
            $metric = Metric::where('name', $metric)->first();
        } catch (ModelNotFoundException $e) {
            return '';
        }

        $tableTotal = 0;

        $table = '<table class="table">
        <thead>
            <tr>
                <th>Player</th>
                <th>'. ucfirst($metric->name) .'</th>
            </tr>
        </thead>
        <tbody>';

        foreach ($stats as $stat) {
            $m = $stat->metric->name;

            if ($metric->name === $m) {
                $table .= '<tr class="'. $stat->character->cssClass() .'">
                    <td>'. $stat->character->name .'</td>
                    <td>'. $stat->value .'</td>
                </tr>';

                $tableTotal += $stat->value;
            }
        }
        $table .= '</tbody>';
        if ($tableTotal > 0) {
            $table .= '<tfoot><tr><td>Total</td><td>'. $tableTotal .'</td></tr></tfoot>';
        }
        $table .= '</table>';
        if ($tableTotal === 0) {
            return '';
        }
        return $table;
    }
}
