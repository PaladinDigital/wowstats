<?php

namespace WoWStats\Tests\Unit\Helpers;

use WoWStats\Helpers\WarcraftLogs;
use WoWStats\Tests\TestCase;

class WarcraftLogsTest extends TestCase
{
    public function testDefaultOptionsWithEmptyOptions()
    {
        $helper = new WarcraftLogs();
        $options = [];
        $result = $helper->defaultOptions($options);
        $metrics = $result['metrics_to_include'];
        $this->assertArrayHasKey('metrics_to_include', $result, 'Options array is returned with metrics_to_include array');
        $this->assertEquals(true, in_array('hps', $metrics), 'metrics_to_include inclused hps metric.');
    }
}
