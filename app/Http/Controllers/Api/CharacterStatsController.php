<?php namespace WoWStats\Http\Controllers\Api;

use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        $data = $request->only(['fight_id', 'character_id', 'metric_id', 'value']);

        CharacterStats::create($data);
    }

    public function delete($statId)
    {
        $this->authorize('delete', CharacterStats::class);

        // Check the id exists
        try {
            $stat = CharacterStats::where('id', $statId)->firstOrFail();

            $stat->delete();
        } catch (ModelNotFoundException $e) {
            return response('Page not found.', 404);
        } catch (\Exception $e) { return response('An unknown error occurred.', 500); }
    }
}
