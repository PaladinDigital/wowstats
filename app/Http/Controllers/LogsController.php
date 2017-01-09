<?php namespace WoWStats\Http\Controllers;

use Illuminate\Http\Request;
use WoWStats\Models\Character;
use WoWStats\Models\CharacterStats;
use WoWStats\Models\Metric;
use League\Csv\Reader as CsvReader;

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

    public function store(Request $request, $raid_id, $fight_id)
    {
        $metric = $request->get('metric');
        $csv = $this->getCsv($request, $metric . '_csv');

        $this->storeMetrics($csv, $metric, $fight_id);
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

    public function storeMetrics($csv, $metric, $fight_id)
    {
        $reader = CsvReader::createFromPath($csv->path());

        switch ($metric) {
            case 'deaths':
                $deaths = $this->buildDeathsArray($reader);
                // Get the deaths metric id.
                $metric_id = Metric::where('name', 'deaths')->id;
                // Create the character stats.
                foreach ($deaths as $character => $death_count) {
                    // Check if the character exists
                    if (Character::characterExists($character)) {
                        $char = Character::where('name', $character)->firstOrFail();

                        $data = [
                            'fight_id' => $fight_id,
                            'character_id' => $char->id,
                            'metric_id' => $metric_id,
                            'value' => $death_count,
                        ];

                        return CharacterStats::create($data);
                    }
                }
                break;
            default:
                break;
        }
    }

    /**
     * Build an array with the count of each characters deaths.
     * @param $reader
     * @return array
     */
    public function buildDeathsArray($reader)
    {
        $deaths = [];
        foreach ($reader as $index => $row) {
            // Skip headers
            if ($index === 0) {
                continue;
            }

            // $row[0] = Time,
            // $row[1] = Event.
            $event = $row[1];
            $words = explode(' ', $event);
            $character = $words[0];
            if (!array_key_exists($character, $deaths)) {
                $deaths[$character] = 1;
            } else {
                $deaths[$character] = $deaths[$character] + 1;
            }
        }

        return $deaths;
    }
}
