<?php

use Illuminate\Database\Seeder;
use App\User;

class DemoUsersSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user1 = User::create([
            'name' => 'Pending User',
            'display_name' => 'PENDING',
            'email' => 'pending@example.com',
            'password' => bcrypt('pending123')
        ]);
        $user2 = User::create([
            'name' => 'Basic User',
            'display_name' => 'BASIC',
            'email' => 'basic@example.com',
            'password' => bcrypt('basic123')
        ]);
        $user3 = User::create([
            'name' => 'Contributor User',
            'display_name' => 'CONTRIBUTOR',
            'email' => 'contributor@example.com',
            'password' => bcrypt('contributor123')
        ]);
        $user4 = User::create([
            'name' => 'Author User',
            'display_name' => 'AUTHOR',
            'email' => 'author@example.com',
            'password' => bcrypt('author123')
        ]);
        $user5 = User::create([
            'name' => 'Editor User',
            'display_name' => 'EDITOR',
            'email' => 'editor@example.com',
            'password' => bcrypt('editor123')
        ]);
        $user6 = User::create([
            'name' => 'Admin User',
            'display_name' => 'ADMIN',
            'email' => 'admin@example.com',
            'password' => bcrypt('admin123')
        ]);
        $user7 = User::create([
            'name' => 'Super User',
            'display_name' => 'SUPER',
            'email' => 'super@example.com',
            'password' => bcrypt('super123')
        ]);
    }
}
