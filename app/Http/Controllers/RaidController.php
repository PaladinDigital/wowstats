<?php

use Lom\Services\Date;
use Lom\WoW\Classes;
use Lom\Security\ACL;

class RaidController extends BaseController
{

    // Lists raids most recent first.
    public function index()
    {
        $acl = new ACL();
        $zones = RaidZone::all();
        $raids = Raid::with('zone')->orderBy('date', 'DESC')->get();
        $data = ['zones' => $zones, 'raids' => $raids, 'acl' => $acl, 'title' => 'Raid Listing'];
        return View::make('raids/index', $data);
    }

    // Create a raid via jQuery
    public function apiStore()
    {
        $data = [
            'raidzone_id' => Input::get('raidzone_id'),
        ];
        /* Get and Convert Date */
        $date = Input::get('date');
        $date = Date::convertDate($date, 'dd/mm/yyyy', 'mysql');
        $data['date'] = $date;

        /* Check user is admin */
        $acl = new ACL();
        if ($acl->isAdmin()) {
            if (Raid::valid($data)) {
                Raid::create($data);
            }
        }
    }

    public function view($id)
    {
        $acl = new ACL();
        $class_service = new Classes();
        /* Determine if raid exists */
        try {
            $raid = Raid::with('zone')->where('id', $id)->firstOrFail();
            $bosses = RaidBoss::where('raidzone_id', $raid->zone->id)->get();
            $fights = RaidFight::with('boss')->where('raid_id', $id)->get();
            $bosses_killed = RaidFight::with('boss')->where('raid_id', $id)->where('kill', 1)->get();
            $raiders = Player::getNameSortedActiveRaiders();
            $attendees = RaidAttendee::with('player')->where('raid_id', $id)->get();
            $data = [
                'raid' => $raid,
                'bosses' => $bosses,
                'fights' => $fights,
                'bosses_killed' => $bosses_killed,
                'raiders' => $raiders,
                'attendees' => $attendees,
                'classes' => $class_service
            ];
            $data['acl'] = $acl;
            return View::make('raids/view', $data);
        } catch (Exception $e) {
            \Log::error($e->getMessage());
            return View::make('errors/404');
        }
    }

    /* Shows a list of dps over time for each player */
    public function dps()
    {
        $dps = Player::with('stats.raidfight.raid')->where('metric_id', 1);
    }

    public function damage()
    {
        $dps = Player::with('stats.raidfight.raid')->where('metric_id', 2);
    }

    public function hps()
    {
        $dps = Player::with('stats.raidfight.raid')->where('metric_id', 3);
    }

    public function healing()
    {
        $dps = Player::with('stats.raidfight.raid')->where('metric_id', 4);
    }

    public function tmi()
    {
        $dps = Player::with('stats.raidfight.raid')->where('metric_id', 5);
    }

    public function damage_taken()
    {
        $dps = Player::with('stats.raidfight.raid')->where('metric_id', 6);
    }
}
