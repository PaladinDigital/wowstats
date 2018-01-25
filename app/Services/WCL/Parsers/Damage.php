<?php

namespace WoWStats\Services\WCL\Parsers;

class Damage extends MetricParser
{
    public function getFightMetricData(&$data)
    {
        $metric = 'damage-done';
        $this->getRequestedEntries($data, $metric);
    }
}