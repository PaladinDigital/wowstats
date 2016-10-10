<?php namespace WoWStats\Http\Controllers;

use Illuminate\Http\Request;

class ApiController extends BaseController
{
    const STATS_STORE_LOG_PREFIX = "ApiController: Player Stats Store: ";
    const FORUM_CAT_STORE_LOG_PREFIX = "ApiController: Forum Category Store: ";
    const FORUM_STORE_LOG_PREFIX = "ApiController: Forum Store: ";

    public function player_stats_store(Request $request)
    {
        $data = [
            "player_id" => $request->input('player_id'),
            "fight_id" => $request->input('fight_id'),
            "metric_id" => $request->input('metric_id'),
            "value" => $request->input('value')
        ];

        $response = $this->check_is_admin();
        if (isset($response)) {
            return $response;
        }

        if (!PlayerStats::valid($data)) {
            \Log::debug(STATS_STORE_LOG_PREFIX . 'PlayerStats data invalid');
            \Log::debug($data);
            return Response::make('Bad Request', 400);
        }

        PlayerStats::create($data);
    }

    public function roster()
    {
        $players = Character::getRaiders();
        return $players;
    }

    public function check_is_admin()
    {
        if (Auth::user()->can('administrate')) {
            \Log::debug(STATS_STORE_LOG_PREFIX . 'Non-admin attempting to create stats');
            return Response::make('Unauthorised', 401);
        }
    }
}