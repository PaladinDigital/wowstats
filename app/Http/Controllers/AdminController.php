<?php namespace WoWStats\Http\Controllers;

use WoWStats\Http\Controllers\Controller;
use WoWStats\Models\Raid;
use WoWStats\Models\Character;
use WoWStats\Models\CharacterStats;
use WoWStats\User;

class AdminController extends Controller
{
    public function __construct()
    {
        $this->middleware('admin');
    }

    public function index()
    {
        $data = [
            'stats' => [
                'users' => User::getCount(),
                'raids' => Raid::getRaidCount(),
                //'characters' => Character::getCount(),
                //'character_stats' => CharacterStats::getCount(),
            ]
        ];
        return view('admin/index', $data);
    }

    public function users()
    {
        $users = User::all();
        $data = [
            'users' => $users
        ];
        return view('admin/users/list', $data);
    }

    public function raiders()
    {
        $data = [
            'raiders' => Character::all()
        ];
        return view('admin/raiders/list', $data);
    }
}
