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
        // $this->call(UsersTableSeeder::class);
        $this->call(RolesSeeder::class);
        $this->call(DemoUsersSeeder::class);
        $this->call(DemoRoleUsersSeeder::class);
        $this->call(SubscribeToUserSeeder::class);
    }
}
