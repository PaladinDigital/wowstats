<?php

namespace WoWStats\Http\Controllers;

use WoWStats\Models\Raid;
use WoWStats\Jobs\ImportFight;
use WoWStats\Services\WarcraftLogs;

class TestController extends Controller
{
    public function test()
    {
        $raidData = [
            'date' => '2018-01-20',
            'time' => '20:30',
            'raidzone_id' => 8638,
            'difficulty_id' => 1,
        ];


        //$logId = 'qzx62GQcWK9hrBwZ';
        $logId = 't78PdgTcRFDvrfKC';
        $service = new WarcraftLogs($logId);

        $fights = $service->getRaidFights($logId);

        $raid = Raid::create($raidData);

        foreach ($fights as $f) {
            $data = $service->getFightData($f['start'], $f['end']);

            echo '<pre>';
            print_r($data);
            echo '</pre>';
        }
    }
}