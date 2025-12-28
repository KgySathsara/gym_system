<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Services\AuthService;
use App\Services\MemberService;
use App\Services\TrainerService;
use App\Models\Plan;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class RegisterController extends Controller
{
    public function __construct(
        private AuthService $authService,
        private MemberService $memberService,
        private TrainerService $trainerService
    ) {}

    public function showRegistrationForm()
    {
        return view('auth.register');
    }

    public function register(Request $request)
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

            // 1️⃣ Create USER (ONLY ONCE)
            $user = $this->authService->register($validated);

            // 2️⃣ ROLE BASED CREATION
            if ($validated['role'] === 'trainer') {

                // TRAINER REGISTRATION
                $this->trainerService->createTrainer([
                    'user_id' => $user->id,
                    'specialization' => 'General Fitness',
                    'experience_years' => 0,
                    'hourly_rate' => 0,
                    'is_available' => true,
                ]);

            } else {

                // MEMBER REGISTRATION
                $plan = Plan::where('name', 'Basic Plan')->firstOrFail();

                $this->memberService->createMember([
                    'user_id' => $user->id,
                    'plan_id' => $plan->id,
                    'join_date' => now(),
                    'expiry_date' => now()->addDays($plan->duration_days),
                    'status' => 'active',
                ]);
            }

            DB::commit();

            // 3️⃣ AUTO LOGIN
            $this->authService->login([
                'email' => $validated['email'],
                'password' => $validated['password'],
            ]);

            $request->session()->regenerate();

            return redirect('/')->with('success', 'Registration successful!');

        } catch (\Exception $e) {
            DB::rollBack();

            return back()
                ->withErrors(['error' => 'Registration failed. Please try again.'])
                ->withInput();
        }
    }
}
