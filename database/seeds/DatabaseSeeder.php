<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $this->call([
            RolesSeeder::class,
            DemoUsersSeeder::class,
            DemoRoleUsersSeeder::class,
            DemoUsersInfoSeeder::class,
            SubscribeToUserSeeder::class,
            DefaultSlidesForSliders::class,
            GameTableSeeder::class
        ]);
    }
}
