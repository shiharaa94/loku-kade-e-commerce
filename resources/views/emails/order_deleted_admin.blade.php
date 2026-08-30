<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Customer Cancelled Order - Loku Kade</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 20px;
            line-height: 1.5;
        }
        .email-container {
            max-width: 600px;
            margin: 0 auto;
            background: #ffffff;
            border-radius: 16px;
            border: 1px solid #e2e8f0;
            overflow: hidden;
            box-shadow: 0 4px 15px rgba(0, 0, 0, 0.05);
        }
        .header {
            background: linear-gradient(135deg, #dc2626 0%, #b91c1c 100%);
            color: #ffffff;
            padding: 24px;
            text-align: center;
        }
        .header h1 {
            margin: 0;
            font-size: 1.35rem;
            font-weight: 700;
        }
        .header p {
            margin: 6px 0 0;
            font-size: 0.85rem;
            opacity: 0.9;
        }
        .content {
            padding: 24px;
        }
        .alert-box {
            background: #fef2f2;
            border: 1.5px solid #fecaca;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
        }
        .alert-title {
            color: #991b1b;
            font-weight: 700;
            font-size: 0.95rem;
            margin-bottom: 4px;
        }
        .alert-desc {
            color: #7f1d1d;
            font-size: 0.85rem;
            margin: 0;
        }
        .info-grid {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
        }
        .info-grid td {
            padding: 8px 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.88rem;
        }
        .info-grid td.label {
            color: #64748b;
            font-weight: 600;
            width: 38%;
        }
        .info-grid td.value {
            color: #0f172a;
            font-weight: 500;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
            margin-bottom: 20px;
        }
        .items-table th {
            background: #f8fafc;
            padding: 10px 12px;
            text-align: left;
            font-size: 0.78rem;
            color: #475569;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            border-bottom: 2px solid #e2e8f0;
        }
        .items-table td {
            padding: 10px 12px;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.88rem;
        }
        .total-row td {
            font-weight: 700;
            font-size: 1rem;
            color: #0f172a;
            border-top: 2px solid #e2e8f0;
            padding-top: 12px;
        }
        .badge-restored {
            display: inline-block;
            background: #dcfce7;
            color: #166534;
            padding: 4px 8px;
            border-radius: 6px;
            font-size: 0.75rem;
            font-weight: 700;
        }
        .footer {
            background: #f8fafc;
            padding: 16px;
            text-align: center;
            border-top: 1px solid #e2e8f0;
            font-size: 0.75rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="email-container">
    <div class="header">
        <h1>⚠️ Customer Cancelled Order</h1>
        <p>Order #{{ $orderData['order_number'] }} has been deleted by the client</p>
    </div>

    <div class="content">
        <div class="alert-box">
            <div class="alert-title">Order Deletion Notice</div>
            <p class="alert-desc">
                The client cancelled this pending order from their Customer Panel. All reserved inventory item stocks have been automatically restored.
            </p>
        </div>

        <h3 style="font-size: 1rem; color: #0f172a; margin-bottom: 10px; border-bottom: 2px solid #f1f5f9; padding-bottom: 6px;">Customer & Order Details</h3>
        <table class="info-grid">
            <tr>
                <td class="label">Order Number:</td>
                <td class="value"><strong>#{{ $orderData['order_number'] }}</strong></td>
            </tr>
            <tr>
                <td class="label">Customer Name:</td>
                <td class="value">{{ $orderData['customer_name'] }}</td>
            </tr>
            <tr>
                <td class="label">Customer Email:</td>
                <td class="value"><a href="mailto:{{ $orderData['customer_email'] }}" style="color: #2563eb;">{{ $orderData['customer_email'] }}</a></td>
            </tr>
            <tr>
                <td class="label">Primary Phone:</td>
                <td class="value"><a href="tel:{{ $orderData['customer_pri_mobile'] }}" style="color: #0f172a; font-weight: 600;">{{ $orderData['customer_pri_mobile'] }}</a></td>
            </tr>
            @if(!empty($orderData['customer_sec_mobile']))
            <tr>
                <td class="label">Secondary Phone:</td>
                <td class="value">{{ $orderData['customer_sec_mobile'] }}</td>
            </tr>
            @endif
            <tr>
                <td class="label">Delivery Address:</td>
                <td class="value">{{ $orderData['customer_address'] }}, {{ $orderData['customer_city'] }}</td>
            </tr>
            <tr>
                <td class="label">Cancelled At:</td>
                <td class="value">{{ $orderData['deleted_at'] }}</td>
            </tr>
            <tr>
                <td class="label">Stock Action:</td>
                <td class="value"><span class="badge-restored">✓ Stock Restored</span></td>
            </tr>
        </table>

        <h3 style="font-size: 1rem; color: #0f172a; margin-bottom: 10px; border-bottom: 2px solid #f1f5f9; padding-bottom: 6px;">Cancelled Items</h3>
        <table class="items-table">
            <thead>
                <tr>
                    <th>Item</th>
                    <th style="text-align: center;">Qty</th>
                    <th style="text-align: right;">Unit Price</th>
                    <th style="text-align: right;">Total</th>
                </tr>
            </thead>
            <tbody>
                @foreach($orderData['items'] as $item)
                <tr>
                    <td>
                        <strong style="color: #0f172a;">{{ $item['product_name'] }}</strong>
                    </td>
                    <td style="text-align: center; font-weight: 600;">{{ $item['quantity'] }}</td>
                    <td style="text-align: right;">Rs. {{ number_format($item['selling_price'], 2) }}</td>
                    <td style="text-align: right; font-weight: 600;">Rs. {{ number_format($item['amount'], 2) }}</td>
                </tr>
                @endforeach
                <tr class="total-row">
                    <td colspan="3" style="text-align: right;">Total Order Amount:</td>
                    <td style="text-align: right; color: #dc2626;">Rs. {{ number_format($orderData['total_amount'], 2) }}</td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Loku Kade Automated Store Notification &bull; info@lokukade.lk
    </div>
</div>

</body>
</html>
