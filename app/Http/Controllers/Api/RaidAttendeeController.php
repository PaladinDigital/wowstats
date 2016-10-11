<?php namespace WoWStats\Http\Controllers\Api;

use Illuminate\Http\Request;
use WoWStats\Models\RaidAttendee;

class RaidAttendeeController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', RaidAttendee::class);

        $data = $request->only(['raid_id, $player_id']);

        RaidAttendee::create($data);
    }
}
