<?php

namespace App\Providers;

use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Gate;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        // 'App\Models\Model' => 'App\Policies\ModelPolicy',
    ];

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        $this->registerPolicies();

        // Define basic gates for role-based authorization
        Gate::define('admin', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('trainer', function ($user) {
            return $user->isTrainer();
        });

        Gate::define('member', function ($user) {
            return $user->isMember();
        });

        Gate::define('manage-members', function ($user) {
            return $user->isAdmin() || $user->isTrainer();
        });

        Gate::define('manage-trainers', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('manage-plans', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('manage-payments', function ($user) {
            return $user->isAdmin();
        });

        Gate::define('manage-attendance', function ($user) {
            return $user->isAdmin() || $user->isTrainer();
        });
    }
}
