<?php

class CharacterRolesSeeder extends Seeder {

    public function run() {
        $roles = [
            'Tank',
            'Healer',
            'DPS'
        ];

        foreach ($roles as $role) {
            PlayerRole::create(['name' => $role]);
        }
    }
}
