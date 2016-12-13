<?php namespace WoWStats\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends Controller
{
    const STATS_STORE_LOG_PREFIX = "ApiController: Player Stats Store: ";
    const FORUM_CAT_STORE_LOG_PREFIX = "ApiController: Forum Category Store: ";
    const FORUM_STORE_LOG_PREFIX = "ApiController: Forum Store: ";

    public function player_stats_store(Request $request)
    {
        $data = [
            "character_id" => $request->input('character_id'),
            "fight_id" => $request->input('fight_id'),
            "metric_id" => $request->input('metric_id'),
            "value" => $request->input('value')
        ];

        $response = $this->check_is_admin();
        if (isset($response)) {
            return $response;
        }

        if (!CharacterStats::valid($data)) {
            \Log::debug(STATS_STORE_LOG_PREFIX . 'PlayerStats data invalid');
            \Log::debug($data);
            return Response::make('Bad Request', 400);
        }

        PlayerStats::create($data);
    }
}
