<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice #INV-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</title>
    <style>
        body {
            font-family: 'DejaVu Sans', Arial, sans-serif;
            font-size: 12px;
            line-height: 1.4;
            color: #333;
        }
        .invoice-container {
            max-width: 800px;
            margin: 0 auto;
            padding: 20px;
        }
        .header {
            border-bottom: 2px solid #007bff;
            padding-bottom: 20px;
            margin-bottom: 30px;
        }
        .company-info h2 {
            color: #007bff;
            margin: 0;
        }
        .invoice-info {
            text-align: right;
        }
        .invoice-info h1 {
            color: #28a745;
            margin: 0;
        }
        .section {
            margin-bottom: 30px;
        }
        .section-title {
            background-color: #f8f9fa;
            padding: 8px 15px;
            border-left: 4px solid #007bff;
            margin-bottom: 15px;
        }
        .table {
            width: 100%;
            border-collapse: collapse;
        }
        .table th {
            background-color: #343a40;
            color: white;
            padding: 10px;
            text-align: left;
        }
        .table td {
            padding: 10px;
            border: 1px solid #dee2e6;
        }
        .table-bordered {
            border: 1px solid #dee2e6;
        }
        .text-end {
            text-align: right;
        }
        .text-center {
            text-align: center;
        }
        .total-row {
            background-color: #d4edda;
            font-weight: bold;
        }
        .footer {
            margin-top: 50px;
            padding-top: 20px;
            border-top: 1px solid #dee2e6;
            font-size: 10px;
            color: #6c757d;
        }
        .status-badge {
            padding: 4px 8px;
            border-radius: 4px;
            font-size: 10px;
            font-weight: bold;
        }
        .status-completed { background-color: #d4edda; color: #155724; }
        .status-pending { background-color: #fff3cd; color: #856404; }
        .status-failed { background-color: #f8d7da; color: #721c24; }
    </style>
</head>
<body>
    <div class="invoice-container">
        <!-- Header -->
        <div class="header">
            <div style="display: flex; justify-content: space-between; align-items: flex-start;">
                <div class="company-info">
                    <h2>GYM MANAGEMENT SYSTEM</h2>
                    <p>123 Fitness Street</p>
                    <p>Sports City, SC 12345</p>
                    <p>Phone: (555) 123-4567</p>
                    <p>Email: info@gymmanagement.com</p>
                </div>
                <div class="invoice-info">
                    <h1>INVOICE</h1>
                    <p><strong>Invoice #:</strong> INV-{{ str_pad($payment->id, 6, '0', STR_PAD_LEFT) }}</p>
                    <p><strong>Date:</strong> {{ $payment->payment_date->format('F d, Y') }}</p>
                    <p><strong>Due Date:</strong> {{ $payment->due_date->format('F d, Y') }}</p>
                    <p>
                        <strong>Status:</strong>
                        <span class="status-badge status-{{ $payment->status }}">
                            {{ ucfirst($payment->status) }}
                        </span>
                    </p>
                </div>
            </div>
        </div>

        <!-- Bill To & Payment Details -->
        <div style="display: flex; justify-content: space-between; margin-bottom: 30px;">
            <div style="width: 48%;">
                <div class="section-title">Bill To:</div>
                <div style="border: 1px solid #dee2e6; padding: 15px; border-radius: 4px;">
                    <h4 style="margin: 0 0 10px 0;">{{ $payment->member->user->name }}</h4>
                    <p style="margin: 5px 0;">Member ID: {{ $payment->member->member_id ?? $payment->member->id }}</p>
                    <p style="margin: 5px 0;">Email: {{ $payment->member->user->email }}</p>
                    @if($payment->member->user->phone)
                        <p style="margin: 5px 0;">Phone: {{ $payment->member->user->phone }}</p>
                    @endif
                </div>
            </div>
            <div style="width: 48%;">
                <div class="section-title">Payment Details:</div>
                <div style="border: 1px solid #dee2e6; padding: 15px; border-radius: 4px;">
                    <p style="margin: 5px 0;"><strong>Payment Method:</strong> {{ ucfirst(str_replace('_', ' ', $payment->payment_method)) }}</p>
                    <p style="margin: 5px 0;"><strong>Transaction Date:</strong> {{ $payment->payment_date->format('M d, Y h:i A') }}</p>
                    @if($payment->transaction_id)
                        <p style="margin: 5px 0;"><strong>Transaction ID:</strong> {{ $payment->transaction_id }}</p>
                    @endif
                </div>
            </div>
        </div>

        <!-- Invoice Items -->
        <div class="section">
            <div class="section-title">Invoice Details</div>
            <table class="table table-bordered">
                <thead>
                    <tr>
                        <th style="width: 50%;">Description</th>
                        <th style="width: 25%;">Plan Duration</th>
                        <th style="width: 25%;" class="text-end">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <strong>{{ $payment->plan->name }}</strong>
                            <br>
                            <small>{{ $payment->plan->description ?? 'Gym membership plan' }}</small>
                        </td>
                        <td>{{ $payment->plan->duration_days }} days</td>
                        <td class="text-end">${{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-end"><strong>Subtotal:</strong></td>
                        <td class="text-end">${{ number_format($payment->amount, 2) }}</td>
                    </tr>
                    <tr>
                        <td colspan="2" class="text-end"><strong>Tax (0%):</strong></td>
                        <td class="text-end">$0.00</td>
                    </tr>
                    <tr class="total-row">
                        <td colspan="2" class="text-end"><strong>TOTAL:</strong></td>
                        <td class="text-end"><strong>${{ number_format($payment->amount, 2) }}</strong></td>
                    </tr>
                </tbody>
            </table>
        </div>

        <!-- Notes -->
        @if($payment->notes)
        <div class="section">
            <div class="section-title">Notes</div>
            <div style="border: 1px solid #ffc107; padding: 15px; border-radius: 4px; background-color: #fff3cd;">
                <p style="margin: 0;">{{ $payment->notes }}</p>
            </div>
        </div>
        @endif

        <!-- Terms & Signature -->
        <div class="footer">
            <div style="display: flex; justify-content: space-between; align-items: flex-end;">
                <div style="width: 50%;">
                    <strong>Payment Terms:</strong>
                    <p style="margin: 5px 0; font-size: 9px;">
                        Payment is due by the due date specified above.
                        Late payments may result in membership suspension.
                    </p>
                </div>
                <div style="width: 40%; text-align: center;">
                    <p style="margin-bottom: 30px; border-bottom: 1px solid #000; width: 200px; margin-left: auto; margin-right: auto;"></p>
                    <p style="margin: 0; font-size: 10px;">Authorized Signature</p>
                    <p style="margin: 0; font-size: 9px;">Gym Management System</p>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
