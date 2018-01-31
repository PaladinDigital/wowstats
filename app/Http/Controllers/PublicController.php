<?php namespace WoWStats\Http\Controllers;

use WoWStats\Models\Character;
use WoWStats\Models\Raid;
use WoWStats\Models\RaidZone;

class PublicController extends Controller
{
    public function characters()
    {
        $data = [
            'characters' => Character::paginate(25)
        ];

        return view('characters.index', $data);
    }

    public function raids()
    {
        $data = [
            'raids' => Raid::paginate(25),
            'raidzones' => RaidZone::all(),
        ];

        return view('raids.index', $data);
    }
}
