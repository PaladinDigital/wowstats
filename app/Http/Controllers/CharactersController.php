<?php namespace WoWStats\Http\Controllers;

use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use WoWStats\Models\Character;
use WoWStats\Models\CharacterStats;
use WoWStats\Models\Metric;

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
            $data['class_color'] = $char->classColor();

            $stats = CharacterStats::forCharacter($char->id)->get();
            $data['stats'] = CharacterStats::buildCharacterStats($stats);

            return view('characters.view', $data);
        } catch(ModelNotFoundException $e) {
            return view('errors.404');
        }
    }

    public function claim(Request $request)
    {
        $user_id = Auth::user()->id;
        $character_id = $request->get('character_id');

        try {
            $character = Character::where('id', $character_id)->firstOrFail();
            $owner = $character->user_id;

            if ($owner !== null) {
                if ($owner !== $user_id) {
                    return response('Character is already claimed.', 403);
                } else {
                    return response('OK', 200);
                }
            }
            $character->user_id = $user_id;
            $character->save();
            return response('OK', 200);
        } catch (ModelNotFoundException $e) {
            return response('Character not found', 404);
        }

    }

    public function unclaim(Request $request)
    {
        $user_id = Auth::user()->id;
        $character_id = $request->get('character_id');

        try {
            $character = Character::where('id', $character_id)->firstOrFail();

            if ($character->user_id !== $user_id) {
                return response('Unauthorised', 401);
            }

            $character->user_id = null;
            $character->save();
            return response('OK', 200);
        } catch (ModelNotFoundException $e) {
            return response('Character not found', 404);
        }
    }

    public function delete(Request $request, $character_id)
    {
        $user = Auth::user();
        try {
            $character = Character::where('id', $character_id)->firstOrFail();
            if ($user->cannot('delete', $character)) {
                return redirect()->route('admin.characters');
            }

            $character->delete();

        } catch (ModelNotFoundException $e) {
            return redirect()->route('admin.characters');
        }
    }
}
