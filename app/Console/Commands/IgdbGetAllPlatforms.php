<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

class IgdbGetAllPlatforms extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'igdb:getAllPlatforms';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Downloads ALL known platforms';

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
        echo "==== GetAllPlatforms ===" . PHP_EOL;
        //Build Missing Games Array
        $platformIds = [];
        for ($i=1;$i<200; $i++){
            array_push($platformIds,$i);
        }
        echo PHP_EOL . "Missing Games: " . count($platformIds) . PHP_EOL;

        $reqApiCalls = count($platformIds) / 50 . PHP_EOL;

        echo "New Games to Locate: " . count($platformIds) . PHP_EOL;
        echo "Required API Calls: " . ceil($reqApiCalls) . PHP_EOL;

        $grpCtr=1;
        $platformGroups=[];
        $platformGroupId=0;
        $platformList="";
        $ctr=1;

        foreach($platformIds as $platform){
            if($ctr==count($platformIds)){
                $platformList .= $platform .",";
                $platformGroups[$platformGroupId] = rtrim($platformList, ",");
            } else if($grpCtr<50){
                $platformList .= $platform .",";
                $grpCtr++;
            } else {
                $platformList .= $platform .",";
                $platformGroups[$platformGroupId] = rtrim($platformList, ",");
                $platformList="";
                $grpCtr=1;
                $platformGroupId++;
            }
            $ctr++;
        }

        $ctr=1;
        foreach ($platformGroups as $platform){
            echo $ctr . "/" . ceil($reqApiCalls) . PHP_EOL;
            $this->getPlatform($platform);
            $ctr++;
        }

        $this->call('igdb:loadPlatformsTable');
    }

    private function getPlatform($i){
        echo "Loading " . count(explode(',',$i)) . " records..." .PHP_EOL;
        $platforms = \IGDB::getPlatforms($i);
        if ($platforms!=false){
            sleep(2);
            foreach ($platforms as $platform){
                echo $platform->id . "_" . $platform->slug .'.json' .PHP_EOL;
                $fp = fopen("resources/igdb/platforms/" . $platform->id . "_" . $platform->slug .'.json', 'w');
                fwrite($fp, json_encode($platform));
                fclose($fp);
            }
        } else {
            echo "FAILED".PHP_EOL;
        }
    }
}
