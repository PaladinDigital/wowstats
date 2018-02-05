<?php namespace WoWStats\Http\Controllers;

use \Auth;
use \View;
use WoWStats\User;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Taskforcedev\LaravelSupport\Http\Controllers\Controller as LaravelSupportController;

class Controller extends LaravelSupportController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;

    public function __construct()
    {
        View::share($this->getData());
    }

    public function getData($data = [])
    {
        $guildName = config('wow.guild.name', 'My Guild');
        $appName = config('wow.app.name', 'My Guild');
        $theme = config('wow.app.theme', 'none');

        $data['guildName'] = $guildName;
        $data['appName'] = $appName;
        $data['theme'] = $theme;

        $data = $this->buildData($data);

        return $data;
    }

    public function getUser()
    {
        if (\Auth::check()) {
            return \Auth::user();
        } else {
            return new User();
        }
    }
}
