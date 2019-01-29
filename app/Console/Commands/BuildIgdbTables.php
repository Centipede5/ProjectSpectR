<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class BuildIgdbTables extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igdb:buildIgdbTables';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'The One Single Command that will call all of the other individual commands to build ALL othe IGDB tables';

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
        $this->call('igdb:loadPlatformsTable');
        $this->call('igdb:loadIgdbGameIdsTable');
    }
}
