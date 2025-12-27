<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Member\StoreMemberRequest;
use App\Http\Requests\Member\UpdateMemberRequest;
use App\Services\MemberService;
use App\Services\TrainerService;
use App\Services\PlanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class MemberController extends Controller
{
    public function __construct(
        private MemberService $memberService,
        private TrainerService $trainerService,
        private PlanService $planService
    ) {}

    public function index(): View
    {
        $members = $this->memberService->getAllMembers();
        return view('members.index', compact('members'));
    }

    public function create(): View
    {
        $trainers = $this->trainerService->getAvailableTrainers();
        $plans = $this->planService->getActivePlans();
        return view('members.create', compact('trainers', 'plans'));
    }

    public function store(StoreMemberRequest $request): RedirectResponse
    {
        $member = $this->memberService->createMember($request->validated());
        return redirect()->route('members.index')->with('success', 'Member created successfully.');
    }

    public function show($id): View
    {
        $member = $this->memberService->getMemberById($id);
        return view('members.show', compact('member'));
    }

    public function edit($id): View
    {
        $member = $this->memberService->getMemberById($id);
        $trainers = $this->trainerService->getAllTrainers();
        $plans = $this->planService->getAllPlans();
        return view('members.edit', compact('member', 'trainers', 'plans'));
    }

    public function update(UpdateMemberRequest $request, $id): RedirectResponse
    {
        $this->memberService->updateMember($id, $request->validated());
        return redirect()->route('members.index')->with('success', 'Member updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $this->memberService->deleteMember($id);
        return redirect()->route('members.index')->with('success', 'Member deleted successfully.');
    }
}
