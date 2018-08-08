<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Post;
use App\User;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        'App\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();
        $this->registerSecurityPolicies();
    }

    public function registerSecurityPolicies()
    {
        // update-profile
        // comment-on-post
        // create-post
        // update-post
        // publish-post
        // post-unlimited
        // site-moderator
        // site-admin
        // god-mode

        // Permissions Gates
        Gate::define('update-profile', function (User $user) {
            return $user->hasAccess(['update-profile']);
        });
        Gate::define('comment-on-post', function (User $user) {
            return $user->hasAccess(['comment-on-post']);
        });
        Gate::define('create-post', function (User $user) {
            return $user->hasAccess(['create-post']);
        });
        Gate::define('update-post', function (User $user, Post $post) {
            return $user->hasAccess(['update-post']) or $user->id == $post->user_id;
        });
        Gate::define('publish-post', function (User $user) {
            return $user->hasAccess(['publish-post']);
        });
        Gate::define('post-unlimited', function (User $user) {
            return $user->hasAccess(['post-unlimited']);
        });
        Gate::define('site-moderator', function (User $user) {
            return $user->hasAccess(['site-moderator']);
        });
        Gate::define('site-admin', function (User $user) {
            return $user->hasAccess(['site-admin']);
        });

        // Role Gates
        Gate::define('god-mode', function (User $user) {
            return $user->inRole(['super']);
        });
        Gate::define('see-all-drafts', function (User $user) {
            return $user->inRole(['editor','admin']);
        });
    }
}
