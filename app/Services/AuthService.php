<?php

namespace App\Services;

use App\Interfaces\AuthRepositoryInterface;
use App\Models\User;

class AuthService
{
    public function __construct(
        private AuthRepositoryInterface $authRepository
    ) {}

    public function register(array $userDetails): User
    {
        return $this->authRepository->register($userDetails);
    }

    public function login(array $credentials): bool
    {
        return $this->authRepository->login($credentials);
    }

    public function logout(): void
    {
        $this->authRepository->logout();
    }

    public function getUser(): ?User
    {
        return $this->authRepository->getUser();
    }
}
