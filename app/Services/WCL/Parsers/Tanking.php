<?php

namespace WoWStats\Services\WCL\Parsers;

class Tanking extends MetricParser
{
    public function getFightMetricData(&$data)
    {
        $metric = 'damage-taken';
        $this->getRequestedEntries($data, $metric);
    }
}