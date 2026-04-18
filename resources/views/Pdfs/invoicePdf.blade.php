<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Invoice {{ $invoice->invoice_reference }}</title>

    <style>
        body {
            font-family: DejaVu Sans;
            font-size: 13px;
            color: #333;
            margin: 0;
            padding: 20px;
            background: #f7f7f7;
        }

        .container {
            max-width: 700px;
            margin: auto;
            background: #fff;
            border: 1px solid #ddd;
        }

        /* ===== TOP TITLE ===== */
        .top-title {
            text-align: center;
            font-size: 22px;
            font-weight: bold;
            color: #005461;
            padding: 15px 10px;
            border-bottom: 2px solid #eee;
        }

        .header {
            background: linear-gradient(to right, #005461, #0C7779);
            color: white;
            padding: 20px;
        }

        .header h2 {
            margin: 0;
            font-size: 20px;
        }

        .section {
            border-top: 1px solid #eee;
        }

        .row {
            padding: 12px 20px;
            border-bottom: 1px solid #f1f1f1;
        }

        .label {
            color: #777;
            font-size: 12px;
        }

        .value {
            float: right;
            font-weight: bold;
        }

        .badge {
            padding: 4px 8px;
            border-radius: 10px;
            font-size: 11px;
        }

        .paid { background: #e6f7ee; color: #1b8f4d; }
        .partial { background: #fff7e6; color: #b7791f; }
        .unpaid { background: #fdecea; color: #c0392b; }

        .total {
            font-size: 18px;
            font-weight: bold;
            color: #005461;
        }

        .payments {
            padding: 15px 20px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }

        table th, table td {
            border: 1px solid #ddd;
            padding: 8px;
            font-size: 12px;
        }

        table th {
            background: #f4f4f4;
        }

        .text-right {
            text-align: right;
        }

        /* ===== FOOTER ===== */
        .footer {
            text-align: center;
            font-size: 11px;
            color: #888;
            padding: 10px;
            border-top: 1px solid #eee;
        }

    </style>
</head>
<body>

<div class="container">


    <div class="top-title">
        Mawater - Ayt Daoud Assosiaction
    </div>

    {{-- HEADER --}}
    <div class="header">
        <p style="margin:0; font-size:12px;">Invoice</p>
        <h2>{{ $invoice->invoice_reference }}</h2>
    </div>

    {{-- DETAILS --}}
    <div class="section">

        <div class="row">
            <span class="label">Invoice ID</span>
            <span class="value">#{{ $invoice->id }}</span>
        </div>

        <div class="row">
            <span class="label">Meter</span>
            <span class="value">{{ $invoice->reading->meter->meter_reference }}</span>
        </div>

        <div class="row">
            <span class="label">Villager</span>
            <span class="value">{{ $invoice->reading->meter->villager->user->name }}</span>
        </div>

        <div class="row">
            <span class="label">Billing Period</span>
            <span class="value">{{ $invoice->billing_period }}</span>
        </div>

        <div class="row">
            <span class="label">Consumption</span>
            <span class="value">{{ $invoice->reading->consumption }}</span>
        </div>

        <div class="row">
            <span class="label">Status</span>
            <span class="value">
                @if($invoice->status == 'paid')
                    <span class="badge paid">Paid</span>
                @elseif($invoice->status == 'partially_paid')
                    <span class="badge partial">Partial</span>
                @else
                    <span class="badge unpaid">Unpaid</span>
                @endif
            </span>
        </div>

        <div class="row">
            <span class="label">Total</span>
            <span class="value total">{{ number_format($invoice->total_amount, 2) }} DH</span>
        </div>

    </div>

    {{-- PAYMENTS --}}
    <div class="payments">
        <h3>Payments History</h3>

        <table>
            <thead>
                <tr>
                    <th>#</th>
                    <th>Amount</th>
                    <th class="text-right">Date</th>
                </tr>
            </thead>
            <tbody>
                @forelse($invoice->payments as $payment)
                    <tr>
                        <td>{{ $payment->id }}</td>
                        <td>{{ number_format($payment->amount_paid, 2) }} DH</td>
                        <td class="text-right">{{ $payment->payment_date ?? '-' }}</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="3" class="text-right">No payments found</td>
                    </tr>
                @endforelse
            </tbody>
        </table>
    </div>

    <div class="footer">
        Exported on {{ now()->format('Y-m-d H:i') }}
    </div>

</div>

</body>
</html>