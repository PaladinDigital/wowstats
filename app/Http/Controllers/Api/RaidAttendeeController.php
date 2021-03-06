<?php namespace WoWStats\Http\Controllers\Api;

use Illuminate\Http\Request;
use WoWStats\Models\RaidAttendee;
use WoWStats\Http\Controllers\Controller;

class RaidAttendeeController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', RaidAttendee::class);

        $data = $request->only(['raid_id', 'character_id']);

        RaidAttendee::create($data);
    }
}
