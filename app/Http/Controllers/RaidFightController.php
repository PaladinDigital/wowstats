<?php namespace WoWStats\Http\Controllers;

use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use WoWStats\Models\CharacterStats;
use WoWStats\Models\Metric;
use WoWStats\Models\Raid;
use WoWStats\Models\RaidFight;
use WoWStats\Models\RaidAttendee;
use WoWStats\Models\WoW\Classes;

class RaidFightController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function view($raid_id, $fight_id)
    {
        $data = $this->getData();

        // Check the fight exists
        try {
            $fight = RaidFight::with('boss')->where('id', $fight_id)->firstOrFail();
        } catch (ModelNotFoundException $e) {
            return view('errors.404');
        }

        $data['metrics'] = Metric::all();

        $data['fight'] = $fight;
        $data['raid'] = Raid::with('zone')->where('id', $raid_id)->first();

        $stats = CharacterStats::fight($fight->id)->get();
        $data['stats'] = CharacterStats::buildFightStats($stats);
        $data['deaths'] = CharacterStats::buildFightStatsTable($stats, 'deaths');
        $data['interrupts'] = CharacterStats::buildFightStatsTable($stats, 'interrupts');
        $data['dispells'] = CharacterStats::buildFightStatsTable($stats, 'dispells');

        $data['attendees'] = RaidAttendee::with('character')->where('raid_id', $raid_id)->get();

        return view('raids.fights.view', $data);
    }

    public function lock(Request $request, $fight_id)
    {
        $user = Auth::user();
        if (!$user->can('administrate')) {
            return response('Unauthorised', 401);
        }

        try {
            $fight = RaidFight::where('id', $fight_id)->firstOrFail();

            // Lock the raid
            $fight->locked = 1;
            $fight->save();
            return response('Ok', 200);
        } catch (ModelNotFoundException $e) {
            return response('Not found', 404);
        }
    }

    public function unlock(Request $request, $fight_id)
    {
        $user = Auth::user();
        if (!$user->can('administrate')) {
            return response('Unauthorised', 401);
        }

        try {
            $fight = RaidFight::where('id', $fight_id)->firstOrFail();

            // Lock the raid
            $fight->locked = 0;
            $fight->save();
            return response('Ok', 200);
        } catch (ModelNotFoundException $e) {
            return response('Not found', 404);
        }
    }
}
