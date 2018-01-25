<?php

namespace WoWStats\Services\WCL\Parsers;

use WoWStats\Services\WCL\Specialization;

class EventCountParser extends MetricParser
{
    public $logId;
    public $start;
    public $end;
    public $validMetrics;
    public $wcl;
    public $spec;

    public function __construct($wcl, $logId, $fightStart, $fightEnd)
    {
        $this->spec = new Specialization();
        $this->wcl = $wcl;
        $this->logId = $logId;
        $this->start = $fightStart;
        $this->end = $fightEnd;
        $this->validMetrics = [
            'healing',
            'hps',
            'damage-done',
            'dps',
            'damage-taken',
            'dtps',
            'dispells',
            'interrupts',
            'deaths',
            'hps_raw',
        ];
    }

    public function getRequestedEntries(&$data, $metric)
    {
        $uri = $this->buildRequestUri($metric);

        $metricData = $this->wcl->getUriApiResponse($uri);
        $this->buildEventCountData($metricData->entries, $metric, $data);
    }

    public function buildEventCountData($entries, $metric, &$data)
    {
        foreach ($entries as $entry) {
            $char = $entry->name;

            switch ($metric) {
                case 'deaths': $stat = 'deaths'; break;
                default: break;
            }

            if (!array_key_exists($char, $data)) {
                $data[$char] = [];
            }

            if (!array_key_exists($stat, $data[$char])) {
                $data[$char][$stat] = 0;
            }

            $data[$char][$stat]++;
        }
    }
}