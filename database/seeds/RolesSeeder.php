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
                'update-profile' => true,
                'comment-on-post' => false,
                'create-post' => false,
                'update-post' => false,
                'publish-post' => false,
                'post-unlimited' =>  false,
                'site-moderator' => false,
                'site-admin' => false,
                'god-mode' => false
            ],
            'description' => 'Your account is in Pending status because you have not verified your email yet. Verify your email or reset your password to become verified.'
        ]);
        $basic = Role::create([
            'name' => 'Basic',
            'slug' => 'basic',
            'permissions' => [
                'update-profile' => true,
                'comment-on-post' => true,
                'create-post' => false,
                'update-post' => false,
                'publish-post' => false,
                'post-unlimited' =>  false,
                'site-moderator' => false,
                'site-admin' => false,
                'god-mode' => false
            ],
            'description' => 'Can create and have access to your profile, ratings and inventory. You can also read and comment on posts and pages. You must Level Up to Contributor if you want to create posts.'
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
                'post-unlimited' =>  false,
                'site-moderator' => false,
                'site-admin' => false,
                'god-mode' => false
            ],
            'description' => 'As a contributor, you have no publishing or uploading capabilities (content is moderated), but you can write and edit your own posts until they are published by a site Moderator. You will be limited to 3 posts at a time in the moderation queue. Level Up to an Author to unlock Unlimited Posting.'
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
                'post-unlimited' =>  true,
                'site-moderator' => false,
                'site-admin' => false,
                'god-mode' => false
            ],
            'description' => 'As an Author, you can write, upload photos to, edit, and publish your own posts and reviews without moderation.  Level Up to an Editor to unlock Site Moderation and save the world from evil posters.'
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
                'post-unlimited' =>  true,
                'site-moderator' => true,
                'site-admin' => false,
                'god-mode' => false
            ],
            'description' => 'As an Editor, you have access to all posts, pages, comments, categories, tags, and links. You also has the power to suspend and remove users. All changes are logged and the actions areeasily reverted if an Editor goes Rogue. Level Up to an Admin to unlock Site Moderation and save the world from evil posters.'
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
                'post-unlimited' =>  true,
                'site-moderator' => true,
                'site-admin' => true,
                'god-mode' => false
            ],
            'description' => 'As an Administrator, nothing is off limits. Reserved for Elite Team members that have shown their valor and commitment to the site. You will be able to suspend, remove and even elevate users and you can also help with support tickets. All updates and changes are logged and reversible in the event an Admin becomes a Rogue Agent.'
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
                'post-unlimited' =>  true,
                'site-moderator' => true,
                'site-admin' => true,
                'god-mode' => true
            ],
            'description' => 'How did you hear about this? No one knows about this access. This is reserved for one person, ThaBamboozler. If you somehow got access to this level, please alert an Administrator ASAP. This is a very dangerous role and it should be handled with discretion.'
        ]);
    }
}
