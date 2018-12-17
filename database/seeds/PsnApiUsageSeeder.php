<?php

use Illuminate\Database\Seeder;

class PsnApiUsageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        for($i=1;$i<32;$i++){
            DB::table('psn_api_usage')->insert([
                'count' => 0,
                "updated_at" => \Carbon\Carbon::now()
            ]);
        }
    }
}
