<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Plan\StorePlanRequest;
use App\Http\Requests\Plan\UpdatePlanRequest;
use App\Services\PlanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class PlanController extends Controller
{
    public function __construct(
        private PlanService $planService
    ) {}

    public function index(): View
    {
        $plans = $this->planService->getAllPlans();
        return view('plans.index', compact('plans'));
    }

    public function create(): View
    {
        return view('plans.create');
    }

    public function store(StorePlanRequest $request): RedirectResponse
    {
        // The service will handle features conversion
        $plan = $this->planService->createPlan($request->validated());
        return redirect()->route('plans.index')->with('success', 'Plan created successfully.');
    }

    public function show($id): View
    {
        $plan = $this->planService->getPlanById($id);
        return view('plans.show', compact('plan'));
    }

    public function edit($id): View
    {
        $plan = $this->planService->getPlanById($id);
        return view('plans.edit', compact('plan'));
    }

    public function update(UpdatePlanRequest $request, $id): RedirectResponse
    {
        // The service will handle features conversion
        $this->planService->updatePlan($id, $request->validated());
        return redirect()->route('plans.index')->with('success', 'Plan updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $this->planService->deletePlan($id);
        return redirect()->route('plans.index')->with('success', 'Plan deleted successfully.');
    }

    public function toggleStatus($id): RedirectResponse
    {
        $plan = $this->planService->getPlanById($id);
        $newStatus = !$plan->is_active;

        $this->planService->updatePlan($id, ['is_active' => $newStatus]);

        $message = $newStatus ? 'Plan activated successfully.' : 'Plan deactivated successfully.';
        return redirect()->route('plans.show', $id)->with('success', $message);
    }
}
