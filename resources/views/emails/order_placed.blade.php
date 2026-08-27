<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Loku Kade - Order #{{ $order->order_number }} Placed!</title>
    <style>
        /* Responsive styles for email clients */
        @media only screen and (max-width: 600px) {
            .email-container { width: 100% !important; padding: 10px !important; }
            .col { display: block !important; width: 100% !important; box-sizing: border-box !important; }
            .col-spacer { height: 15px !important; }
            .details-table th, .details-table td { padding: 8px !important; font-size: 13px !important; }
        }
    </style>
</head>
<body style="font-family: 'Outfit', 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #fff7ed; color: #1e293b; margin: 0; padding: 30px 10px; -webkit-font-smoothing: antialiased;">
    <table border="0" cellpadding="0" cellspacing="0" width="100%" style="max-width: 600px; margin: 0 auto; background-color: #ffffff; border-radius: 20px; box-shadow: 0 10px 30px rgba(225, 42, 26, 0.05); overflow: hidden; border: 1px solid #fed7aa;" class="email-container">
        <!-- Header Banner -->
        <tr>
            <td align="center" style="background: linear-gradient(135deg, #e12a1a 0%, #f97316 100%); padding: 35px 20px; text-align: center;">
                <h1 style="color: #ffffff; font-size: 28px; font-weight: 700; margin: 0; font-family: 'Space Grotesk', Arial, sans-serif; letter-spacing: -0.5px;">Loku Kade</h1>
                <p style="color: #ffe4e6; font-size: 14px; margin: 8px 0 0 0; font-weight: 600; text-transform: uppercase; letter-spacing: 1.5px;">Order Confirmation</p>
            </td>
        </tr>

        <!-- Main Body Content -->
        <tr>
            <td style="padding: 30px 25px;">
                <h2 style="font-size: 20px; font-weight: 700; color: #0f172a; margin-top: 0; margin-bottom: 10px; font-family: 'Space Grotesk', Arial, sans-serif;">Thank You for Your Order!</h2>
                <p style="font-size: 15px; line-height: 1.6; color: #475569; margin: 0 0 20px 0;">
                    Dear <strong>{{ $order->customer_name }}</strong>,<br>
                    Your order has been successfully received and is currently being prepared for dispatch. We will send you another update once your package is on the way.
                </p>

                <!-- Order ID Badge -->
                <div style="background-color: #fff8f0; border: 1.5px dashed #fed7aa; border-radius: 12px; padding: 15px; margin-bottom: 25px; text-align: center;">
                    <span style="font-size: 13px; color: #7c2d12; font-weight: 600; text-transform: uppercase; letter-spacing: 0.5px; display: block; margin-bottom: 3px;">Order Number</span>
                    <strong style="font-size: 22px; color: #e12a1a; font-family: Courier, monospace; letter-spacing: 1px;">{{ $order->order_number }}</strong>
                </div>

                <!-- Products Table -->
                <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-top: 0; margin-bottom: 12px; border-bottom: 2px solid #fff7ed; padding-bottom: 6px; font-family: 'Space Grotesk', Arial, sans-serif;">Order Summary</h3>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="border-collapse: collapse; margin-bottom: 25px;" class="details-table">
                    <thead>
                        <tr style="background-color: #fff7ed;">
                            <th align="left" style="padding: 12px; font-size: 13px; font-weight: 700; color: #7c2d12; border-bottom: 2px solid #fed7aa;">Product Item</th>
                            <th align="center" style="padding: 12px; font-size: 13px; font-weight: 700; color: #7c2d12; border-bottom: 2px solid #fed7aa; width: 60px;">Qty</th>
                            <th align="right" style="padding: 12px; font-size: 13px; font-weight: 700; color: #7c2d12; border-bottom: 2px solid #fed7aa; width: 100px;">Price</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($order->details as $item)
                            <tr>
                                <td style="padding: 12px; font-size: 14px; color: #1e293b; border-bottom: 1px solid #fff7ed; font-weight: 600;">{{ $item->product_name }}</td>
                                <td align="center" style="padding: 12px; font-size: 14px; color: #475569; border-bottom: 1px solid #fff7ed;">{{ $item->quantity }}</td>
                                <td align="right" style="padding: 12px; font-size: 14px; color: #1e293b; border-bottom: 1px solid #fff7ed; font-weight: 600;">Rs. {{ number_format($item->selling_price, 2) }}</td>
                            </tr>
                        @endforeach
                        
                        <!-- Totals Calculation -->
                        @php
                            $subtotal = 0;
                            foreach($order->details as $d) {
                                $subtotal += $d->quantity * $d->selling_price;
                            }
                            $shippingCost = (float) $order->shipping_cost;
                            // Reconstruct the multi-buy discount to display in email
                            $totalQty = $order->details->sum('quantity');
                            $discount = 0;
                            if ($totalQty > 1) {
                                $discount = $shippingCost * ($totalQty - 1);
                            }
                        @endphp
                        
                        <tr>
                            <td colspan="2" align="right" style="padding: 10px 12px 4px; font-size: 13px; color: #64748b;">Subtotal:</td>
                            <td align="right" style="padding: 10px 12px 4px; font-size: 13px; color: #1e293b; font-weight: 600;">Rs. {{ number_format($subtotal, 2) }}</td>
                        </tr>
                        <tr>
                            <td colspan="2" align="right" style="padding: 4px 12px; font-size: 13px; color: #64748b;">Shipping (Courier):</td>
                            <td align="right" style="padding: 4px 12px; font-size: 13px; color: #16a34a; font-weight: 700;">Free</td>
                        </tr>
                        @if($discount > 0)
                            <tr>
                                <td colspan="2" align="right" style="padding: 4px 12px; font-size: 13px; color: #64748b;">Multi-Buy Discount:</td>
                                <td align="right" style="padding: 4px 12px; font-size: 13px; color: #16a34a; font-weight: 700;">-Rs. {{ number_format($discount, 2) }}</td>
                            </tr>
                        @endif
                        <tr style="border-top: 1.5px solid #fed7aa;">
                            <td colspan="2" align="right" style="padding: 12px 12px 0; font-size: 15px; font-weight: 700; color: #0f172a;">Total Amount to Pay:</td>
                            <td align="right" style="padding: 12px 12px 0; font-size: 17px; font-weight: 800; color: #e12a1a;">Rs. {{ number_format($order->total_amount, 2) }}</td>
                        </tr>
                    </tbody>
                </table>

                <!-- Customer Details Card -->
                <h3 style="font-size: 16px; font-weight: 700; color: #0f172a; margin-top: 0; margin-bottom: 12px; border-bottom: 2px solid #fff7ed; padding-bottom: 6px; font-family: 'Space Grotesk', Arial, sans-serif;">Delivery Details</h3>
                <table border="0" cellpadding="0" cellspacing="0" width="100%" style="background-color: #fffaf5; border: 1px solid #fed7aa; border-radius: 12px; padding: 15px; margin-bottom: 25px;">
                    <tr>
                        <td style="font-size: 14px; line-height: 1.6; color: #475569;">
                            <strong style="color: #0f172a; display: block; margin-bottom: 4px;">{{ $order->customer_name }}</strong>
                            {{ $order->customer_address }},<br>
                            {{ $order->customer_city }}.<br>
                            <span style="display: block; margin-top: 8px; font-size: 13px;">
                                <strong style="color: #0f172a;">Mobile:</strong> {{ $order->customer_pri_mobile }} 
                                @if($order->customer_sec_mobile) / {{ $order->customer_sec_mobile }} @endif
                            </span>
                            <span style="display: block; margin-top: 4px; font-size: 13px;">
                                <strong style="color: #0f172a;">Payment Mode:</strong> Cash on Delivery (COD)
                            </span>
                        </td>
                    </tr>
                </table>

                <!-- Action Button -->
                <table border="0" cellpadding="0" cellspacing="0" width="100%">
                    <tr>
                        <td align="center" style="padding: 10px 0 15px 0;">
                            <a href="{{ url('/orders/track/' . $order->secure_token) }}" target="_blank" style="background: linear-gradient(135deg, #e12a1a 0%, #f97316 100%); color: #ffffff; display: inline-block; padding: 14px 30px; font-size: 15px; font-weight: 700; text-decoration: none; border-radius: 12px; box-shadow: 0 8px 16px rgba(225, 42, 26, 0.25); font-family: 'Space Grotesk', Arial, sans-serif; border: none; outline: none;">Track Your Package</a>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>

        <!-- Footer Block -->
        <tr>
            <td align="center" style="background-color: #fff7ed; padding: 30px 20px; border-top: 1px solid #fed7aa; text-align: center;">
                <p style="font-size: 14px; margin: 0 0 12px 0; color: #475569; font-weight: 600;">Need assistance? We are here to help!</p>
                <!-- Support Row -->
                <table border="0" cellpadding="0" cellspacing="0" style="margin-bottom: 20px;">
                    <tr>
                        <td style="padding: 0 10px;">
                            <a href="https://wa.me/94706050500" target="_blank" style="color: #16a34a; font-size: 13px; font-weight: 700; text-decoration: none; display: inline-flex; align-items: center; gap: 4px;">
                                <span style="font-size: 15px; vertical-align: middle;">💬</span> Message on WhatsApp
                            </a>
                        </td>
                    </tr>
                </table>
                <p style="font-size: 12px; margin: 0; color: #94a3b8; font-family: 'Outfit', sans-serif;">
                    &copy; {{ date('Y') }} Loku Kade E-Commerce. All rights reserved.<br>
                    Colombo, Sri Lanka.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>
