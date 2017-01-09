<?php namespace WoWStats\Http\Controllers;

use Illuminate\Http\Request;
use WoWStats\Models\Character;
use WoWStats\Models\CharacterStats;
use WoWStats\Models\Metric;
use WoWStats\Models\RaidFight;

class ComparisonController extends Controller
{
    public function leaderboards(Request $request)
    {
        $data = $this->getData();
        $stats = CharacterStats::with(['character', 'metric'])->get();

        $data['dps_leaderboard'] = $this->metricLeaderboard($stats, 'dps');
        $data['hps_leaderboard'] = $this->metricLeaderboard($stats, 'hps');
        $data['dt_leaderboard'] = $this->metricTotalLeaderboard($stats, 'damage_taken');

        return view('comparisons.leaderboards', $data);
    }

    public function compareCharacters($char1, $char2)
    {
        $data = $this->getData();
        if (!Character::characterExists($char1) || !Character::characterExists($char2)) {
            return response('Character not found', 404);
        }

        // Get the characters
        $charOne = Character::where('name', $char1)->first();
        $charTwo = Character::where('name', $char2)->first();

        $charOneSpec = $charOne->mainSpec();
        $charTwoSpec = $charTwo->mainSpec();

        if ($charOneSpec == $charTwoSpec) {
            // Compare only main spec.
            switch ($charTwoSpec) {
                case 'Healer':
                    // Build HPS comparison
                    $data['hps_comparison'] = $this->buildMetricComparisonChartData('hps', $charOne, $charTwo);
                    break;
                case 'Tank':
                    break;
                case 'DPS':
                    $data['dps_comparison'] = $this->buildMetricComparisonChartData('dps', $charOne, $charTwo);
                    break;
                default:
                    break;
            }
        } else {
            // Build all metrics
        }
        return view('comparisons.characters', $data);
    }

    /*
     * Helper Methods
     */

    /**
     * Metric Leaderboard.
     *
     * @param $stats
     * @param $metric_name
     * @return array|static
     */
    public function metricLeaderboard($stats, $metric_name)
    {
        $leaderboard = [];

        foreach ($stats as $stat) {
            $metric = $stat->metric->name;
            $character = $stat->character->name;
            $cssClass = $stat->character->cssClass();
            $value = $stat->value;
            if ($metric == $metric_name) {
                if (!array_key_exists($character, $leaderboard)) {
                    $leaderboard[$character] = [
                        $metric_name => $value,
                        'character' => $character,
                        'css' => $cssClass,
                    ];
                } else {
                    $previousValue = $leaderboard[$character][$metric_name];
                    if ($value > $previousValue) {
                        $leaderboard[$character][$metric_name] = $value;
                    }
                }
            }
        }

        $collection = collect(array_values($leaderboard));

        $leaderboard = $collection->sortByDesc(function ($item) use ($metric_name) {
            return $item[$metric_name];
        });

        return $leaderboard;
    }

    /**
     * Metric Total Leaderboard.
     *
     * @param $stats
     * @param $metric_name
     * @return array|static
     */
    public function metricTotalLeaderboard($stats, $metric_name)
    {
        $leaderboard = [];

        foreach ($stats as $stat) {
            $metric = $stat->metric->name;
            $character = $stat->character->name;
            $cssClass = $stat->character->cssClass();
            $value = $stat->value;
            if ($metric == $metric_name) {
                if (!array_key_exists($character, $leaderboard)) {
                    $leaderboard[$character] = [
                        $metric_name => $value,
                        'character' => $character,
                        'css' => $cssClass,
                    ];
                } else {
                    $previousValue = $leaderboard[$character][$metric_name];
                    $leaderboard[$character][$metric_name] = $previousValue + $value;
                }
            }
        }
        $collection = collect(array_values($leaderboard));

        $leaderboard = $collection->sortByDesc(function ($item) use ($metric_name) {
            return $item[$metric_name];
        });

        return $leaderboard;
    }

    public function getStatsByMetric($metricName)
    {
        $metric = Metric::where('name', $metricName)->first();
        $stats = CharacterStats::where('metric_id', $metric->id)->get();
        return $stats;
    }

    public function buildMetricComparisonChartData($metric, $char1, $char2)
    {
        $fights = RaidFight::all();
        $stats = $this->getStatsByMetric($metric);
        $stats = $this->characterCompareStats($stats, $char1, $char2);

        $categories = [];
        $char1metric = [];
        $char2metric = [];

        foreach ($fights as $fight) {
            $categories[] = $fight->id;
            $char1stat = $stats->where('fight_id', $fight->id)->where('character_id', $char1->id)->first();
            $char2stat = $stats->where('fight_id', $fight->id)->where('character_id', $char2->id)->first();
            if (empty($char1stat)) {
                $char1metric[$fight->id] = null;
            } else {
                $char1metric[$fight->id] = $char1stat->value;
            }


            if (empty($char2stat)) {
                $char2metric[$fight->id] = null;
            } else {
                $char2metric[$fight->id] = $char2stat->value;
            }
        }

        $char1series = [
            'name' => $char1->name,
            'color' => $char1->classColor(),
            'data' => array_values($char1metric),
        ];

        $char2series = [
            'name' => $char2->name,
            'color' => $char2->classColor(),
            'data' => array_values($char2metric),
        ];

        if ($char1series['color'] == $char2series['color']) {
            $char1series['color'] = 'red';
            $char2series['color'] = 'blue';
        }

        $series = [
            // Char 1
            (object)$char1series,
            // Char 2
            (object)$char2series,
        ];

        return [
            'categories' => json_encode($categories),
            'series' => json_encode($series),
        ];
    }

    public function fightStats($stats, $fight_id)
    {
        return $stats->filter(function ($stat) use ($fight_id) {
            return $stat->fight_id == $fight_id;
        })->all();
    }

    public function characterCompareStats($stats, $charOne, $charTwo)
    {
        return $stats->filter(function ($stat) use ($charOne, $charTwo) {
            if ($stat->character_id == $charOne->id) {
                return true;
            }
            if ($stat->character_id == $charTwo->id) {
                return true;
            }
            return false;
        });
    }
}
