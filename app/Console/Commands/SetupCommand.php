<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class SetupCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'epione:setup';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Sets up the project for testing.';

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
        $this->info('Setting up project...');

        $this->call('key:generate');
        $this->call('jwt:secret');
        $this->call('migrate:fresh');
        $this->call('db:seed');
    }
}
