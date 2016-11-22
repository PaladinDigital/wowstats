<?php namespace WoWStats\Http\Controllers;

use WoWStats\Models\Raid;
use WoWStats\Models\RaidBoss;
use WoWStats\Models\RaidFight;
use WoWStats\Models\Character;
use WoWStats\Models\RaidAttendee;

class RaidController extends Controller
{
    public function view($id)
    {
        $data = $this->getData();
        /* Determine if raid exists */
        try {
            $raid = Raid::with('zone')->where('id', $id)->firstOrFail();
            $data['raid'] = $raid;
            $data['bosses'] = RaidBoss::where('raidzone_id', $raid->zone->id)->get();
            $data['fights'] = RaidFight::with('boss')->where('raid_id', $id)->get();
            $data['bosses_killed'] = RaidFight::with('boss')->where('raid_id', $id)->where('killed', 1)->get();
            $data['raiders'] = Character::getNameSortedActiveRaiders();

            $data['attendees'] = $raid->getAttendees();

            return view('raids/view', $data);
        } catch (Exception $e) {
            return view('errors/404');
        }
    }

    /* Shows a list of dps over time for each player */
    public function dps()
    {
        $dps = Character::with('stats.raidfight.raid')->where('metric_id', 1);
    }

    public function damage()
    {
        $dps = Character::with('stats.raidfight.raid')->where('metric_id', 2);
    }

    public function hps()
    {
        $dps = Character::with('stats.raidfight.raid')->where('metric_id', 3);
    }

    public function healing()
    {
        $dps = Character::with('stats.raidfight.raid')->where('metric_id', 4);
    }

    public function tmi()
    {
        $dps = Character::with('stats.raidfight.raid')->where('metric_id', 5);
    }

    public function damage_taken()
    {
        $dps = Character::with('stats.raidfight.raid')->where('metric_id', 6);
    }
}
