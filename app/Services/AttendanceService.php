<?php

namespace App\Services;

use App\Interfaces\AttendanceRepositoryInterface;

class AttendanceService
{
    public function __construct(
        private AttendanceRepositoryInterface $attendanceRepository
    ) {}

    public function getAllAttendances()
    {
        return $this->attendanceRepository->getAllAttendances();
    }

    public function getAttendanceById($attendanceId)
    {
        return $this->attendanceRepository->getAttendanceById($attendanceId);
    }

    public function createAttendance(array $attendanceDetails)
    {
        return $this->attendanceRepository->createAttendance($attendanceDetails);
    }

    public function updateAttendance($attendanceId, array $newDetails)
    {
        return $this->attendanceRepository->updateAttendance($attendanceId, $newDetails);
    }

    public function deleteAttendance($attendanceId)
    {
        return $this->attendanceRepository->deleteAttendance($attendanceId);
    }

    public function getAttendanceByMember($memberId)
    {
        return $this->attendanceRepository->getAttendanceByMember($memberId);
    }

    public function getTodayAttendances()
    {
        return $this->attendanceRepository->getTodayAttendances();
    }

    public function getAttendanceStatistics()
    {
        return $this->attendanceRepository->getAttendanceStatistics();
    }
}
