<?php namespace WoWStats\Http\Controllers;

use Illuminate\Http\Request;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function index()
    {
        // Log upload entry point, user selects raid, fight, metrics and then clicks upload.
        return view('logs.upload.index');
    }

    public function storeDeaths(Request $request, $fight)
    {
        if (!$request->hasFile('deaths_csv')) {
            return redirect()->route('raid.fight.view', $fight);
        }
    }
}
