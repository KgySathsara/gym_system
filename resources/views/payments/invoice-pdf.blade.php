<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #INV-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</title>

    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            background: #f4f6f8;
            margin: 0;
            padding: 0;
            font-size: 12px;
            color: #2c3e50;
        }

        .invoice-container {
            max-width: 820px;
            margin: 40px auto;
            background: #ffffff;
            padding: 40px;
            border-radius: 12px;
        }

        /* Header */
        .header {
            display: flex;
            justify-content: space-between;
            padding-bottom: 25px;
            margin-bottom: 30px;
            border-bottom: 2px solid #e9ecef;
        }

        .company-info h2 {
            margin: 0;
            color: #0d6efd;
            font-size: 22px;
        }

        .company-info p {
            margin: 4px 0;
            font-size: 11px;
            color: #6c757d;
        }

        .invoice-info {
            text-align: right;
        }

        .invoice-info h1 {
            margin: 0;
            font-size: 32px;
            color: #198754;
        }

        .invoice-info p {
            margin: 4px 0;
            font-size: 11px;
        }

        .status {
            display: inline-block;
            margin-top: 6px;
            padding: 6px 14px;
            font-size: 10px;
            font-weight: bold;
            border-radius: 20px;
            text-transform: uppercase;
        }

        .completed { background: #d1e7dd; color: #0f5132; }
        .pending { background: #fff3cd; color: #664d03; }
        .failed { background: #f8d7da; color: #842029; }

        /* Sections */
        .section {
            margin-bottom: 30px;
        }

        .section-title {
            font-size: 13px;
            font-weight: bold;
            color: #0d6efd;
            margin-bottom: 12px;
            text-transform: uppercase;
        }

        .info-row {
            display: flex;
            justify-content: space-between;
            gap: 20px;
        }

        .info-box {
            width: 48%;
            border: 1px solid #e9ecef;
            padding: 20px;
            border-radius: 10px;
        }

        .info-box p {
            margin: 4px 0;
            font-size: 11px;
        }

        /* Table */
        table {
            width: 100%;
            border-collapse: collapse;
        }

        thead th {
            background: #0d6efd;
            color: #ffffff;
            padding: 12px;
            font-size: 11px;
            text-align: left;
        }

        tbody td {
            padding: 12px;
            border-bottom: 1px solid #dee2e6;
            font-size: 11px;
        }

        .text-right {
            text-align: right;
        }

        /* Totals */
        .totals {
            width: 320px;
            margin-left: auto;
            border: 1px solid #dee2e6;
            border-radius: 10px;
            overflow: hidden;
        }

        .totals div {
            display: flex;
            justify-content: space-between;
            padding: 10px 15px;
            font-size: 11px;
        }

        .totals .grand-total {
            background: #198754;
            color: #ffffff;
            font-weight: bold;
            font-size: 13px;
        }

        /* Notes */
        .notes {
            background: #fff3cd;
            border-left: 5px solid #ffc107;
            padding: 15px;
            border-radius: 8px;
            font-size: 11px;
        }

        /* Footer */
        .footer {
            margin-top: 50px;
            padding-top: 25px;
            border-top: 1px solid #dee2e6;
            display: flex;
            justify-content: space-between;
            align-items: flex-end;
        }

        .footer p {
            font-size: 10px;
            color: #6c757d;
            margin: 5px 0;
        }

        .signature {
            text-align: center;
        }

        .signature-line {
            width: 200px;
            border-top: 1px solid #000;
            margin: 30px auto 5px;
        }
    </style>
</head>

<body>

<div class="invoice-container">

    <!-- Header -->
    <div class="header">
        <div class="company-info">
            <h2>GYM MANAGEMENT SYSTEM</h2>
            <p>123 Fitness Street</p>
            <p>Sports City, SC 12345</p>
            <p>Phone: (555) 123-4567</p>
            <p>Email: info@gymmanagement.com</p>
        </div>

        <div class="invoice-info">
            <h1>INVOICE</h1>
            <p><strong>#INV-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</strong></p>
            <p>Date: {{ $payment->payment_date->format('F d, Y') }}</p>
            <p>Due: {{ $payment->due_date->format('F d, Y') }}</p>
            <span class="status {{ $payment->status }}">{{ strtoupper($payment->status) }}</span>
        </div>
    </div>

    <!-- Billing -->
    <div class="section">
        <div class="info-row">
            <div class="info-box">
                <div class="section-title">Billed To</div>
                <p><strong>{{ $payment->member->user->name }}</strong></p>
                <p>Member ID: {{ $payment->member->member_id ?? $payment->member->id }}</p>
                <p>Email: {{ $payment->member->user->email }}</p>
                @if($payment->member->user->phone)
                    <p>Phone: {{ $payment->member->user->phone }}</p>
                @endif
            </div>

            <div class="info-box">
                <div class="section-title">Payment Info</div>
                <p>Method: {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                <p>Paid On: {{ $payment->payment_date->format('M d, Y h:i A') }}</p>
                @if($payment->transaction_id)
                    <p>Transaction ID: {{ $payment->transaction_id }}</p>
                @endif
            </div>
        </div>
    </div>

    <!-- Items -->
    <div class="section">
        <div class="section-title">Invoice Details</div>
        <table>
            <thead>
                <tr>
                    <th>Description</th>
                    <th>Duration</th>
                    <th class="text-right">Amount</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>
                        <strong>{{ $payment->plan->name }}</strong><br>
                        <small>{{ $payment->plan->description ?? 'Gym membership plan' }}</small>
                    </td>
                    <td>{{ $payment->plan->duration_days }} Days</td>
                    <td class="text-right">${{ number_format($payment->amount, 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <!-- Totals -->
    <div class="section">
        <div class="totals">
            <div>
                <span>Subtotal</span>
                <span>${{ number_format($payment->amount, 2) }}</span>
            </div>
            <div>
                <span>Tax</span>
                <span>$0.00</span>
            </div>
            <div class="grand-total">
                <span>Total</span>
                <span>${{ number_format($payment->amount, 2) }}</span>
            </div>
        </div>
    </div>

    <!-- Notes -->
    @if($payment->notes)
        <div class="section notes">
            <strong>Notes:</strong><br>
            {{ $payment->notes }}
        </div>
    @endif

    <!-- Footer -->
    <div class="footer">
        <div>
            <strong>Payment Terms</strong>
            <p>
                Payment must be completed before the due date.<br>
                Late payments may suspend membership access.
            </p>
        </div>

        <div class="signature">
            <div class="signature-line"></div>
            <p>Authorized Signature</p>
            <p>Gym Management System</p>
        </div>
    </div>

</div>

</body>
</html>
