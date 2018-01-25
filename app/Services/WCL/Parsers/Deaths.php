<?php

namespace WoWStats\Services\WCL\Parsers;

class Deaths extends EventCountParser
{
    public function getFightMetricData(&$data)
    {
        $metric = 'deaths';
        $this->getRequestedEntries($data, $metric);
    }
}