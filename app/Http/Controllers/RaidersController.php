<?php

use Lom\Services\Warcraft;
use Lom\WoW\Classes;
use Lom\WoW\Ranks;
use Lom\Security\ACL;

class RaidersController extends BaseController
{
    // Lists all raids recorded on the site.
    public function index()
    {
        $acl = new ACL();
        $raiders = Player::getRaiders();
        $data = [
            'raiders' => $raiders,
            'classes' => new Classes(),
            'ranks' => new Ranks(),
            'acl' => $acl,
            'title' => 'Raid Roster'
        ];
        Return View::make('raiders/index', $data);
    }

    public function update()
    {
        $war = new Warcraft();
        $war->updateRaiders();
        return Redirect::route('raiders.index');
    }

    public function view($name)
    {
        $acl = new ACL();
        try {
            $player = Player::with('stats.raidfight.raid')->where('name', $name)->firstOrFail();

            $dps_stats = [];
            $damage_stats = [];
            $hps_stats = [];
            $healing_stats = [];
            $damage_taken_stats = [];
            $tmi_stats = [];
            $classes = new Classes();

            if(isset($player->stats)) {
                foreach($player->stats as $s) {
                    $raid = $s->raidfight->raid;
                    $date = $raid->date;
                    $zone = $raid->raidzone_id;
                    $fight_id = $s->raidfight->id;
                    $metric = $s->metric_id;
                    $value = $s->value;
                    $class_color = $classes->getClassColor($player->class_id);
                    switch ($metric) {
                        case 1: // DPS
                            $this->createStatArray($dps_stats, $class_color, 'DPS', 'Damage per Second', 'dps_chart', $player->name);
                            $dps_stats['data'][$fight_id] = (int)$value;
                            ksort($dps_stats['data']);
                            break;
                        case 2:
                            $this->createStatArray($damage_stats, $class_color, 'Damage Done', 'Total Damage Done', 'damage_chart', $player->name);
                            $damage_stats['data'][$fight_id] = (int)$value;
                            ksort($damage_stats['data']);
                            break;
                        case 3:
                            $this->createStatArray($hps_stats, $class_color, 'HPS', 'Healing per Second', 'hps_chart', $player->name);
                            $hps_stats['data'][$fight_id] = (int)$value;
                            ksort($hps_stats['data']);
                            break;
                        case 4:
                            $this->createStatArray($healing_stats, $class_color, 'Healing Done', 'Total Healing Done', 'healing_chart', $player->name);
                            $healing_stats['data'][$fight_id] = (int)$value;
                            ksort($healing_stats['data']);
                            break;
                        case 5:
                            $this->createStatArray($tmi_stats, $class_color, 'TMI', 'Theck-Meloree Index (Damage Smoothing)', 'tmi_chart', $player->name);
                            $tmi_stats['data'][$fight_id] = (int)$value;
                            ksort($tmi_stats['data']);
                            break;
                        case 6:
                            $this->createStatArray($damage_taken_stats, $class_color, 'Damage Taken', 'Total Damage Taken', 'damage_taken_chart', $player->name);
                            $damage_taken_stats['data'][$fight_id] = (int)$value;
                            ksort($damage_taken_stats['data']);
                            break;
                    }
                }
            }
            $attributes = PlayerAttributes::with('attribute')->where('player_id', $player->id)->get();
            $filtered_attributes = $classes->filterAttributes($attributes, $player->class_id);
            $data = [
                'acl' => $acl,
                'title' => $player->name,
            
                'player' => $player,
                'rank' => (new Ranks)->rankName($player->rank),
                'classes' => $classes,
                
                'color' => $class_color,
                'dps_stats' => $dps_stats,
                'damage_stats' => $damage_stats,
                'healing_stats' => $healing_stats,
                'hps_stats' => $hps_stats,
                'damage_taken_stats' => $damage_taken_stats,
                'tmi_stats' => $tmi_stats,
                
                'item_levels' => PlayerItemLevel::where('player_id', $player->id)->get(),
                'attributes' => $attributes,
                'filtered_attributes' => $filtered_attributes,
                'theorycrafting' => []
            ];
            $theorycrafting = $classes->loadTheorycrafting($player, $data['filtered_attributes']);
            if (method_exists($theorycrafting, 'compare_level_90_talents')) {
                $data['theorycrafting']['class'] = $theorycrafting;
                $data['theorycrafting']['level_90_talents'] = $theorycrafting->compare_level_90_talents();
            }
            return View::make('raiders/view', $data);
        } catch(Exception $e) {
            \Log::error($e);
            return View::make('errors/404');
        }
    }

    public function createStatArray(&$array, $color, $title, $full_title, $selector, $name, $height = 300)
    {
        $this->setArrayKeyIfNotExist('title', $array, $title);
        $this->setArrayKeyIfNotExist('color', $array, $color);
        $this->setArrayKeyIfNotExist('full_title', $array, $full_title);
        $this->setArrayKeyIfNotExist('data', $array, []);
        $this->setArrayKeyIfNotExist('selector', $array, $selector);
        $this->setArrayKeyIfNotExist('height', $array, $height);
        $this->setArrayKeyIfNotExist('name', $array, $name);
    }

    public function setArrayKeyIfNotExist($key, &$array, $value)
    {
        if (!array_key_exists($key, $array)) {
            $array[$key] = $value;
        }
    }

