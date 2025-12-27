<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Attendance\StoreAttendanceRequest;
use App\Http\Requests\Attendance\UpdateAttendanceRequest;
use App\Services\AttendanceService;
use App\Services\MemberService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class AttendanceController extends Controller
{
    public function __construct(
        private AttendanceService $attendanceService,
        private MemberService $memberService
    ) {}

    public function index(): View
    {
        $attendances = $this->attendanceService->getAllAttendances();
        $attendanceStats = $this->attendanceService->getAttendanceStatistics();
        return view('attendance.index', compact('attendances', 'attendanceStats'));
    }

    public function create(): View
    {
        $members = $this->memberService->getActiveMembers();
        return view('attendance.create', compact('members'));
    }

    public function store(StoreAttendanceRequest $request): RedirectResponse
    {
        $attendance = $this->attendanceService->createAttendance($request->validated());
        return redirect()->route('attendance.index')->with('success', 'Attendance recorded successfully.');
    }

    public function show($id): View
    {
        $attendance = $this->attendanceService->getAttendanceById($id);
        return view('attendance.show', compact('attendance'));
    }

    public function edit($id): View
    {
        $attendance = $this->attendanceService->getAttendanceById($id);
        $members = $this->memberService->getAllMembers();
        return view('attendance.edit', compact('attendance', 'members'));
    }

    public function update(UpdateAttendanceRequest $request, $id): RedirectResponse
    {
        $this->attendanceService->updateAttendance($id, $request->validated());
        return redirect()->route('attendance.index')->with('success', 'Attendance updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $this->attendanceService->deleteAttendance($id);
        return redirect()->route('attendance.index')->with('success', 'Attendance deleted successfully.');
    }

    public function today() // Remove ": View" temporarily
    {
        $attendances = $this->attendanceService->getTodayAttendances();

        // Get statistics
        $totalCheckins = $attendances->count();
        $checkedOut = $attendances->where('check_out', '!=', null)->count();
        $currentlyInGym = $attendances->where('check_out', null)->count();
        $activeMembersCount = \App\Models\Member::where('status', 'active')->count();
        $notCheckedIn = $activeMembersCount - $totalCheckins;

        return view('attendance.today', compact(
            'attendances',
            'totalCheckins',
            'checkedOut',
            'currentlyInGym',
            'notCheckedIn'
        ));
    }
}
