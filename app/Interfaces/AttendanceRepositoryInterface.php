<?php

namespace App\Interfaces;

use App\Models\Attendance;
use Illuminate\Pagination\LengthAwarePaginator;

interface AttendanceRepositoryInterface
{
    public function getAllAttendances(): LengthAwarePaginator;
    public function getAttendanceById($attendanceId): ?Attendance;
    public function createAttendance(array $attendanceDetails): Attendance;
    public function updateAttendance($attendanceId, array $newDetails): bool;
    public function deleteAttendance($attendanceId): bool;
    public function getAttendanceByMember($memberId): LengthAwarePaginator;
    public function getTodayAttendances(): LengthAwarePaginator;
    public function getAttendanceStatistics(): array;
}
