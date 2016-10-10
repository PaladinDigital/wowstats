<?php

use Lom\Security\ACL;
use Lom\WoW\Classes;

class RaidFightController extends BaseController
{
    // Create a raid via jQuery
    public function api_store()
    {
        $data = [
            "raid_id" => Input::get('raid_id'),
            "boss_id" => Input::get('boss_id'),
            "kill" => Input::get('kill')
        ];
        $killed = Input::get('kill');
        $acl = new ACL();
        if ($acl->isAdmin()) {
            if (RaidFight::valid($data)) {
                RaidFight::create($data);
            } else {
                \Log::debug('RaidFight data invalid');
                \Log::debug($data);
            }
        }
    }

    public function view($fight_id)
    {
        $acl = new ACL();
        /* Determine if fight exists */
        try {
            $fight = RaidFight::with('boss')->where('id', $fight_id)->firstOrFail();
            $raid = Raid::with('zone')->where('id', $fight->raid_id)->firstOrFail();
            $dps_stats = PlayerStats::fightDpsStats($fight_id);
            $hps_stats = PlayerStats::fightHpsStats($fight_id);
            $tank_stats = PlayerStats::fightTankStats($fight_id);
            $attendees = RaidAttendee::with('player')->where('raid_id', $fight->raid_id)->get();
            $classes = new Classes();
            $data = [
                'fight' => $fight,
                'stats' => [
                    'damage' => $this->build_dps_data($dps_stats),
                    'healing' => $this->build_healing_data($hps_stats),
                    'tank' => $this->build_tanking_data($tank_stats)
                ],
                'raid' => $raid,
                'raiders' => $attendees,
                'classes' => $classes
            ];
            $data['acl'] = $acl;
            return View::make('fights/view', $data);
        } catch (Exception $e) {
            \Log::error($e->getMessage());
            return View::make('errors/404');
        }
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
