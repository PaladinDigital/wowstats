<?php namespace WoWStats\Http\Controllers;

use WoWStats\Models\Character;
use WoWStats\Models\Raid;
use WoWStats\Models\RaidZone;

class PublicController extends Controller
{
    public function characters()
    {
        $data = $this->getData();
        return view('characters.index', $data);
    }

    public function raids()
    {
        $data = $this->getData();
        $perPage = 25;
        $data['raids'] = Raid::paginate($perPage);
        $data['raidzones'] = RaidZone::all();
        return view('raids.index', $data);
    }
}