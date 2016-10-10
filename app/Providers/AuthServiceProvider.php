<?php

namespace WoWStats\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use WoWStats\Models\Raid;
use WoWStats\Models\RaidFight;
use WoWStats\Policies\RaidFightPolicy;
use WoWStats\Policies\RaidPolicy;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'WoWStats\Model' => 'WoWStats\Policies\ModelPolicy',
        Raid::class => RaidPolicy::class,
        RaidFight::class => RaidFightPolicy::class,
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
            return ($user->admin == 1);
        });
    }
}
