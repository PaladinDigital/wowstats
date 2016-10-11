<?php

namespace WoWStats\Policies;

use WoWStats\User;
use WoWStats\Models\Character;
use Illuminate\Auth\Access\HandlesAuthorization;

class CharacterPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->can('administrate')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the character.
     *
     * @param  WoWStats\User  $user
     * @param  WoWStats\Models\Character  $character
     * @return mixed
     */
    public function view(User $user, Character $character)
    {
    }

    /**
     * Determine whether the user can create characters.
     *
     * @param  WoWStats\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the character.
     *
     * @param  WoWStats\User  $user
     * @param  WoWStats\Models\Character  $character
     * @return mixed
     */
    public function update(User $user, Character $character)
    {
        //
    }

    /**
     * Determine whether the user can delete the character.
     *
     * @param  WoWStats\User  $user
     * @param  WoWStats\Models\Character  $character
     * @return mixed
     */
    public function delete(User $user, Character $character)
    {
        //
    }
}
