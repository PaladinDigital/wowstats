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
        $data = $this->getData();
        $data['stats'] = [
            'users' => User::getCount(),
            'raids' => Raid::getRaidCount(),
        ];

        return view('admin/index', $data);
    }

    public function users()
    {
        $data = $this->getData();
        $data['users'] = User::all();
        return view('admin/users/list', $data);
    }

    public function raiders()
    {
        $data = $this->getData();

        $data['raiders'] = Character::all();

        return view('admin/raiders/list', $data);
    }

    public function stats()
    {
        $data = $this->getData();

        $data['stats'] = CharacterStats::paginate(50);

        return view('admin/stats/index', $data);
    }
}
