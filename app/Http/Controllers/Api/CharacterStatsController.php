<?php namespace WoWStats\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use WoWStats\Http\Controllers\Controller;
use WoWStats\Models\CharacterStats;

class CharacterStatsController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', CharacterStats::class);

        $this->validate($request, [
            'fight_id' => 'required|exists:raid_fights,id',
            'character_id' => 'required|exists:characters,id',
            'metric_id' => 'required|exists:metrics,id',
            'value' => 'required|numeric',
        ]);

        $data = $request->only(['name', 'class_id', 'main_role_id', 'os_role_id']);

        CharacterStats::create($data);
    }
}
