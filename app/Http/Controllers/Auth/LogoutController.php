<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;

class LogoutController extends Controller
{
    public function __construct(
        private AuthService $authService
    ) {}

    /**
     * Log the user out of the application.
     */
    public function logout(Request $request): RedirectResponse
    {
        $this->authService->logout();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return redirect('/login')->with('success', 'You have been logged out successfully.');
    }
}
