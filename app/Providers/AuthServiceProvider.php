<?php namespace WoWStats\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use WoWStats\Models\Character;
use WoWStats\Models\CharacterStats;
use WoWStats\Models\Raid;
use WoWStats\Models\RaidAttendee;
use WoWStats\Policies\CharacterPolicy;
use WoWStats\Policies\CharacterStatsPolicy;
use WoWStats\Policies\RaidAttendeePolicy;
use WoWStats\Policies\RaidPolicy;

use WoWStats\Models\RaidFight;
use WoWStats\Policies\RaidFightPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        Raid::class => RaidPolicy::class,
        RaidFight::class => RaidFightPolicy::class,
        Character::class => CharacterPolicy::class,
        RaidAttendee::class => RaidAttendeePolicy::class,
        CharacterStats::class => CharacterStatsPolicy::class,
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::define('administrate', function ($user) {
            return ($user->isAdmin());
        });
    }
}
