<?php namespace WoWStats\Http\Controllers\Api;

use Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use WoWStats\Http\Controllers\Controller;
use Carbon\Carbon;
use WoWStats\Jobs\ImportFight;
use WoWStats\Models\Raid;
use WoWStats\Services\WarcraftLogs;

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
            'wl_url' => 'nullable'
        ]);

        $input = $request->only(['raidzone_id', 'date', 'time', 'difficulty_id', 'wl_url']);

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

        $raid = Raid::create($data);

        if (!empty($input['wl_url'])) {
            // eg: https://www.warcraftlogs.com/reports/:logId
            $logId = str_replace('https://www.warcraftlogs.com/reports/', '', $input['wl_url']);

            $service = new WarcraftLogs($logId);
            $fights = $service->getRaidFights($logId);

            foreach ($fights as $fight) {
                if (config('app.debug')) {
                    Log::debug('Dispatching ImportFight for');
                    Log::debug($fight);
                }
                $job = new ImportFight($raid->id, $logId, $fight);
                $this->dispatch($job);
            }
        }
    }
}
