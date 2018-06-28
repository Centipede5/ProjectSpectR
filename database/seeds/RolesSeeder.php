<?php

use Illuminate\Database\Seeder;
use App\Role;

class RolesSeeder extends Seeder
{
    public function run()
    {
        $pending = Role::create([
            'name' => 'Pending',
            'slug' => 'pending',
            'permissions' => [
                'update-profile' => true
            ]
        ]);
        $basic = Role::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'permissions' => [
                'update-profile' => true,
                'comment-on-post' => true
            ]
        ]);
        $contributor = Role::create([
            'name' => 'Contributor',
            'slug' => 'contributor',
            'permissions' => [
                'update-profile' => true,
                'comment-on-post' => true,
                'create-post' => true,
                'update-post' => true,
                'publish-post' => true,
                'post-limit' =>  true
            ]
        ]);
        $author = Role::create([
            'name' => 'Author',
            'slug' => 'author',
            'permissions' => [
                'update-profile' => true,
                'comment-on-post' => true,
                'create-post' => true,
                'update-post' => true,
                'publish-post' => true,
                'post-limit' =>  false
            ]
        ]);
        $editor = Role::create([
            'name' => 'Editor',
            'slug' => 'editor',
            'permissions' => [
                'update-profile' => true,
                'comment-on-post' => true,
                'create-post' => true,
                'update-post' => true,
                'publish-post' => true,
                'post-limit' =>  false,
                'site-moderator' => true
            ]
        ]);
        $admin = Role::create([
            'name' => 'Admin',
            'slug' => 'admin',
            'permissions' => [
                'update-profile' => true,
                'comment-on-post' => true,
                'create-post' => true,
                'update-post' => true,
                'publish-post' => true,
                'post-limit' =>  false,
                'site-moderator' => true,
                'site-admin' => true
            ]
        ]);
        $superAdmin = Role::create([
            'name' => 'Super Admin',
            'slug' => 'super',
            'permissions' => [
                'update-profile' => true,
                'comment-on-post' => true,
                'create-post' => true,
                'update-post' => true,
                'publish-post' => true,
                'post-limit' =>  false,
                'site-moderator' => true,
                'site-admin' => true,
                'god-mode' => true
            ]
        ]);
    }
}
