<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\MemberService;
use App\Services\PaymentService;
use App\Services\AttendanceService;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function __construct(
        private MemberService $memberService,
        private PaymentService $paymentService,
        private AttendanceService $attendanceService
    ) {}

    public function index(): View
    {
        $stats = [
            'total_members' => $this->memberService->getActiveMembers()->total(),
            'today_attendances' => $this->attendanceService->getTodayAttendances()->total(),
            'revenue_stats' => $this->paymentService->getRevenueStatistics(),
            'attendance_stats' => $this->attendanceService->getAttendanceStatistics(),
        ];

        $recentMembers = $this->memberService->getAllMembers()->take(5);
        $pendingPayments = $this->paymentService->getPendingPayments()->take(5);

        return view('dashboard', compact('stats', 'recentMembers', 'pendingPayments'));
    }
}
