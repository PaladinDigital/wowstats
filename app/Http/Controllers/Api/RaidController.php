<?php namespace WoWStats\Http\Controllers\Api;

use Illuminate\Http\Request;
use WoWStats\Http\Controllers\Controller;

class RaidController extends Controller
{
    public function store(Request $request)
    {
        $data = [
            'raidzone_id' => $request->input('raidzone_id'),
        ];
        /* Get and Convert Date */
        $date = $request->input('date');
        $date = Date::convertDate($date, 'dd/mm/yyyy', 'mysql');
        $data['date'] = $date;
    }
}