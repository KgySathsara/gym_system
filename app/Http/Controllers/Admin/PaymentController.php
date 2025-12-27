<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Payment\StorePaymentRequest;
use App\Http\Requests\Payment\UpdatePaymentRequest;
use App\Services\PaymentService;
use App\Services\MemberService;
use App\Services\PlanService;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class PaymentController extends Controller
{
    public function __construct(
        private PaymentService $paymentService,
        private MemberService $memberService,
        private PlanService $planService
    ) {}

    public function index(Request $request): View
    {
        $filters = [
            'search' => $request->get('search'),
            'status' => $request->get('status'),
            'payment_method' => $request->get('payment_method'),
            'start_date' => $request->get('start_date'),
            'end_date' => $request->get('end_date'),
        ];

        // Check if any filters are applied
        $hasFilters = !empty(array_filter($filters, function($value) {
            return $value !== null && $value !== '';
        }));

        if ($hasFilters) {
            $payments = $this->paymentService->getFilteredPayments($filters);
        } else {
            $payments = $this->paymentService->getAllPayments();
        }

        $revenueStats = $this->paymentService->getRevenueStatistics();

        return view('payments.index', compact('payments', 'revenueStats', 'filters'));
    }

    public function create(): View
    {
        $members = $this->memberService->getActiveMembers();
        $plans = $this->planService->getActivePlans();
        return view('payments.create', compact('members', 'plans'));
    }

    public function store(StorePaymentRequest $request): RedirectResponse
    {
        $payment = $this->paymentService->createPayment($request->validated());
        return redirect()->route('payments.index')->with('success', 'Payment created successfully.');
    }

    public function show($id): View
    {
        $payment = $this->paymentService->getPaymentById($id);
        return view('payments.show', compact('payment'));
    }

    public function edit($id): View
    {
        $payment = $this->paymentService->getPaymentById($id);
        $members = $this->memberService->getAllMembers();
        $plans = $this->planService->getAllPlans();
        return view('payments.edit', compact('payment', 'members', 'plans'));
    }

    public function update(UpdatePaymentRequest $request, $id): RedirectResponse
    {
        $this->paymentService->updatePayment($id, $request->validated());
        return redirect()->route('payments.index')->with('success', 'Payment updated successfully.');
    }

    public function destroy($id): RedirectResponse
    {
        $this->paymentService->deletePayment($id);
        return redirect()->route('payments.index')->with('success', 'Payment deleted successfully.');
    }

    public function invoice($id)
    {
        $payment = $this->paymentService->getPaymentById($id);

        return view('payments.invoice', compact('payment'));
    }

    public function downloadInvoice($id)
    {
        $payment = $this->paymentService->getPaymentById($id);

        $pdf = Pdf::loadView('payments.invoice-pdf', compact('payment'));

        return $pdf->download("invoice-{$payment->id}-{$payment->payment_date->format('Y-m-d')}.pdf");
    }

    public function printInvoice($id)
    {
        $payment = $this->paymentService->getPaymentById($id);

        $pdf = Pdf::loadView('payments.invoice-pdf', compact('payment'));

        return $pdf->stream("invoice-{$payment->id}.pdf");
    }

    public function updateStatus(Request $request, Payment $payment)
    {
        $request->validate([
            'status' => 'required|in:pending,completed,failed'
        ]);

        $payment->update([
            'status' => $request->status
        ]);

        return redirect()->route('payments.show', $payment->id)
            ->with('success', 'Payment status updated successfully.');
    }
}
