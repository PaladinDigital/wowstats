<?php

use Illuminate\Database\Seeder;
use WoWStats\Models\CharacterRole;

class CharacterRolesSeeder extends Seeder
{
    public function run()
    {
        $roles = [
            'Tank',
            'Healer',
            'DPS'
        ];

        foreach ($roles as $role) {
            if (!CharacterRole::exists($role)) {
                CharacterRole::create(['name' => $role]);
            }
        }
    }
}
