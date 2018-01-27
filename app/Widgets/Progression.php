<?php

namespace WoWStats\Widgets;

use Cache;
use DB;
use WoWStats\Models\RaidZone;

class Progression
{
    public function getData()
    {
        $cacheKey = 'guild.progression';

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        }

        $progress = DB::table('raid_fights')
            ->join('raids', 'raids.id', '=', 'raid_fights.raid_id')
            ->join('raid_zones', 'raid_zones.id', '=', 'raids.raidzone_id')
            ->select('raids.difficulty_id', 'raid_fights.boss_id', 'raid_zones.name', 'raid_zones.id as zone_id')
            ->where('raid_fights.killed', 1)
            ->groupBy('raids.difficulty_id', 'raid_fights.boss_id', 'raid_zones.name', 'raid_zones.id')
            ->get();

        Cache::put($cacheKey, $progress);
        return $progress;
    }

    public function buildProgressionData()
    {
        $progressionData = [];

        $data = $this->getData();

        foreach ($data as $datum)
        {
            $zone = $datum->zone_id;

            switch ($datum->difficulty_id) {
                case 1: $difficulty = 'Normal'; break;
                case 2: $difficulty = 'Heroic'; break;
                case 3: $difficulty = 'Mythic'; break;
                default: $difficulty = $datum->difficulty_id; break;
            }

            // Create the key for the raid
            switch ($datum->name) {
                case 'Antorus, the Burning Throne': $raid = 'Antorus'; break;
                default: $raid = $datum->name; break;
            }

            if (!array_key_exists($raid, $progressionData)) {
                $bossCount = RaidZone::bossCount($zone);
                $progressionData[$raid] = [
                    'difficulty' => [],
                    'boss_count' => $bossCount,
                ];
            }

            if (!array_key_exists($difficulty, $progressionData[$raid]['difficulty'])) {
                $progressionData[$raid]['difficulty'][$difficulty] = 0;
            }

            $progressionData[$raid]['difficulty'][$difficulty]++;
        }

        return $progressionData;
    }

    public function getOutput()
    {
        $output = '<div class="card">';

        $output .= '<div class="card-header">Progression</div>';

        $progression = $this->buildProgressionData();

        $output .= '<table class="table">';
        foreach ($progression as $raid => $data) {
            $output .= '<thead>';
            $output .= '<tr><th colspan="2">'.$raid.'</th></tr>';
            $output .= '</thead>';
            foreach ($data['difficulty'] as $difficulty => $kills) {
                $output .= "<tr><td>{$difficulty}</td><td>{$kills} / {$data['boss_count']}</td></tr>";
            }
        }
        $output .= '</table>';

        $output .= '</div>';
        return $output;
    }
}