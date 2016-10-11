<?php namespace WoWStats\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use WoWStats\Models\CharacterStats;
use WoWStats\Models\Raid;
use WoWStats\Models\RaidFight;
use WoWStats\Models\RaidAttendee;
use WoWStats\Models\WoW\Classes;

class RaidFightController extends Controller
{
    public function view($raid_id, $fight_id)
    {
        $data = $this->getData();

        // Check the fight exists
        try {
            $fight = RaidFight::with('boss')->where('id', $fight_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return view('errors.404');
        }

        $data['fight'] = $fight;
        $data['raid'] = Raid::with('zone')->where('id', $raid_id)->first();

        $dps_stats = CharacterStats::fightDpsStats($fight_id);
        $hps_stats = CharacterStats::fightHpsStats($fight_id);
        $tank_stats = CharacterStats::fightTankStats($fight_id);

        $data['stats'] = [
            'damage' => $this->build_dps_data($dps_stats),
            'healing' => $this->build_healing_data($hps_stats),
            'tank' => $this->build_tanking_data($tank_stats)
        ];

        $data['raiders'] = RaidAttendee::with('character')->where('raid_id', $raid_id)->get();

        return view('raids.fights.view', $data);
    }

    public function build_dps_data($data)
    {
        $dps_data = [];
        $damage_data = [];
        $classes = new Classes();

        foreach($data as $s) {
            if ($s->metric_id == 1) {
                $data = [
                    'name' => $s->player->name,
                    'color' => $classes->getClassColor($s->player->class_id),
                    'data' => [(integer)$s->value],
                ];
                $dps_data[] = $data;
            } elseif ($s->metric_id == 2) {
                $data = [
                    'name' => $s->player->name,
                    'data' => [(integer)$s->value],
                    'color' => $classes->getClassColor($s->player->class_id)
                ];
                $damage_data[] = $data;
            }
        }
        return ['dps' => $dps_data, 'damage_done' => $damage_data];
    }

    public function build_tanking_data($data)
    {
        $tmi_data = [];
        $damage_taken_data = [];
        $classes = new Classes();

        foreach($data as $s) {
            if ($s->metric_id == 5) {
                $data = [
                    'name' => $s->player->name,
                    'color' => $classes->getClassColor($s->player->class_id),
                    'data' => [(integer)$s->value],
                ];
                $tmi_data[] = $data;
            } elseif ($s->metric_id == 6) {
                $data = [
                    'name' => $s->player->name,
                    'data' => [(integer)$s->value],
                    'color' => $classes->getClassColor($s->player->class_id)
                ];
                $damage_taken_data[] = $data;
            }
        }
        return ['tmi' => $tmi_data, 'damage_taken' => $damage_taken_data];
    }

    public function build_healing_data($data)
    {
        $hps_data = [];
        $healing_data = [];
        $classes = new Classes();

        foreach($data as $s) {
            if ($s->metric_id == 3) {
                $data = [
                    'name' => $s->player->name,
                    'color' => $classes->getClassColor($s->player->class_id),
                    'data' => [(integer)$s->value],
                ];
                $hps_data[] = $data;
            } elseif ($s->metric_id == 4) {
                $data = [
                    'name' => $s->player->name,
                    'data' => [(integer)$s->value],
                    'color' => $classes->getClassColor($s->player->class_id)
                ];
                $healing_data[] = $data;
            }
        }
        return ['hps' => $hps_data, 'healing_done' => $healing_data];
    }
}
