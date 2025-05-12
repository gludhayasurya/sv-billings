<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Invoice - Billing Entry</title>
    <style>
        body {
            font-family: 'Segoe UI', sans-serif;
            margin: 0;
            padding: 40px;
            background: #f7f7f7;
        }

        .invoice-box {
            background: #fff;
            padding: 30px;
            border: 1px solid #eee;
            max-width: 800px;
            margin: auto;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.15);
        }

        h1 {
            text-align: center;
            color: #333;
            font-size: 28px;
            margin-bottom: 20px;
        }

        .section {
            display: flex;
            justify-content: space-between;
            margin-bottom: 20px;
            font-size: 16px;
        }

        .section div {
            width: 48%;
        }

        .section p {
            margin: 4px 0;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 20px;
        }

        th, td {
            padding: 12px;
            border: 1px solid #ccc;
        }

        th {
            background-color: #f0f0f0;
            text-align: left;
        }

        .total-section {
            margin-top: 20px;
            font-size: 16px;
            text-align: right;
        }

        .footer {
            text-align: center;
            font-size: 14px;
            color: #888;
            margin-top: 40px;
        }

        @media print {
            body {
                background: #fff;
                padding: 0;
            }

            .invoice-box {
                box-shadow: none;
                border: none;
            }
        }
    </style>
</head>
<body>

<div class="invoice-box">
    <h1>Invoice</h1>

    <!-- From and To -->
    <div class="section">
        <div>
            <p><strong>From:</strong> {{ $billing->from ?? 'N/A' }}</p>
            <p><strong>Event:</strong> {{ $billing->event_name ?? 'N/A' }}</p>
        </div>
        <div>
            <p><strong>To:</strong> {{ $billing->to ?? 'N/A' }}</p>
            <p><strong>Place:</strong> {{ $billing->place ?? 'N/A' }}</p>
        </div>
    </div>

    <!-- Billing Info -->
    <div class="section">
        <div>
            <p><strong>Date:</strong> {{ $billing->created_at->format('d-m-Y') }}</p>
            <p><strong>Invoice ID:</strong> #INV-{{ str_pad($billing->id, 5, '0', STR_PAD_LEFT) }}</p>
        </div>
    </div>

    <!-- Billing Table -->
    <table>
        <thead>
            <tr>
                <th>Description</th>
                <th>Rate</th>
                <th>Quantity</th>
                <th>Sq. Ft</th>
                <th>Total</th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td>
                    @if($billing->type === 'material')
                        Material Billing
                    @else
                        Worker Billing
                    @endif
                </td>
                <td>₹{{ number_format($billing->rate, 2) }}</td>
                <td>{{ $billing->qty ?? '-' }}</td>
                <td>{{ $billing->sqft ?? '-' }}</td>
                <td><strong>₹{{ number_format($billing->total, 2) }}</strong></td>
            </tr>
        </tbody>
    </table>

    <!-- Total & Words -->
    <div class="total-section">
        <p><strong>Overall Total:</strong> ₹{{ number_format($billing->total, 2) }}</p>
        <p><strong>Total in Words:</strong> {{ \NumberFormatter::create('en_IN', \NumberFormatter::SPELLOUT)->format($billing->total) }} Rupees Only</p>
    </div>

    <p><strong>Note:</strong> This is a system-generated invoice and does not require a signature.</p>

    <div class="footer">
        © {{ date('Y') }} Your Company Name. All rights reserved.
    </div>
</div>

<script>
    window.onload = () => {
        window.print();
    };
</script>

</body>
</html>
