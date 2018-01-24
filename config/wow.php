<?php

return [
    'app'   => [
        'name' => 'Stats Tracker',
        // Valid Themes: 'alliance', 'horde', 'none'
        'theme' => 'horde',
    ],
    'guild' => [
        'name' => 'My Guild',
        'realm' => '', // magtheridon, kazzak, etc.
        'region' => 'eu', // EU US CN KR TW
    ],

    'api'   => [
        'key'    => '',
        'secret' => '',
    ],

    'warcraft_logs' => [
        'api_key' => env('WARCRAFT_LOGS_APIKEY', ''),
    ],
];
