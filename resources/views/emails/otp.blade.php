<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <title>Password Reset OTP</title>
</head>
<body style="font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif; background-color: #f3f4f6; padding: 30px; margin: 0; color: #1f2937;">
    <div style="max-width: 500px; background-color: #ffffff; border-radius: 12px; margin: 0 auto; box-shadow: 0 4px 10px rgba(0, 0, 0, 0.05); border: 1px solid #e5e7eb; overflow: hidden;">
        <!-- Header -->
        <div style="background: linear-gradient(135deg, #dc2626 0%, #f97316 100%); padding: 24px; text-align: center;">
            <h1 style="color: #ffffff; margin: 0; font-size: 1.5rem; font-weight: 700; letter-spacing: 0.5px;">Loku Kade</h1>
        </div>
        
        <!-- Body -->
        <div style="padding: 30px;">
            <p style="font-size: 1rem; line-height: 1.5; margin-bottom: 20px;">Hello {{ $user->first_name ?? 'Customer' }},</p>
            <p style="font-size: 0.95rem; line-height: 1.6; color: #4b5563;">We received a request to reset the password for your account. Please use the following One-Time Password (OTP) to complete the verification process:</p>
            
            <!-- OTP Box -->
            <div style="font-size: 2rem; font-weight: 700; background-color: #f9fafb; border: 1.5px dashed #d1d5db; padding: 16px; text-align: center; border-radius: 8px; letter-spacing: 6px; margin: 24px 0; color: #dc2626;">
                {{ $otp }}
            </div>
            
            <p style="font-size: 0.9rem; line-height: 1.5; color: #ef4444; font-weight: 600; margin-bottom: 20px;">
                Note: This OTP code is valid for 15 minutes only.
            </p>
            
            <p style="font-size: 0.88rem; line-height: 1.5; color: #6b7280;">If you did not initiate this request, you can safely ignore this email. Your account password will remain unchanged.</p>
        </div>
        
        <!-- Footer -->
        <div style="background-color: #f9fafb; padding: 20px; text-align: center; border-top: 1px solid #f3f4f6; font-size: 0.8rem; color: #9ca3af;">
            <p style="margin: 0 0 5px 0;">&copy; {{ date('Y') }} Loku Kade. All rights reserved.</p>
            <p style="margin: 0;">Polonnaruwa, Sri Lanka | WhatsApp Support: 070 60 50 500</p>
        </div>
    </div>
</body>
</html>