    public function compare($player_one, $player_two)
    {
        $acl = new ACL();
        $data = [];
        $fights = [];
        $fight_data = [];
        $colors = [];

        try {
            $player_one = Player::where('name', $player_one)->firstOrFail();
            $player_two = Player::where('name', $player_two)->firstOrFail();
            $p1id = $player_one->id;
            $p2id = $player_two->id;
            $data['player_one'] = $player_one;
            $data['player_two'] = $player_two;

            /* Class colors or red and yellow */
            $p1_color = (new Classes())->getClassColor($player_one->class_id);
            $p2_color = (new Classes())->getClassColor($player_two->class_id);

            if ($p1_color == $p2_color) {
                $colors[] = "'#FFF569'";
                $colors[] = "'#C41F3B'";
            } else {
                $colors[] = "'" . $p1_color . "'";
                $colors[] = "'" . $p2_color . "'";
            }

            $stats = PlayerStats::whereRaw('player_id IN (' . $p1id . ' ,' . $p2id . ' )')->orderBy('fight_id')->get();

            foreach ($stats as $s) {

                $fight_id = $s->fight_id;
                /* Add fight to fights array */
                if (!in_array($fight_id, $fights)) {
                    $fights[] = $fight_id;
                }

                switch($s->metric_id) {
                    case 1:
                        $metric = 'dps';
                        break;
                    case 2:
                        $metric = 'damage_done';
                        break;
                    case 3:
                        $metric = 'hps';
                        break;
                    case 4:
                        $metric = 'healing_done';
                        break;
                    case 5:
                        $metric = 'tmi';
                        break;
                    case 6:
                        $metric = 'damage_taken';
                        break;
                }

                /* Check player name against stat */
                if ($s->player_id == $p1id) {
                    $player = $player_one->name;
                } else {
                    $player = $player_two->name;
                }

                /* Add data to players array */
                $fight_data[$player][$metric][$fight_id] = $s->value;

            }
            $data['fights'] = $fights;
            $data['fight_data'] = $fight_data;
            $data['colors'] = $colors;

            return View::make('raiders/compare', $data);
        } catch (Exception $e) {
            return View::make('errors/404');
        }
    }

    public function compareAll()
    {
        $fights = [];
        $player_colors = [];
        try {
            $stats = PlayerStats::orderBy('fight_id')->get();

            foreach ($stats as $s) {

                $fight_id = $s->fight_id;
                /* Add fight to fights array */
                if (!in_array($fight_id, $fights)) {
                    $fights[] = $fight_id;
                }

                switch($s->metric_id) {
                    case 1:
                        $metric = 'dps';
                        break;
                    case 2:
                        $metric = 'damage_done';
                        break;
                    case 3:
                        $metric = 'hps';
                        break;
                    case 4:
                        $metric = 'healing_done';
                        break;
                    case 5:
                        $metric = 'tmi';
                        break;
                    case 6:
                        $metric = 'damage_taken';
                        break;
                }

                $player = Player::where('id', $s->player_id)->first();

                $player_colors[$player->name] = (new Classes)->getClassColor($player->class_id);

                /* Add data to players array */
                $fight_data[$metric][$player->name][$fight_id] = $s->value;

            }
            $data['fights'] = $fights;
            $data['fight_data'] = $fight_data;
            $data['player_colors'] = $player_colors;

            return View::make('raiders/compare_all', $data);
        } catch (Exception $e) {
            return View::make('errors/404');
        }
    }

    public function buildPlayerStats($player, $color = null)
    {
        $dps = []; $damage =[]; $healing = []; $hps = []; $tmi = []; $damage_taken = [];

        if ($color === null) {
            $color = (new Classes())->getClassColor($player->class_id);
        } else {
            $color = $color;
        }


        if(isset($player->stats)) {
            foreach($player->stats as $s) {
                $raid = $s->raidfight->raid;
                $date = $raid->date;
                $zone = $raid->raidzone_id;
                $fight_id = $s->raidfight->id;
                $metric = $s->metric_id;
                $value = $s->value;
                switch ($metric) {
                    case 1: // DPS
                        $this->createStatArray($dps, $color, 'DPS', 'Damage per Second', 'dps_chart', $player->name);
                        $dps['data'][$fight_id] = (int)$value;
                        break;
                    case 2:
                        $this->createStatArray($damage, $color, 'Damage Done', 'Total Damage Done', 'damage_chart', $player->name);
                        $damage['data'][$fight_id] = (int)$value;
                        break;
                    case 3:
                        $this->createStatArray($hps, $color, 'HPS', 'Healing per Second', 'hps_chart', $player->name);
                        $hps['data'][$fight_id] = (int)$value;
                        break;
                    case 4:
                        $this->createStatArray($healing, $color, 'Healing Done', 'Total Healing Done', 'healing_chart', $player->name);
                        $healing['data'][$fight_id] = (int)$value;
                        break;
                    case 5:
                        $this->createStatArray($tmi, $color, 'TMI', 'Theck-Meloree Index (Damage Smoothing)', 'tmi_chart', $player->name);
                        $tmi['data'][$fight_id] = (int)$value;
                        break;
                    case 6:
                        $this->createStatArray($damage_taken, $color, 'Damage Taken', 'Total Damage Taken', 'damage_taken_chart', $player->name);
                        $damage_taken['data'][$fight_id] = (int)$value;
                        break;
                }
            }
        }
        $data = [
            'player' => $player->name,
            'color' => $color,
            'dps_stats' => $dps,
            'damage_stats' => $damage,
            'healing_stats' => $healing,
            'hps_stats' => $hps,
            'damage_taken_stats' => $damage_taken,
            'tmi_stats' => $tmi,
            'title' => $player->name,
        ];
        return $data;
    }
}





