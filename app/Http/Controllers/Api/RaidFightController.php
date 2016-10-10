<?php namespace WoWStats\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use WoWStats\Http\Controllers\Controller;
use WoWStats\Models\RaidFight;

class RaidFightController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', RaidFight::class);

        $this->validate($request, [
            'raid_id' => 'required|integer|exists:raids,id',
            'boss_id' => 'required|integer|exists:raid_bosses,id',
            'killed' => 'required|integer|min:0|max:1',
        ]);

        $data = $request->only(['raid_id', 'boss_id', 'killed']);

        RaidFight::create($data);
    }
}