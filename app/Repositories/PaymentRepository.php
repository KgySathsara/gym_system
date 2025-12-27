<?php

namespace App\Repositories;

use App\Interfaces\PaymentRepositoryInterface;
use App\Models\Payment;
use Illuminate\Pagination\LengthAwarePaginator;
use Illuminate\Support\Facades\DB;

class PaymentRepository implements PaymentRepositoryInterface
{
    public function getAllPayments(): LengthAwarePaginator
    {
        return Payment::with(['member.user', 'plan'])
            ->latest()
            ->paginate(10);
    }

    public function getFilteredPayments(array $filters): LengthAwarePaginator
    {
        $query = Payment::with(['member.user', 'plan']);

        // Apply search filter
        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->whereHas('member.user', function($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                    ->orWhere('email', 'like', "%{$search}%");
            });
        }

        // Apply status filter
        if (!empty($filters['status'])) {
            $query->where('status', $filters['status']);
        }

        // Apply payment method filter
        if (!empty($filters['payment_method'])) {
            $query->where('payment_method', $filters['payment_method']);
        }

        // Apply date range filter
        if (!empty($filters['start_date'])) {
            $query->where('payment_date', '>=', $filters['start_date']);
        }

        if (!empty($filters['end_date'])) {
            $query->where('payment_date', '<=', $filters['end_date']);
        }

        return $query->latest()->paginate(10);
    }

    public function getPaymentById($paymentId): ?Payment
    {
        return Payment::with(['member.user', 'plan'])->findOrFail($paymentId);
    }

    public function createPayment(array $paymentDetails): Payment
    {
        return Payment::create($paymentDetails);
    }

    public function updatePayment($paymentId, array $newDetails): bool
    {
        return Payment::whereId($paymentId)->update($newDetails);
    }

    public function deletePayment($paymentId): bool
    {
        return Payment::destroy($paymentId);
    }

    public function getPaymentsByMember($memberId): LengthAwarePaginator
    {
        return Payment::where('member_id', $memberId)
            ->with(['member.user', 'plan'])
            ->latest()
            ->paginate(10);
    }

    public function getPendingPayments(): LengthAwarePaginator
    {
        return Payment::where('status', 'pending')
            ->with(['member.user', 'plan'])
            ->latest()
            ->paginate(10);
    }

    public function getRevenueStatistics(): array
    {
        $totalRevenue = Payment::where('status', 'completed')->sum('amount');
        $monthlyRevenue = Payment::where('status', 'completed')
            ->whereYear('payment_date', now()->year)
            ->whereMonth('payment_date', now()->month)
            ->sum('amount');
        $pendingPayments = Payment::where('status', 'pending')->count();

        return [
            'total_revenue' => $totalRevenue,
            'monthly_revenue' => $monthlyRevenue,
            'pending_payments' => $pendingPayments,
        ];
    }
}
