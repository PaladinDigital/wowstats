<?php namespace WoWStats\Http\Controllers;

use Illuminate\Http\Request;
use WoWStats\Models\CharacterStats;

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

    public function metricLeaderboard($stats, $metric_name)
    {
        $leaderboard = [];

        foreach ($stats as $stat)
        {
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

        $leaderboard = $collection->sortByDesc(function($item) use ($metric_name) {
            return $item[$metric_name];
        });

        return $leaderboard;
    }

    public function metricTotalLeaderboard($stats, $metric_name)
    {
        $leaderboard = [];

        foreach ($stats as $stat)
        {
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

        $leaderboard = $collection->sortByDesc(function($item) use ($metric_name) {
            return $item[$metric_name];
        });

        return $leaderboard;
    }
}
