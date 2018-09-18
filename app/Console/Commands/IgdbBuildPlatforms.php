<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Messerli90\IGDB\IGDBServiceProvider;

class IgdbBuildPlatforms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igdb:buildPlatforms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Command description';

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
        //


	for($i=0;$i<50;$i++){
        $platform = \IGDB::getPlatform($i);
	if ($platform!=false){
        $fp = fopen("resources/igdb/".$platform->slug.'.json', 'w');
        fwrite($fp, json_encode($platform));
        fclose($fp);
	} else {
		echo "false".PHP_EOL;
	}
	}
    }
}
