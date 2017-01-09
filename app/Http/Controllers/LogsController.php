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
        $csv = 'deaths_csv';

        $deaths_csv = $this->getCsv($request, $csv);
        if ($deaths_csv === false) {
            return redirect()->route('raid.fight.view', $fight);
        }

        $deaths_csv = $request->file($csv);
        var_dump($deaths_csv);
    }

    /**
     * Validates the presence of uploaded csv file.
     *
     * @param $request
     * @param $tag
     * @return bool
     */
    public function validateCsv($request, $tag)
    {
        if (!$request->hasFile($tag)) {
            return false;
        }

        if (!$request->file($tag)->isValid()) {
            return false;
        }

        return true;
    }

    public function getCsv($request, $tag)
    {
        // Input key exists.
        if (!$this->validateCsv($request, $tag)) {
            return false;
        }

        $csv = $request->file($tag);
        return $csv;
    }
}
