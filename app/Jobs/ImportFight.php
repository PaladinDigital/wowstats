<?php

namespace WoWStats\Jobs;

use Illuminate\Support\Facades\Log;
use WoWStats\Models\Character;
use WoWStats\Models\CharacterStats;
use WoWStats\Models\Metric;
use Illuminate\Bus\Queueable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use WoWStats\Models\RaidFight;
use WoWStats\Services\WarcraftLogs;

class ImportFight implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $raidId;
    protected $logId;
    protected $fight;
    public $service;

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($raidId, $logId, $fight)
    {
        $this->raidId = $raidId;
        $this->logId = $logId;
        $this->fight = $fight;
        $this->service = new WarcraftLogs($logId);
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $debug = config('app.debug');

        if ($debug) {
            Log::debug('Importing fight');
        }

        // Parse the raids fights.
        $start = $this->fight['start'];
        $end = $this->fight['end'];
        $bossId = $this->mapBossId($this->fight['boss_id']);

        if ($debug) {
            Log::debug('WCL Boss ID: ' . $this->fight['boss_id']);
            Log::debug('WoW Boss ID: ' . $bossId);
        }

        $duration = $end - $start;
        $duration = number_format($duration / 1000, 2, '.', '');

        if ($this->fight['kill']) {
            $bossHealth = 0;
            $kill = true;
        } else {
            $bossHealth = $this->fight['percent'];
            $kill = false;
        }

        if ($debug) {
            $status = ($kill === true) ? 'killed' : 'wipe';
            Log::debug('Kill: ' . $status);
        }

        // Create the fight.
        $raidFightData = [
            'raid_id' => $this->raidId,
            'boss_id' => $bossId,
            'killed' => $kill,
            'length' => $duration,
            'logs_url' => $this->logId,
            'boss_health' => $bossHealth
        ];

        if ($debug) {
            Log::debug('Fight Data');
            Log::debug($raidFightData);
        }

        $fight = RaidFight::create($raidFightData);

        // Create the metrics for the fight.
        $metricData = $this->service->getFightData($start, $end);

        foreach ($metricData as $character => $data) {
            // IF the character doesn't exist create them

            if (!Character::characterExists($character)) {
                $char = Character::create([
                    'name' => $character,
                    'class_id' => $data['class_id'],
                ]);
            } else {
                $char = Character::where('name', $character)->first();
            }

            // Set character metrics.
            foreach ($data as $metric => $value) {
                if ($metric !== 'class_id') {
                    switch ($metric) {
                        case 'itemLevel': $metric = 'item_level'; break;
                        case 'damage-taken': $metric = 'damage_taken'; break;
                        case 'damage-done': $metric = 'damage'; break;
                        default: break;
                    }
                    $m = Metric::where('name', $metric)->first();

                    // Create the Character stats for each metric.
                    CharacterStats::create([
                        'fight_id' => $fight->id,
                        'character_id' => $char->id,
                        'metric_id' => $m->id,
                        'value' => $value
                    ]);
                }
            }
        }
    }

    /**
     * Convert Warcraft Logs Boss Id into WoW / WoWHead Boss Ids.
     *
     * @param integer $bossId WarcraftLogs Boss ID.
     * @param string $source Mapping Source.
     *
     * @return mixed
     */
    public function mapBossId($bossId, $source = 'wcl')
    {
        $bosses = [
            // The Nighthold
            1849 => 102263, // Skorpyron
            1865 => 104415, // Chronomatic Anomoly

            // Antorus
            2076 => 123371, // Garothi
            2074 => 126916, // Felhounds
            2064 => 124393, // Portal Keeper
            2075 => 131561, // Eonar
            2070 => 122367, // High Command

            2082 => 125055, // 'Imonar the Soulhunter'
            2088 => 125050, // "Kin'garoth"

            2073 => 122468, // Coven
            2069 => 125075, // 'Varimathras'
            2063 => 124691, // 'Aggramar'

            2092 => 124828, // 'Argus the Unmaker'
        ];

        if ($source === 'wcl') {
            if (array_key_exists($bossId, $bosses)) {
                return $bosses[$bossId];
            }
        }

        return $bossId;
    }
}
