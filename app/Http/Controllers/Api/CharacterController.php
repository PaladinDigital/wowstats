<?php namespace WoWStats\Http\Controllers\Api;

use Auth;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use WoWStats\Http\Controllers\Controller;
use Carbon\Carbon;
use WoWStats\Models\Character;

class CharacterController extends Controller
{
    public function store(Request $request)
    {
        $this->authorize('create', Character::class);

        $this->validate($request, [
            'name' => 'required|unique:characters,name',
            'class_id' => 'required|integer',
            'main_role_id' => 'integer|min:0|max:3',
            'os_role_id' => 'integer|min:0|max:3',
        ]);

        $data = $request->only(['name', 'class_id', 'main_role_id', 'os_role_id']);

        Character::create($data);
    }

    public function storeSpec(Request $request)
    {
        $this->validate($request, [
            'id' => 'required',
            'main_role_id' => 'integer|min:0|max:3',
            'os_role_id' => 'integer|min:0|max:3',
        ]);

        $data = $request->only(['id', 'main_role_id', 'os_role_id']);

        try {
            $char = Character::where('id', $data['id'])->first();
            if (array_key_exists('main_role_id', $data)) {
                $char->main_role_id = $data['main_role_id'];
            }
            if (array_key_exists('os_role_id', $data)) {
                $char->os_role_id = $data['os_role_id'];
            }
            $char->save();
        } catch (ModelNotFoundException $e) {
            return false;
        }
    }
}
