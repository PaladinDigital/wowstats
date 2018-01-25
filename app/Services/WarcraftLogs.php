<?php

namespace WoWStats\Services;

use Cache;
use GuzzleHttp\Client as HttpClient;
use WoWStats\Services\WCL\FightParser;
use WoWStats\Services\WCL\Parsers\Healing;
use WoWStats\Services\WCL\Parsers\Tanking;
use WoWStats\Services\WCL\Parsers\Damage;
use WoWStats\Services\WCL\Parsers\Deaths;

class WarcraftLogs
{
    public $logId;

    public function __construct($logId)
    {
        $this->logId = $logId;
    }

    public function getFightData($start, $end)
    {
        $data = [];

        $parsers = [
            new Healing($this, $this->logId, $start, $end),
            new Tanking($this, $this->logId, $start, $end),
            new Damage($this, $this->logId, $start, $end),
            new Deaths($this, $this->logId, $start, $end)
        ];

        foreach ($parsers as $parser) {
            $parser->getFightMetricData($data);
        }

        return $data;
    }

    /**
     * Check if character is potential guild member.
     * Based on if they are on the same realm.
     *
     * @param string $character Character name.
     *
     * @return bool
     */
    public function isPossibleGuildMember($character)
    {
        if (strpos($character, '-') !== false) {
            return false;
        }

        return true;
    }

    public function getRaidFights($logId)
    {
        $cacheKey = 'wl_'.$logId.'_fights';
        $cacheDuration = now()->addMinutes(10);

        if (Cache::has($cacheKey)) {
            return Cache::get($cacheKey);
        } else {
            $fights = [];

            $url = $this->getReportFightsApiUrl($logId);

            $fightData = $this->getUriApiResponse($url);

            if (!array_key_exists('fights', $fightData)) {
                return false;
            }

            foreach ($fightData->fights as $fight) {
                if ($fight->boss > 0) {
                    $data = [
                        'start' => $fight->start_time,
                        'end' => $fight->end_time,
                        'boss_id' => $fight->boss,
                        'raid_size' => $fight->size,
                    ];
                    if ($fight->kill) {
                        $data['kill'] = true;
                    } else {
                        $data['kill'] = false;
                        // WLogs Percentages are 4 digi numbers
                        if (strlen((string)$fight->fightPercentage) > 3) {
                            $data['percent'] = $fight->fightPercentage / 100;
                        } else {
                            $data['percent'] = $fight->fightPercentage;
                        }
                    }

                    $fights[] = $data;
                }
            }

            Cache::put($cacheKey, $fights, $cacheDuration);
        }

        return $fights;
    }

    public function getUriApiResponse($uri)
    {
        $http = new HttpClient();
        $response = $http->get($uri);

        $json = $response->getBody()->getContents();

        return json_decode($json);
    }

    public function getReportFightsApiUrl()
    {
        $uri = $this->getBaseApiUrl();
        $uri .= 'report/fights/' . $this->logId;
        $uri .= $this->getApiKeyParam();

        return $uri;
    }

    /**
     * Warcraft Logs API Base URL.
     * @return string
     */
    public function getBaseApiUrl()
    {
        return 'https://www.warcraftlogs.com/v1/';
    }

    public function getApiKeyParam()
    {
        return '?api_key=' . $this->getApiKey();
    }

    public function getApiKey()
    {
        return config('wow.warcraft_logs.api_key');
    }
}
