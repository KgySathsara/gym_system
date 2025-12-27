<?php

namespace App\Services;

use App\Interfaces\PaymentRepositoryInterface;

class PaymentService
{
    public function __construct(
        private PaymentRepositoryInterface $paymentRepository
    ) {}

    public function getAllPayments()
    {
        return $this->paymentRepository->getAllPayments();
    }

    public function getFilteredPayments(array $filters)
    {
        return $this->paymentRepository->getFilteredPayments($filters);
    }

    public function getPaymentById($paymentId)
    {
        return $this->paymentRepository->getPaymentById($paymentId);
    }

    public function createPayment(array $paymentDetails)
    {
        return $this->paymentRepository->createPayment($paymentDetails);
    }

    public function updatePayment($paymentId, array $newDetails)
    {
        return $this->paymentRepository->updatePayment($paymentId, $newDetails);
    }

    public function deletePayment($paymentId)
    {
        return $this->paymentRepository->deletePayment($paymentId);
    }

    public function getPaymentsByMember($memberId)
    {
        return $this->paymentRepository->getPaymentsByMember($memberId);
    }

    public function getPendingPayments()
    {
        return $this->paymentRepository->getPendingPayments();
    }

    public function getRevenueStatistics()
    {
        return $this->paymentRepository->getRevenueStatistics();
    }
}
