<?php

namespace WoWStats\Policies;

use WoWStats\User;
use WoWStats\Models\Raid;
use Illuminate\Auth\Access\HandlesAuthorization;

class RaidPolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->can('administrate')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the raid.
     *
     * @param  WoWStats\User  $user
     * @param  WoWStats\Models\Raid  $raid
     * @return mixed
     */
    public function view(User $user, Raid $raid)
    {
        return true;
    }

    /**
     * Determine whether the user can create raids.
     *
     * @param  WoWStats\User $user
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->can('administrate');
    }

    /**
     * Determine whether the user can update the raid.
     *
     * @param  WoWStats\User        $user
     * @param  WoWStats\Models\Raid $raid
     * @return mixed
     */
    public function update(User $user, Raid $raid)
    {
        return $user->can('administrate');
    }

    /**
     * Determine whether the user can delete the raid.
     *
     * @param  WoWStats\User        $user
     * @param  WoWStats\Models\Raid $raid
     * @return mixed
     */
    public function delete(User $user, Raid $raid)
    {
        //
    }
}
