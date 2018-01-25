<?php

namespace WoWStats\Services\WCL;

class Specialization
{
    public function isHealingSpecialization($icon)
    {
        $icons = [
            'Druid-Restoration',
            'Monk-Mistweaver',
            'Paladin-Holy',
            'Priest-Discipline',
            'Priest-Holy',
        ];
        return in_array($icon, $icons);
    }

    public function isTankSpecialization($icon)
    {
        $icons = [
            'DeathKnight-Blood',
            'Druid-Guardian',
            'Paladin-Protection',
            'Warrior-Protection',
        ];
        return in_array($icon, $icons);
    }

    public function isDpsSpecialization($icon)
    {
        if ($this->isTankSpecialization($icon)) {
            return false;
        }

        if ($this->isHealingSpecialization($icon)) {
            if ($icon === 'Priest-Discipline') {
                return true;
            }
            return false;
        }

        return true;
    }
}