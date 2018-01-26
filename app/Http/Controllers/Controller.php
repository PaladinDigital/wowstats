<?php namespace WoWStats\Http\Controllers;

use \Auth;
use WoWStats\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Routing\Controller as BaseController;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Taskforcedev\LaravelSupport\Http\Controllers\Controller as LaravelSupportController;

class Controller extends LaravelSupportController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function getData()
    {
        $guildName = config('wow.guild.name', 'My Guild');
        $appName = config('wow.app.name', 'My Guild');
        $theme = config('wow.app.theme', 'none');

        $data =  [
            'guildName' => $guildName,
            'appName'   => $appName,
            'theme'     => $theme
        ];

        $data = $this->buildData($data);

        if (Auth::check()) {
            $data['user'] = Auth::user();
        } else {
            $data['user'] = new User();
        }

        return $data;
    }
}
