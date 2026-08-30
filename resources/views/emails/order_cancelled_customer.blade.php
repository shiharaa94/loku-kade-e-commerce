<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Order Cancellation Confirmation - Loku Kade</title>
    <style>
        body {
            font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
            background-color: #f8fafc;
            color: #1e293b;
            margin: 0;
            padding: 20px;
            line-height: 1.6;
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
            background: #ffffff;
            padding: 25px 20px 15px;
            text-align: center;
            border-bottom: 1px solid #f1f5f9;
        }
        .logo-text {
            font-size: 1.5rem;
            font-weight: 800;
            color: #0f172a;
        }
        .logo-text span {
            color: #dc2626;
        }
        .status-badge-wrap {
            text-align: center;
            padding: 25px 20px 10px;
        }
        .status-badge {
            display: inline-block;
            background: #fee2e2;
            color: #991b1b;
            font-size: 0.9rem;
            font-weight: 700;
            padding: 6px 16px;
            border-radius: 99px;
            border: 1px solid #fecaca;
        }
        .content {
            padding: 10px 25px 25px;
        }
        .greeting {
            font-size: 1.15rem;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 8px;
        }
        .message-si {
            font-size: 0.95rem;
            color: #475569;
            margin-bottom: 12px;
        }
        .message-en {
            font-size: 0.85rem;
            color: #64748b;
            margin-bottom: 24px;
        }
        .order-box {
            background: #f8fafc;
            border: 1px solid #e2e8f0;
            border-radius: 12px;
            padding: 16px;
            margin-bottom: 20px;
        }
        .items-table {
            width: 100%;
            border-collapse: collapse;
            margin-top: 10px;
        }
        .items-table th {
            text-align: left;
            font-size: 0.78rem;
            color: #64748b;
            text-transform: uppercase;
            padding-bottom: 8px;
            border-bottom: 1px solid #e2e8f0;
        }
        .items-table td {
            padding: 10px 0;
            border-bottom: 1px solid #f1f5f9;
            font-size: 0.88rem;
        }
        .btn-shop {
            display: block;
            background: linear-gradient(135deg, #dc2626 0%, #ea580c 100%);
            color: #ffffff !important;
            text-align: center;
            padding: 14px 20px;
            border-radius: 12px;
            font-weight: 700;
            text-decoration: none;
            font-size: 0.95rem;
            margin: 20px 0;
        }
        .help-box {
            background: #f0fdf4;
            border: 1px solid #bbf7d0;
            border-radius: 12px;
            padding: 16px;
            text-align: center;
            font-size: 0.85rem;
            color: #166534;
        }
        .help-box a {
            color: #15803d;
            font-weight: 700;
            text-decoration: underline;
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
        <div class="logo-text">Loku <span>Kade</span></div>
    </div>

    <div class="status-badge-wrap">
        <span class="status-badge">Order Cancelled / අවලංගු කරන ලදී</span>
    </div>

    <div class="content">
        <div class="greeting">ආයුබෝවන් {{ $orderData['customer_name'] }},</div>
        <p class="message-si">
            ඔබ විසින් කරන ලද ඉල්ලීම පරිදි <strong>#{{ $orderData['order_number'] }}</strong> දරණ ඔබගේ ඇණවුම සාර්ථකව අවලංගු (Cancelled) කරන ලදී.
        </p>
        <p class="message-en">
            As requested, your order #{{ $orderData['order_number'] }} has been cancelled successfully. No further action is required.
        </p>

        <div class="order-box">
            <div style="font-size: 0.85rem; color: #64748b; margin-bottom: 4px;">Cancelled Order Summary:</div>
            <div style="font-size: 1rem; font-weight: 700; color: #0f172a; margin-bottom: 12px;">Order #{{ $orderData['order_number'] }}</div>

            <table class="items-table">
                <thead>
                    <tr>
                        <th>භාණ්ඩය (Item)</th>
                        <th style="text-align: center;">Qty</th>
                        <th style="text-align: right;">මිල (Price)</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($orderData['items'] as $item)
                    <tr>
                        <td style="color: #0f172a; font-weight: 500;">{{ $item['product_name'] }}</td>
                        <td style="text-align: center;">{{ $item['quantity'] }}</td>
                        <td style="text-align: right; font-weight: 600;">Rs. {{ number_format($item['amount'], 2) }}</td>
                    </tr>
                    @endforeach
                    <tr>
                        <td colspan="2" style="font-weight: 700; padding-top: 12px; border-bottom: none;">Total Amount:</td>
                        <td style="text-align: right; font-weight: 700; color: #dc2626; padding-top: 12px; border-bottom: none;">Rs. {{ number_format($orderData['total_amount'], 2) }}</td>
                    </tr>
                </tbody>
            </table>
        </div>

        <a href="https://lokukade.lk/shop" class="btn-shop" target="_blank">
            🛍️ වෙනත් භාණ්ඩ බලන්න (Explore Products)
        </a>

        <div class="help-box">
            ගැටලුවක් හෝ උදව්වක් අවශ්‍ය නම් අපගේ WhatsApp සේවාව හා සම්බන්ධ වන්න:<br>
            <a href="https://wa.me/94706050500" target="_blank">070 60 50 500 (WhatsApp)</a>
        </div>
    </div>

    <div class="footer">
        &copy; {{ date('Y') }} Loku Kade. All Rights Reserved. &bull; www.lokukade.lk
    </div>
</div>

</body>
</html>
