<?php

namespace App\Interfaces;

use App\Models\Payment;
use Illuminate\Pagination\LengthAwarePaginator;

interface PaymentRepositoryInterface
{
    public function getAllPayments(): LengthAwarePaginator;
    public function getPaymentById($paymentId): ?Payment;
    public function createPayment(array $paymentDetails): Payment;
    public function updatePayment($paymentId, array $newDetails): bool;
    public function deletePayment($paymentId): bool;
    public function getPaymentsByMember($memberId): LengthAwarePaginator;
    public function getPendingPayments(): LengthAwarePaginator; // Add this method
    public function getRevenueStatistics(): array;
    public function getFilteredPayments(array $filters): LengthAwarePaginator;
}
