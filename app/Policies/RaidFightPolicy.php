<?php

namespace WoWStats\Policies;

use WoWStats\User;
use WoWStats\Models\RaidFight;
use Illuminate\Auth\Access\HandlesAuthorization;

class RaidFightPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->can('administrate')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the raidFight.
     *
     * @param  WoWStats\User  $user
     * @param  WoWStats\Models\RaidFight  $raidFight
     * @return mixed
     */
    public function view(User $user, RaidFight $raidFight)
    {
        //
    }

    /**
     * Determine whether the user can create raidFights.
     *
     * @param  WoWStats\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the raidFight.
     *
     * @param  WoWStats\User  $user
     * @param  WoWStats\Models\RaidFight  $raidFight
     * @return mixed
     */
    public function update(User $user, RaidFight $raidFight)
    {
        //
    }

    /**
     * Determine whether the user can delete the raidFight.
     *
     * @param  WoWStats\User  $user
     * @param  WoWStats\Models\RaidFight  $raidFight
     * @return mixed
     */
    public function delete(User $user, RaidFight $raidFight)
    {
        //
    }
}
