<?php

namespace WoWStats\Helpers;

class WarcraftLogs
{
    public function parseFight($url, $options = [])
    {
        $options = $this->defaultOptions($options);

        // Check if any characters listed are not already listed in the application.
    }

    public function defaultOptions($options)
    {
        // TODO:
        if (empty($options)) {
            $options['metrics_to_include'] = [
                'healing',
                'hps',
                'damage',
                'dps',
                'damage_taken',
                'dtps',
                // TODO: Investigate: can the following be parsed: deaths, interrupts, dispells.
            ];
        }

        return $options;
    }

}