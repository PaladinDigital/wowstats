<?php namespace WoWStats\Http\Controllers;

use Illuminate\Http\Request;
use WoWStats\Models\Metric;

class LogsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth');
    }

    public function importForm($raid_id, $fight_id)
    {
        $data = $this->getData();
        $metrics = Metric::all();
        $data['metrics'] = $metrics;
        $data['raid_id'] = $raid_id;
        $data['fight_id'] = $fight_id;
        // Log upload entry point, user selects raid, fight, metrics and then clicks upload.
        return view('logs.upload.import', $data);
    }

    public function store(Request $request, $fight_id)
    {
        $metric = $request->get('metric');
        $csv = $this->getCsv($request, $metric . '_csv');

        switch ($metric) {
            case 'deaths':
                break;
            default:
                break;
        }

        var_dump($csv);
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
