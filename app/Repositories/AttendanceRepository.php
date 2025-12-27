<?php

namespace App\Repositories;

use App\Interfaces\AttendanceRepositoryInterface;
use App\Models\Attendance;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class AttendanceRepository implements AttendanceRepositoryInterface
{
    public function getAllAttendances(): LengthAwarePaginator
    {
        return Attendance::with(['member.user', 'member.plan'])
            ->latest()
            ->paginate(10);
    }

    public function getAttendanceById($attendanceId): ?Attendance
    {
        return Attendance::with(['member.user', 'member.plan'])->findOrFail($attendanceId);
    }

    public function createAttendance(array $attendanceDetails): Attendance
    {
        return Attendance::create($attendanceDetails);
    }

    public function updateAttendance($attendanceId, array $newDetails): bool
    {
        return Attendance::whereId($attendanceId)->update($newDetails);
    }

    public function deleteAttendance($attendanceId): bool
    {
        return Attendance::destroy($attendanceId);
    }

    public function getAttendanceByMember($memberId): LengthAwarePaginator
    {
        return Attendance::where('member_id', $memberId)
            ->with(['member.user', 'member.plan'])
            ->latest()
            ->paginate(10);
    }

    public function getTodayAttendances(): LengthAwarePaginator
    {
        return Attendance::with(['member.user', 'member.plan'])
            ->whereDate('date', today())
            ->latest()
            ->paginate(10);
    }

    public function getAttendanceStatistics(): array
    {
        $todayAttendances = Attendance::whereDate('date', today())->count();
        $monthlyAttendances = Attendance::whereYear('date', now()->year)
            ->whereMonth('date', now()->month)
            ->count();

        $averageDailyAttendance = Attendance::whereDate('date', '>=', now()->subDays(30))
            ->groupBy('date')
            ->select(DB::raw('DATE(date) as date'), DB::raw('COUNT(*) as count'))
            ->get()
            ->avg('count');

        return [
            'today_attendances' => $todayAttendances,
            'monthly_attendances' => $monthlyAttendances,
            'average_daily_attendance' => round($averageDailyAttendance ?? 0, 1),
        ];
    }
}
