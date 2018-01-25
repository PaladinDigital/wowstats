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
        $logId = 't78PdgTcRFDvrfKC';
        $this->service = new WarcraftLogs($logId);
    }

    public function testGetReportFightsApiUrl()
    {

        $apiUrl = $this->service->getReportFightsApiUrl();

        $apiKey = config('wow.warcraft_logs.api_key');

        $expect = 'https://www.warcraftlogs.com/v1/report/fights/t78PdgTcRFDvrfKC?api_key=' . $apiKey;

        $this->assertEquals($expect, $apiUrl);
    }

    public function testIsPossibleGuildMemberTrue()
    {
        $name = 'Testíe';
        $truth = $this->service->isPossibleGuildMember($name);
        $this->assertEquals(true, $truth);
    }

    public function testIsPossibleGuildMemberFalse()
    {
        $name = 'Testíe-Ragnaros';
        $truth = $this->service->isPossibleGuildMember($name);
        $this->assertEquals(false, $truth);
    }

    public function testOutputOfGetFights()
    {
        $logId = 't78PdgTcRFDvrfKC';
        $fights = $this->service->getRaidFights($logId);

        foreach ($fights as $fight) {
            $this->assertArrayHasKey('start', $fight);
            $this->assertArrayHasKey('end', $fight);
            $this->assertArrayHasKey('boss_id', $fight);
        }

        // var_dump($fights);
    }
}