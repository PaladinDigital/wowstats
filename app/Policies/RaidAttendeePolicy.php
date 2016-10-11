<?php

namespace WoWStats\Policies;

use WoWStats\User;
use WoWStats\Models\RaidAttendee;
use Illuminate\Auth\Access\HandlesAuthorization;

class RaidAttendeePolicy
{
    use HandlesAuthorization;

    public function before($user, $ability)
    {
        if ($user->can('administrate')) {
            return true;
        }
    }

    /**
     * Determine whether the user can view the modelsRaidAttendee.
     *
     * @param  WoWStats\User  $user
     * @param  WoWStats\Models\RaidAttendee  $modelsRaidAttendee
     * @return mixed
     */
    public function view(User $user, RaidAttendee $modelsRaidAttendee)
    {
        //
    }

    /**
     * Determine whether the user can create modelsRaidAttendees.
     *
     * @param  WoWStats\User  $user
     * @return mixed
     */
    public function create(User $user)
    {
    }

    /**
     * Determine whether the user can update the modelsRaidAttendee.
     *
     * @param  WoWStats\User  $user
     * @param  WoWStats\Models\RaidAttendee  $modelsRaidAttendee
     * @return mixed
     */
    public function update(User $user, ModelsRaidAttendee $modelsRaidAttendee)
    {
    }

    /**
     * Determine whether the user can delete the modelsRaidAttendee.
     *
     * @param  WoWStats\User  $user
     * @param  WoWStats\Models\RaidAttendee  $modelsRaidAttendee
     * @return mixed
     */
    public function delete(User $user, ModelsRaidAttendee $modelsRaidAttendee)
    {
    }
}
