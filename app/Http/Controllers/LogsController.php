<?php namespace WoWStats\Http\Controllers;

use Illuminate\Database\Eloquent\ModelNotFoundException;
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

        return redirect()->route('raid.fight.view', [$raid_id, $fight_id]);
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

            // All
            case 'deaths':
                $deaths = $this->buildDeathsArray($reader);
                // Get the deaths metric id.
                $metric_id = Metric::where('name', 'deaths')->first()->id;
                // Create the character stats.
                foreach ($deaths as $character => $death_count) {
                    // Check if the character exists
                    if (Character::characterExists($character)) {
                        $char = Character::where('name', $character)->firstOrFail();

                        // Check if the stat already exists
                        $exists = CharacterStats::exists($fight_id, $char->id, $metric_id);

                        if (!$exists) {
                            $data = [
                                'fight_id' => $fight_id,
                                'character_id' => $char->id,
                                'metric_id' => $metric_id,
                                'value' => $death_count,
                            ];

                            CharacterStats::create($data);
                        }
                    }
                }
                break;

            // DPS
            case 'damage':
            case 'dps':
                $damageStats = $this->buildDamageArray($reader);
                // Get the deaths metric id.
                $damage_id = Metric::where('name', 'damage')->first()->id;
                $dps_id = Metric::where('name', 'dps')->first()->id;

                $dps = $damageStats['dps'];
                $damage = $damageStats['damage'];

                // Create the DPS stats.
                foreach ($dps as $character => $dps_value) {
                    // Check if the character exists
                    if (Character::characterExists($character)) {
                        $char = Character::where('name', $character)->firstOrFail();

                        // Check if the stat already exists
                        $exists = CharacterStats::exists($fight_id, $char->id, $dps_id);

                        if (!$exists) {
                            $data = [
                                'fight_id' => $fight_id,
                                'character_id' => $char->id,
                                'metric_id' => $dps_id,
                                'value' => $dps_value,
                            ];

                            CharacterStats::create($data);
                        }
                    }
                }

                // Create the Damage stats.
                foreach ($damage as $character => $damage_done) {
                    // Check if the character exists
                    if (Character::characterExists($character)) {
                        $char = Character::where('name', $character)->firstOrFail();

                        // Check if the stat already exists
                        $exists = CharacterStats::exists($fight_id, $char->id, $damage_id);

                        if (!$exists) {
                            $data = [
                                'fight_id' => $fight_id,
                                'character_id' => $char->id,
                                'metric_id' => $damage_id,
                                'value' => $damage_done,
                            ];

                            CharacterStats::create($data);
                        }
                    }
                }
                break;

            // Tanking
            case 'damage_taken':
            case 'dtps':
            $damageTakenStats = $this->buildTankingArray($reader);
            // Get the deaths metric id.
            $damage_taken_id = Metric::where('name', 'damage_taken')->first()->id;
            $dtps_id = Metric::where('name', 'dtps')->first()->id;

            $dtps = $damageTakenStats['dtps'];
            $damage_taken = $damageTakenStats['damage_taken'];

            // Create the DTPS stats.
            foreach ($dtps as $character => $dtps_value) {
                // Check if the character exists
                if (Character::characterExists($character)) {
                    $char = Character::where('name', $character)->firstOrFail();

                    // Check if the stat already exists
                    $exists = CharacterStats::exists($fight_id, $char->id, $dtps_id);

                    if (!$exists) {
                        $data = [
                            'fight_id' => $fight_id,
                            'character_id' => $char->id,
                            'metric_id' => $dtps_id,
                            'value' => $dtps_value,
                        ];

                        CharacterStats::create($data);
                    }
                }
            }

            // Create the DamageTaken stats.
            foreach ($damage_taken as $character => $damage_taken_value) {
                // Check if the character exists
                if (Character::characterExists($character)) {
                    $char = Character::where('name', $character)->firstOrFail();

                    // Check if the stat already exists
                    $exists = CharacterStats::exists($fight_id, $char->id, $damage_taken_id);

                    if (!$exists) {
                        $data = [
                            'fight_id' => $fight_id,
                            'character_id' => $char->id,
                            'metric_id' => $damage_taken_id,
                            'value' => $damage_taken_value,
                        ];

                        CharacterStats::create($data);
                    }
                }
            }
            break;

            // Healing
            case 'healing':
            case 'hps':
                $healingStats = $this->buildHealingArray($reader);
                // Get the deaths metric id.
                $healing_id = Metric::where('name', 'healing')->first()->id;
                $hps_id = Metric::where('name', 'hps')->first()->id;

                $hps = $healingStats['hps'];
                $healing = $healingStats['healing'];

                // Create the HPS stats.
                foreach ($hps as $character => $hps_value) {
                    // Check if the character exists
                    if (Character::characterExists($character)) {
                        $char = Character::where('name', $character)->firstOrFail();

                        // Check if the stat already exists
                        $exists = CharacterStats::exists($fight_id, $char->id, $hps_id);

                        if (!$exists) {
                            $data = [
                                'fight_id' => $fight_id,
                                'character_id' => $char->id,
                                'metric_id' => $hps_id,
                                'value' => $hps_value,
                            ];

                            CharacterStats::create($data);
                        }
                    }
                }

                // Create the Healing stats.
                foreach ($healing as $character => $healing_done) {
                    // Check if the character exists
                    if (Character::characterExists($character)) {
                        $char = Character::where('name', $character)->firstOrFail();

                        // Check if the stat already exists
                        $exists = CharacterStats::exists($fight_id, $char->id, $healing_id);

                        if (!$exists) {
                            $data = [
                                'fight_id' => $fight_id,
                                'character_id' => $char->id,
                                'metric_id' => $healing_id,
                                'value' => $healing_done,
                            ];

                            CharacterStats::create($data);
                        }
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

    public function buildHealingArray($reader)
    {
        $healing = [];
        $hps = [];
        foreach ($reader as $index => $row) {
            // Skip headers
            if ($index === 0) {
                continue;
            }

            // $row[0] = Perf%,
            // $row[1] = Character
            // $row[2] = Amount "raw$percent%shortm"
            // $row[3] = Overheal
            // $row[4] = iLvl
            // $row[5] = iLvl %
            // $row[6] = Active
            // $row[7] = HPS
            $character = $row[1];

            $healing_amount = $this->extractWlMetricShortform($row[2]);
            $hps_amount = $this->floatValue($row[7]);

            $healing[$character] = $healing_amount;
            $hps[$character] = $hps_amount;
        }

        return [
            'healing' => $healing,
            'hps' => $hps,
        ];
    }

    public function buildDamageArray($reader)
    {
        $damage = [];
        $dps = [];
        foreach ($reader as $index => $row) {
            // Skip headers
            if ($index === 0) {
                continue;
            }

            // $row[0] = Perf%,
            // $row[1] = Character
            // $row[2] = Amount "raw$percent%shortm"
            // $row[3] = iLvl
            // $row[4] = iLvl %
            // $row[5] = Active
            // $row[6] = DPS
            $character = $row[1];

            $damage_amount = $this->extractWlMetricShortform($row[2]);
            $dps_amount = $this->floatValue($row[6]);

            $damage[$character] = $damage_amount;
            $dps[$character] = $dps_amount;
        }

        return [
            'damage' => $damage,
            'dps' => $dps,
        ];
    }

    public function buildTankingArray($reader)
    {
        $damage_taken = [];
        $dtps = [];
        foreach ($reader as $index => $row) {
            // Skip headers
            if ($index === 0) {
                continue;
            }

            // $row[0] = Character
            // $row[1] = Amount "raw$percent%shortm"
            // $row[2] = iLvl
            // $row[3] = Active
            // $row[4] = DTPS

            $character = $row[0];

            $damage_taken_amount = $this->extractWlMetricShortform($row[1]);
            $dtps_amount = $this->floatValue($row[4]);

            $damage_taken[$character] = $damage_taken_amount;
            $dtps[$character] = $dtps_amount;
        }

        return [
            'damage_taken' => $damage_taken,
            'dtps' => $dtps,
        ];
    }

    public function extractWlMetricShortform($column)
    {
        // "raw$percent%shortm"
        // Returns the final part of the string (ie 128.22m = 128.22).

        $shortform_explode = explode("%", $column);
        $shortform = $shortform_explode[1];
        $shortform = str_replace('m', '', $shortform);
        return (float)$shortform;
    }

    public function floatValue($column)
    {
        // "raw$percent%shortm"
        $value = str_replace(',', "", $column);
        return (float)$value;
    }
}
