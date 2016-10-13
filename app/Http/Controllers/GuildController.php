<?php namespace WoWStats\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use WoWStats\Models\CharacterStats;

class GuildController extends Controller
{

    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        $data = $this->getData();
        return view('home', $data);
    }

    public function stats()
    {
        $data = $this->getData();

        $stats = CharacterStats::get();
        $data['stats'] = $stats;

        return view('guild.view', $data);
    }
}
