<?php

namespace WoWStats\Console\Commands;

use Illuminate\Console\Command;
use WoWStats\User;

class PromoteUser extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'promote:user';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Promote a user to administrator.';

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
        $users = User::where('admin', 0)->get(['id', 'name', 'email']);

        if (count($users) == 0) {
            return $this->info('There are no users to promote.');
        }

        // List users to select
        $headers = ['id', 'name', 'email'];
        $this->table($headers, $users->toArray());

        $valid_ids = [];
        foreach ($users as $u) {
            $valid_ids[] = $u['id'];
        }

        // Ask which user to promote
        $id  = $this->choice('Which user would you like to promote?', $valid_ids, null);

        // Confirm choice
        $user = User::where('id', $id)->first();
        if ($this->confirm('Are you sure you wish to promote: ' . $user->name . '?')) {
            $user->admin = 1;
            $user->save();
        }
    }
}
