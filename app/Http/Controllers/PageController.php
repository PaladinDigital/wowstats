<?php namespace WoWStats\Http\Controllers;

use WoWStats\Http\Controllers\Controller;
use WoWStats\Models\Raid;
use WoWStats\Models\Character;
use WoWStats\Models\CharacterStats;
use WoWStats\User;

class PageController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function page($page)
    {
        $data = $this->getData();

        return view('admin/index', $data);
    }
}
