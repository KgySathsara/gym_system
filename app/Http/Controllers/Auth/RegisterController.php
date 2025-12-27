<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\MemberService;
use App\Services\TrainerService;
use Illuminate\Http\Request;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function __construct(
        private AuthService $authService,
        private MemberService $memberService,
        private TrainerService $trainerService
    ) {}

    /**
     * Show the registration form.
     */
    public function showRegistrationForm(): View
    {
        return view('auth.register');
    }

    /**
     * Handle a registration request.
     */
    public function register(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|string|min:8|confirmed',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'date_of_birth' => 'nullable|date',
            'role' => 'required|in:member,trainer',
        ]);

        try {
            DB::beginTransaction();

            // Create user
            $user = $this->authService->register([
                'name' => $validated['name'],
                'email' => $validated['email'],
                'password' => $validated['password'],
                'role' => $validated['role'],
                'phone' => $validated['phone'] ?? null,
                'address' => $validated['address'] ?? null,
                'date_of_birth' => $validated['date_of_birth'] ?? null,
            ]);

            // Create role-specific record
            if ($validated['role'] === 'trainer') {
                $this->trainerService->createTrainer([
                    'user_id' => $user->id,
                    'specialization' => 'General Fitness', // Default specialization
                    'experience_years' => 0,
                    'hourly_rate' => 0,
                    'is_available' => true,
                ]);
            } else {
                // For members, we'll assign a default plan and set basic info
                $basicPlan = \App\Models\Plan::where('name', 'Basic Plan')->first();

                if ($basicPlan) {
                    $this->memberService->createMember([
                        'user_id' => $user->id,
                        'plan_id' => $basicPlan->id,
                        'join_date' => now(),
                        'expiry_date' => now()->addDays($basicPlan->duration_days),
                        'status' => 'active',
                    ]);
                }
            }

            DB::commit();

            // Auto-login after registration
            $this->authService->login([
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);

            $request->session()->regenerate();

            return redirect('/')->with('success', 'Registration successful! Welcome to FitLife Gym.');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()->withErrors([
                'email' => 'Registration failed. Please try again.',
            ])->withInput();
        }
    }
}
