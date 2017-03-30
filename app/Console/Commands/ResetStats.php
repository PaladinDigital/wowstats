<?php

namespace WoWStats\Console\Commands;

use \DB;
use Illuminate\Console\Command;

class ResetStats extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'reset:stats';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Reset all fights and associate stats. Cannot be undone.';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $confirmed = $this->confirm('Are you sure you wish to remove all stats');

        if ($confirmed) {
            $tables = [
                'raids',
                'raid_fights',
                'character_raid_stats'
            ];

            foreach ($tables as $t) {
                $deleted = DB::delete("delete from {$t}");
            }

            return $this->line('Stats reset.');
        }
    }
}
