<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Your Order has been Delivered!</title>
    <style>
        body { font-family: 'Outfit', 'Helvetica Neue', Helvetica, Arial, sans-serif; background-color: #f3f4f6; color: #1f2937; margin: 0; padding: 20px; }
        .container { max-width: 600px; margin: 0 auto; background: #ffffff; padding: 30px; border-radius: 12px; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .header { text-align: center; border-bottom: 2px solid #f3f4f6; padding-bottom: 20px; margin-bottom: 20px; }
        .logo { font-size: 24px; font-weight: bold; color: #dc2626; text-decoration: none; }
        .logo span { color: #1f2937; }
        .btn { display: inline-block; background-color: #dc2626; color: #ffffff !important; padding: 12px 24px; border-radius: 8px; text-decoration: none; font-weight: 600; margin-top: 20px; text-align: center; }
        .footer { text-align: center; font-size: 12px; color: #6b7280; margin-top: 30px; border-top: 1px solid #e5e7eb; padding-top: 20px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="{{ url('/') }}" class="logo">Loku <span>Kade</span></a>
            <h2>Your Order has been Delivered!</h2>
        </div>
        <p>Dear {{ $order->customer_name }},</p>
        <p>We are pleased to inform you that your order <strong>#{{ $order->order_number }}</strong> has been successfully delivered!</p>
        <p>We hope you love your new purchase. Your feedback is extremely valuable to us and helps other customers find the best quality products.</p>
        <p>Please take a moment to rate and review the products you purchased. You can easily do so by clicking the button below:</p>

        <div style="text-align: center;">
            <a href="{{ url('/orders/review/' . $order->secure_token) }}" class="btn">Submit Product Reviews</a>
        </div>

        <p style="margin-top: 25px; color: #ef4444; font-size: 0.9rem; font-weight: 500;">Please note: You can only edit your review on the day of submission.</p>

        <p>Thank you for choosing Loku Kade!</p>

        <div class="footer">
            <p>&copy; {{ date('Y') }} Loku Kade E-Commerce. All rights reserved.</p>
        </div>
    </div>
</body>
</html>
