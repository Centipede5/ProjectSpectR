<?php

namespace App\Providers;

use Illuminate\Support\Facades\Gate;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use App\Post;

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
        $this->registerPostPolicies();
    }

    public function registerPostPolicies()
    {
        Gate::define('update-profile', function ($user) {
            return $user->hasAccess(['update-profile']);
        });
        Gate::define('comment-on-post', function ($user) {
            return $user->hasAccess(['comment-on-post']);
        });
        Gate::define('create-post', function ($user) {
            return $user->hasAccess(['create-post']);
        });
        Gate::define('update-post', function ($user, Post $post) {
            return $user->hasAccess(['update-post']) or $user->id == $post->user_id;
        });
        Gate::define('publish-post', function ($user) {
            return $user->hasAccess(['publish-post']);
        });
        Gate::define('post-unlimited', function ($user) {
            return $user->hasAccess(['post-unlimited']);
        });
        Gate::define('site-moderator', function ($user) {
            return $user->hasAccess(['site-moderator']);
        });
        Gate::define('site-admin', function ($user) {
            return $user->hasAccess(['site-admin']);
        });
        Gate::define('god-mode', function ($user) {
            return $user->inRole(['super']);
        });


        Gate::define('see-all-drafts', function ($user) {
            return $user->inRole(['editor','admin']);
        });
    }
}
