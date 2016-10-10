<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        Eloquent::unguard();
        $this->call(CharacterRolesSeeder::class);
        $this->call(RaidBossSeeder::class);
        $this->call(RaidZoneSeeder::class);
    }
}
