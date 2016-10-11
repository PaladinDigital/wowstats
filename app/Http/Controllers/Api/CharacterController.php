<?php namespace WoWStats\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use WoWStats\Http\Controllers\Controller;
use Carbon\Carbon;
use WoWStats\Models\Character;

class CharacterController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', Character::class);

        $this->validate($request, [
            'name' => 'required',
        ]);

        $input = $request->only(['name']);

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
        ];

        Raid::create($data);
    }
}
