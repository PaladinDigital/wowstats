<?php namespace WoWStats\Http\Controllers;

use WoWStats\Models\Raid;
use WoWStats\Models\RaidBoss;
use WoWStats\Models\RaidFight;
use WoWStats\Models\Character;
use WoWStats\Models\RaidAttendee;

class PageController extends Controller
{
    public function raiding()
    {
        return $this->page('raiding');
    }

    public function officers()
    {
        $data = [
            'officers' => [
                (object)[ 'name' => 'Wolirraw' ],
                (object)[ 'name' => 'Murmundamus' ],
                (object)[ 'name' => 'Nuuru' ],
                (object)[ 'name' => 'Sniperdrood' ],
                (object)[ 'name' => 'Labobbob' ],
            ]
        ];
        return $this->page('officers', $data);
    }

    public function page($page, $additionalData = [])
    {
        $data = $this->getData();
        if (!empty($additionalData)) {
            $data = array_merge($data, $additionalData);
        }

        return view('pages.' . $page, $data);
    }
}
