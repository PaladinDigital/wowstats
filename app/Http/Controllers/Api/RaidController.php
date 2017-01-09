<?php namespace WoWStats\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use WoWStats\Http\Controllers\Controller;
use Carbon\Carbon;
use WoWStats\Models\Raid;

class RaidController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', Raid::class);

        $this->validate($request, [
            'raidzone_id' => 'required|integer|exists:raid_zones,id',
            'difficulty_id' => 'required|integer|min:0|max:3',
            'date' => 'required',
            'time' => 'required',
        ]);

        $input = $request->only(['raidzone_id', 'date', 'time', 'difficulty_id']);

        /* Get and Convert Date */
        $date = $input['date'];
        if (!isset($timezone)) {
            $timezone = 'Europe/London';
        }
        $carbon = new Carbon($date, $timezone);
        $date = $carbon->toDateString();
        $data = [
            'date' => $date,
            'time' => $input['time'],
            'raidzone_id' => $input['raidzone_id'],
            'difficulty_id' => $input['difficulty_id'],
        ];

        Raid::create($data);
    }
}
