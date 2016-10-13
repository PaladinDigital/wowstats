<?php namespace WoWStats\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
use WoWStats\Models\Character;

class CharactersController extends Controller
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

    public function view($id)
    {
        if (is_int($id)) {
            $prop = 'id';
        } else {
            $prop = 'name';
        }

        $data = $this->getData();

        // Get the character
        try {
            $char = Character::where($prop, $id)->firstOrFail();
            $data['character'] = $char;
            return view('characters.view', $data);
        } catch(ModelNotFoundException $e) {
            return view('errors.404');
        }
    }
}
