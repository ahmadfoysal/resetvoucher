<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class AddToken extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'users:generate-token';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Add api token to user database';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $this->info('Adding token to user database...');

        //add api token to all users
        $users = \App\Models\User::all();
        foreach ($users as $user) {
            $user->api_token = bin2hex(random_bytes(30));
            $user->save();
            $this->info('Token added to user: ' . $user->name);
        }
    }
}
