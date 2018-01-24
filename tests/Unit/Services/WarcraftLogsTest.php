<?php

namespace WoWStats\Tests\Unit\Services;

use WoWStats\Tests\TestCase;
use WoWStats\Services\WarcraftLogs;

class WarcraftLogsTest extends TestCase
{
    public $service;

    public function setUp()
    {
        parent::setUp();
        $this->service = new WarcraftLogs();
    }

    public function testGetReportFightsApiUrl()
    {
        $logId = '1234abcd';
        $apiUrl = $this->service->getReportFightsApiUrl($logId);

        $expect = 'https://www.warcraftlogs.com/v1/report/fights/1234abcd?api_key=' . config('wow.warcraft_logs.apikey');

        $this->assertEquals($expect, $apiUrl);
    }
}