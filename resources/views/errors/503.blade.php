<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>අලුත්වැඩියාවක් සිදුවෙමින් පවතී - Loku Kade</title>
    <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css">
    
    <style>
        :root {
            --primary: #dc2626;
            --primary-gradient: linear-gradient(135deg, #dc2626 0%, #ea580c 100%);
            --dark: #0f172a;
            --text-muted: #475569;
            --bg-page: #fff8f5;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Outfit', -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, sans-serif;
        }

        body {
            background-color: var(--bg-page);
            background-image: 
                radial-gradient(circle at 15% 15%, rgba(220, 38, 38, 0.07) 0%, transparent 40%),
                radial-gradient(circle at 85% 85%, rgba(234, 88, 12, 0.07) 0%, transparent 40%);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
            color: var(--dark);
        }

        .maintenance-card {
            background: #ffffff;
            border: 1px solid #fed7aa;
            border-radius: 24px;
            box-shadow: 0 20px 45px rgba(220, 38, 38, 0.08), 0 4px 12px rgba(0, 0, 0, 0.03);
            max-width: 600px;
            width: 100%;
            padding: 40px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .maintenance-card::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            height: 6px;
            background: var(--primary-gradient);
        }

        .logo-wrap {
            display: inline-flex;
            align-items: center;
            gap: 10px;
            margin-bottom: 25px;
            text-decoration: none;
        }

        .logo-img {
            width: 52px;
            height: 52px;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .logo-text {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.6rem;
            font-weight: 700;
            color: var(--dark);
        }

        .logo-text span {
            color: var(--primary);
        }

        .pulse-icon-box {
            width: 100px;
            height: 100px;
            background: #fef2f2;
            border: 2px solid #fecaca;
            border-radius: 50%;
            margin: 0 auto 25px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            animation: pulse-ring 2.5s infinite;
        }

        .pulse-icon-box i {
            font-size: 2.8rem;
            color: var(--primary);
            animation: spin-slow 12s linear infinite;
        }

        @keyframes pulse-ring {
            0% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0.25); }
            70% { box-shadow: 0 0 0 20px rgba(220, 38, 38, 0); }
            100% { box-shadow: 0 0 0 0 rgba(220, 38, 38, 0); }
        }

        @keyframes spin-slow {
            0% { transform: rotate(0deg); }
            100% { transform: rotate(360deg); }
        }

        .badge-status {
            display: inline-flex;
            align-items: center;
            gap: 6px;
            background: #fee2e2;
            color: #b91c1c;
            padding: 6px 14px;
            border-radius: 20px;
            font-size: 0.82rem;
            font-weight: 700;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            margin-bottom: 16px;
        }

        .status-dot {
            width: 8px;
            height: 8px;
            background-color: #ef4444;
            border-radius: 50%;
            animation: blink 1.2s infinite;
        }

        @keyframes blink {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.3; }
        }

        h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.7rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 12px;
            line-height: 1.35;
        }

        p.desc-si {
            font-size: 1rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 8px;
        }

        p.desc-en {
            font-size: 0.88rem;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 25px;
        }

        .notice-box {
            background: #fffaf0;
            border: 1.5px dashed #fed7aa;
            border-radius: 14px;
            padding: 16px 20px;
            margin-bottom: 25px;
            text-align: center;
        }

        .notice-box p {
            font-size: 0.92rem;
            font-weight: 600;
            color: #9a3412;
            margin-bottom: 12px;
        }

        .btn-whatsapp {
            background-color: #25d366;
            color: #ffffff;
            font-weight: 700;
            font-size: 0.95rem;
            padding: 12px 24px;
            border-radius: 12px;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 8px;
            box-shadow: 0 4px 14px rgba(37, 211, 102, 0.3);
            transition: all 0.2s ease;
            width: 100%;
        }

        .btn-whatsapp:hover {
            background-color: #22c55e;
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(37, 211, 102, 0.4);
            color: #ffffff;
        }

        .social-strip {
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
            margin-top: 20px;
            display: flex;
            justify-content: center;
            gap: 15px;
        }

        .social-link {
            color: #64748b;
            font-size: 1.2rem;
            text-decoration: none;
            transition: color 0.2s;
        }

        .social-link:hover {
            color: var(--primary);
        }

        .footer-note {
            margin-top: 15px;
            font-size: 0.78rem;
            color: #94a3b8;
        }
    </style>
</head>
<body>

<div class="maintenance-card">
    <div class="logo-wrap">
        <img src="{{ asset('assets/images/logo.webp') }}" alt="Loku Kade Logo" class="logo-img" width="52" height="52">
        <span class="logo-text">Loku <span>Kade</span></span>
    </div>

    <div class="pulse-icon-box">
        <i class="bi bi-gear-wide-connected"></i>
    </div>

    <div class="badge-status">
        <span class="status-dot"></span> System Update In Progress
    </div>

    <h1>අපි අලුත් වෙමින් පවතිනවා!</h1>
    <p class="desc-si">
        ඔබට වඩාත් වේගවත් හා උසස් සේවාවක් ලබාදීම සඳහා Loku Kade වෙබ් අඩවිය මේ වනවිට යාවත්කාලීන වෙමින් පවතී. සුළු මොහොතකින් නැවත ඔබ හමුවන්නෙමු.
    </p>
    <p class="desc-en">
        We are performing scheduled maintenance and updates to improve your shopping experience. We'll be back online shortly!
    </p>

    <div class="notice-box">
        <p><i class="bi bi-whatsapp me-1" style="color: #25d366;"></i> හදිසි ඇණවුම් සහ විමසීම් සඳහා අප හා සම්බන්ධ වන්න:</p>
        <a href="https://wa.me/94706050500?text=Hi%20Loku%20Kade,%20I%20would%20like%20to%20order%20during%20maintenance" target="_blank" class="btn-whatsapp">
            <i class="bi bi-whatsapp fs-5"></i> Order via WhatsApp (070 60 50 500)
        </a>
    </div>

    <div class="social-strip">
        <a href="https://chat.whatsapp.com/CJCovpx4T48KDnooTN2oB2" target="_blank" class="social-link" title="WhatsApp Community"><i class="bi bi-people-fill"></i></a>
        <a href="https://whatsapp.com/channel/0029Vb80LU44dTnE13ErDb3Y" target="_blank" class="social-link" title="WhatsApp Channel"><i class="bi bi-broadcast"></i></a>
        <a href="https://www.facebook.com/profile.php?id=61569444895967" target="_blank" class="social-link" title="Facebook"><i class="bi bi-facebook"></i></a>
        <a href="https://www.instagram.com/lokukade" target="_blank" class="social-link" title="Instagram"><i class="bi bi-instagram"></i></a>
        <a href="https://www.tiktok.com/@loku.kade" target="_blank" class="social-link" title="TikTok"><i class="bi bi-tiktok"></i></a>
    </div>

    <div class="footer-note">
        &copy; {{ date('Y') }} Loku Kade E-Commerce. All rights reserved.
    </div>
</div>

</body>
</html>
