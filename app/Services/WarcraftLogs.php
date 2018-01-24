<?php

namespace WoWStats\Services;

class WarcraftLogs
{
    /**
     * Warcraft Logs API.
     * @return string
     */
    public function getBaseApiUrl()
    {
        return 'https://www.warcraftlogs.com/v1/';
    }

    public function getReportFightsApiUrl($logId)
    {
        $uri = $this->getBaseApiUrl();
        $uri .= 'report/fights/' . $logId;
        $uri .= $this->getApiKeyParam();

        return $uri;
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
