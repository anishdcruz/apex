<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\User;

class Setup extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Setup basic features.';

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
        $this->defaultAdmin();
    }

    private function defaultAdmin()
    {
        User::create([
            'name' => 'Default Admin',
            'email' => 'admin@apex.dev',
            'password' => bcrypt('password')
        ]);
    }
}
