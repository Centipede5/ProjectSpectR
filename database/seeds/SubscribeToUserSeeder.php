<?php

use Illuminate\Database\Seeder;

class SubscribeToUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // This is going to setup random user subscribers using the dummy users
        for($id=8;$id<200;$id++){
            DB::table('subscribe_to_user')->insert([
                'subscription_id' => rand(8,47),
                'user_id' => rand(8,47),
                "created_at" =>  \Carbon\Carbon::now(),
                "updated_at" => \Carbon\Carbon::now()
            ]);
        }
    }
}
