<?php

namespace WoWStats\Jobs;

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
        // Parse the raids fights.
        $start = $this->fight['start'];
        $end = $this->fight['end'];

        $duration = $end - $start;
        $duration = number_format($duration / 1000, 2, '.', '');

        if ($this->fight['kill']) {
            $bossHealth = 0;
        } else {
            $bossHealth = $this->fight['fightPercentage'];
        }

        // Create the fight.
        $fight = RaidFight::create([
            'raid_id' => $this->raidId,
            'boss_id' => $this->fight['boss_id'],
            'killed' => $this->fight['kill'],
            'length' => $duration,
            'logs_url' => $this->logId,
            'boss_health' => $bossHealth
        ]);

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

                    var_dump($m, $metric);

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
}
