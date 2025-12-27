<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\AuthRepositoryInterface;
use App\Repositories\AuthRepository;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
        // Manually bind the repositories
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);

        // Add other bindings if needed
        $this->app->bind(\App\Interfaces\MemberRepositoryInterface::class, \App\Repositories\MemberRepository::class);
        $this->app->bind(\App\Interfaces\TrainerRepositoryInterface::class, \App\Repositories\TrainerRepository::class);
        $this->app->bind(\App\Interfaces\PlanRepositoryInterface::class, \App\Repositories\PlanRepository::class);
        $this->app->bind(\App\Interfaces\PaymentRepositoryInterface::class, \App\Repositories\PaymentRepository::class);
        $this->app->bind(\App\Interfaces\AttendanceRepositoryInterface::class, \App\Repositories\AttendanceRepository::class);
        $this->app->bind(\App\Interfaces\UserRepositoryInterface::class, \App\Repositories\UserRepository::class);
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        //
    }
}
