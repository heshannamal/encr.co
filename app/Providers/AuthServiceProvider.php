<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The policy mappings for the application.
     *
     * @var array
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     *
     * @return void
     */
    public function boot()
    {
        $this->registerPolicies();

        Gate::before(function ($user, $ability) {
            return $user->hasRole('Super Admin') ? true : null;
        });

        Gate::define('delete-project', function ($user, $project) {
            return $project->created_by == $user->id;
        });

        Gate::define('delete-section', function ($user, $section) {
            return $section->user_id == $user->id;
        });

        Gate::define('delete-discussion', function ($user, $discussion) {
            return $user->can('delete discussion')
                || $discussion->user_id == $user->id;
        });

        Gate::define('delete-sub-discussion', function ($user, $subDiscussion) {
            return $user->can('delete discussion')
                || $subDiscussion->user_id == $user->id;
        });

        Gate::define('delete-comment', function ($user, $comment) {

            return $user->can('delete comment')
                || $comment->user_id == $user->id;
        });

        Gate::define('edit-comment', function ($user, $comment) {

            return $user->can('edit comment')
                || $comment->user_id == $user->id;
        });
    }
}
