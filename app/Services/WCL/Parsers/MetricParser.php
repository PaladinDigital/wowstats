<?php

namespace WoWStats\Services\WCL\Parsers;

use Illuminate\Support\Facades\Log;
use WoWStats\Models\CharacterClass;
use WoWStats\Services\WCL\Specialization;

class MetricParser
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

    public function buildRequestUri($metric)
    {
        if (!in_array($metric, $this->validMetrics)) {
            return false;
        }

        $uri = $this->wcl->getBaseApiUrl();
        $uri .= 'report/tables/' . $metric . '/'. $this->logId;
        $uri .= $this->wcl->getApiKeyParam();
        $uri = $this->appendStartEnd($uri, $this->start, $this->end);

        return $uri;
    }

    public function getRequestedEntries(&$data, $metric)
    {
        $uri = $this->buildRequestUri($metric);
        $duration = $this->end - $this->start;

        $metricData = $this->wcl->getUriApiResponse($uri);

        $this->buildGenericStatData($metricData->entries, $metric, $duration, $data);
    }

    public function buildGenericStatData($entries, $metric, $duration, &$data)
    {
        foreach ($entries as $entry) {
            $char = $entry->name;
            $icon = $entry->icon;
            $class = $entry->type;

            if ($class === 'pet' || $class === 'NPC' || $char === 'NPC') {
                continue;
            }

            try {
                $characterClass = CharacterClass::name($class)->firstOrFail();
                $classId = $characterClass->id;
            } catch (\Exception $e) {
                Log::debug($char . ' has no item level for metric: ' . $metric);
            }

            if (!isset($entry->itemLevel)) {
                Log::debug($char . ' has no item level for metric: ' . $metric);
            } else {
                $itemLevel = $entry->itemLevel;
            }


            $relevant = false;

            switch ($metric) {
                case 'healing':
                    $stat = 'healing';
                    $statPerSecond = 'hps';
                    $relevant = $this->spec->isHealingSpecialization($icon);
                    break;
                case 'tanking':
                case 'damage-taken':
                    $stat = 'damage-taken';
                    $statPerSecond = 'dtps';
                    $relevant = $this->spec->isTankSpecialization($icon);
                    break;
                case 'damage':
                case 'damage-done':
                    $stat = 'damage-done';
                    $statPerSecond = 'dps';
                    $relevant = $this->spec->isDpsSpecialization($icon);
                    break;
                default:
                    break;
            }

            if ($relevant) {

                if (!array_key_exists($char, $data)) {
                    $data[$char] = [];
                }

                if (!array_key_exists('itemLevel', $data[$char])) {
                    if (isset($itemLevel)) {
                        $data[$char]['itemLevel'] = $itemLevel;
                    }
                }

                if (!array_key_exists('class_id', $data[$char])) {
                    $data[$char]['class_id'] = $classId;
                }

                $metricTotal = $entry->total;
                $data[$char][$stat] = $metricTotal;

                if (isset($statPerSecond)) {
                    $seconds = $duration / 1000;
                    $mps = number_format($metricTotal / $seconds, 2, '.', '');
                    $data[$char][$statPerSecond] = $mps;
                }
            }
        }
    }

    public function appendStartEnd($uri, $start, $end)
    {
        $uri = $this->uriAppend($uri, 'start', $start);
        $uri = $this->uriAppend($uri, 'end', $end);
        return $uri;
    }

    public function uriAppend($uri, $key, $value)
    {
        return $uri . '&' . $key . '=' . $value;
    }
}