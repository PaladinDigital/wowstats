<?php

namespace WoWStats\Policies;

use WoWStats\User;
use WoWStats\Models\CharacterStats;
use Illuminate\Auth\Access\HandlesAuthorization;

class CharacterStatsPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->can('administrate')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the characterStats.
     *
     * @param  WoWStats\User  $user
     * @param  WoWStats\Models\CharacterStats  $characterStats
     * @return mixed
     */
    public function view(User $user, CharacterStats $characterStats)
    {
        //
    }

    /**
     * Determine whether the user can create characterStats.
     *
     * @param  WoWStats\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the characterStats.
     *
     * @param  WoWStats\User  $user
     * @param  WoWStats\Models\CharacterStats  $characterStats
     * @return mixed
     */
    public function update(User $user, CharacterStats $characterStats)
    {
        //
    }

    /**
     * Determine whether the user can delete the characterStats.
     *
     * @param  WoWStats\User  $user
     * @param  WoWStats\Models\CharacterStats  $characterStats
     * @return mixed
     */
    public function delete(User $user, CharacterStats $characterStats)
    {
        //
    }
}
