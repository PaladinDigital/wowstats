<?php

namespace WoWStats\Services\WCL\Parsers;

class Healing extends MetricParser
{
    public function getFightMetricData(&$data)
    {
        $metric = 'healing';
        $this->getRequestedEntries($data, $metric);
    }
}