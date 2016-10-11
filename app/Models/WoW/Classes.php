<?php namespace WoWStats\Models\WoW;

Class Classes
{
    public $class_data;

    public function __construct()
    {
        $this->class_data = [
            1 => ['class' => 'Warrior', 'color' => '#C79C6E'],
            2 => ['class' => 'Paladin', 'color' => '#F58CBA'],
            3 => ['class' => 'Hunter', 'color' => '#ABD473'],
            4 => ['class' => 'Rogue', 'color' => '#FFF569'],
            5 => ['class' => 'Priest', 'color' => '#FFFFFF'],
            6 => ['class' => 'Death Knight', 'color' => '#C41F3B'],
            7 => ['class' => 'Shaman', 'color' => '#0070DE'],
            8 => ['class' => 'Mage', 'color' => '#69CCF0'],
            9 => ['class' => 'Warlock', 'color' => '#9482C9'],
            10 => ['class' => 'Monk', 'color' => '#00FF96'],
            11 => ['class' => 'Druid', 'color' => '#FF7D0A'],
            12 => ['class' => 'Demon Hunter', 'color' => '#A330C9']
        ];
    }

    /***
     * Get the textual representation of a characters class
     * @param integer $class_id
     * @return string
     */
    public function getClassName($class_id)
    {
        if (!array_key_exists($class_id, $this->class_data)) { \Log::debug("Class_id not found."); }
        if (!isset($this->class_data[$class_id])) { \Log::debug("Class_id key is not set." . $class_id); }
        if (!isset($this->class_data[$class_id]['class'])) { \Log::debug("Class key is not set." . $class_id); }
        return $this->class_data[$class_id]['class'];
    }

    public function getClassId($class_name)
    {
        foreach($this->class_data as $id => $data) {
            $class = $data['class'];
            if ($class == $class_name) {
                return $id;
            }
        }
        return null;
    }

    public function getDisplayName($class_name)
    {
        switch ($class_name)
        {
            case 'Death Knight':
                $display_class = 'death_knight';
                break;
            case 'Demon Hunter':
                $display_class = 'demon_hunter';
                break;
            default:
                $display_class = lcfirst($class_name);
                break;
        }

        return $display_class;
    }

    public function getClassColor($identifier)
    {
        if (strlen($identifier) > 2) {
            $identifier = intval($identifier);
        } else {
            /* Convert to class id if a string is passed in */
            if (is_string($identifier)) {
                $identifier = intval($identifier);
                if ($identifier === null) { return '#FFFFFF'; }
            }
        }

        $color = $this->class_data[$identifier]['color'];
        return $color;
    }
}
