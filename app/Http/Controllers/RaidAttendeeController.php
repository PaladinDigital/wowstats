<?php

use Lom\Security\ACL;

class RaidAttendeeController extends BaseController
{

    // Lists all raids recorded on the site.
    public function api_store()
    {
        $data = [
            "raid_id" => Input::get('raid_id'),
            "player_id" => Input::get('player_id'),
        ];
        $acl = new ACL();
        if ($acl->isAdmin()) {
            if (RaidAttendee::valid($data)) {
                RaidAttendee::create($data);
            } else {
                \Log::debug('RaidAttendee data invalid');
                \Log::debug($data);
            }
        }

    }
}
