<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getData()
    {
        $guildName = config('wow.guild.name', 'My Guild');
        $appName = config('wow.app.name', 'My Guild');
        $theme = config('wow.app.theme', 'none');

        return [
            'guildName' => $guildName,
            'appName'   => $appName,
            'theme'     => $theme
        ];
    }
}
