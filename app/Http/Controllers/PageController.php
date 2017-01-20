<?php namespace WoWStats\Http\Controllers;

use WoWStats\Models\Raid;
use WoWStats\Models\RaidBoss;
use WoWStats\Models\RaidFight;
use WoWStats\Models\Character;
use WoWStats\Models\RaidAttendee;

class PageController extends Controller
{
    public function view($page)
    {
        $data = $this->getData();

        return view('pages.' . $page);
    }
}
