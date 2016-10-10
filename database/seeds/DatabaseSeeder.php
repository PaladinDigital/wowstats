<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Eloquent::unguard();
        $this->call(RaidZoneSeeder::class);
        $this->call(PlayerRolesSeeder::class);
        $this->call(RaidBossSeeder::class);
    }
}
