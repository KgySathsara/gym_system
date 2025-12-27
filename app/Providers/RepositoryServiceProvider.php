<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;
use App\Interfaces\{
    MemberRepositoryInterface,
    TrainerRepositoryInterface,
    PlanRepositoryInterface,
    PaymentRepositoryInterface,
    AttendanceRepositoryInterface,
    AuthRepositoryInterface,
    UserRepositoryInterface,
    ProfileRepositoryInterface,
    SettingsRepositoryInterface
};
use App\Repositories\{
    MemberRepository,
    TrainerRepository,
    PlanRepository,
    PaymentRepository,
    AttendanceRepository,
    AuthRepository,
    UserRepository,
    ProfileRepository,
    SettingsRepository
};

class RepositoryServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->app->bind(MemberRepositoryInterface::class, MemberRepository::class);
        $this->app->bind(TrainerRepositoryInterface::class, TrainerRepository::class);
        $this->app->bind(PlanRepositoryInterface::class, PlanRepository::class);
        $this->app->bind(PaymentRepositoryInterface::class, PaymentRepository::class);
        $this->app->bind(AttendanceRepositoryInterface::class, AttendanceRepository::class);
        $this->app->bind(AuthRepositoryInterface::class, AuthRepository::class);
        $this->app->bind(UserRepositoryInterface::class, UserRepository::class);
        $this->app->bind(ProfileRepositoryInterface::class, ProfileRepository::class);
        $this->app->bind(SettingsRepositoryInterface::class, SettingsRepository::class);
    }

    public function boot(): void
    {
        //
    }
}
