<!DOCTYPE html>
<html lang="si">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>පිටුව සොයාගත නොහැක (404) - Loku Kade</title>
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
            font-family: 'Outfit', sans-serif;
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

        .error-card {
            background: #ffffff;
            border: 1px solid #fed7aa;
            border-radius: 24px;
            box-shadow: 0 20px 45px rgba(220, 38, 38, 0.08), 0 4px 12px rgba(0, 0, 0, 0.03);
            max-width: 580px;
            width: 100%;
            padding: 45px 30px;
            text-align: center;
            position: relative;
            overflow: hidden;
        }

        .error-card::before {
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
            margin-bottom: 20px;
            text-decoration: none;
        }

        .logo-img {
            width: 50px;
            height: 50px;
            border-radius: 50%;
            box-shadow: 0 4px 10px rgba(0,0,0,0.1);
        }

        .logo-text {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.5rem;
            font-weight: 700;
            color: var(--dark);
        }

        .logo-text span {
            color: var(--primary);
        }

        .error-code {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 5.5rem;
            font-weight: 800;
            line-height: 1;
            background: var(--primary-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            margin-bottom: 10px;
            letter-spacing: -2px;
        }

        h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.55rem;
            font-weight: 700;
            color: var(--dark);
            margin-bottom: 10px;
        }

        p.desc-si {
            font-size: 0.98rem;
            color: var(--text-muted);
            line-height: 1.6;
            margin-bottom: 6px;
        }

        p.desc-en {
            font-size: 0.85rem;
            color: #64748b;
            line-height: 1.5;
            margin-bottom: 28px;
        }

        .btn-group-custom {
            display: flex;
            gap: 12px;
            justify-content: center;
            flex-wrap: wrap;
            margin-bottom: 25px;
        }

        .btn-custom {
            padding: 12px 24px;
            border-radius: 12px;
            font-weight: 700;
            font-size: 0.92rem;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 8px;
            transition: all 0.2s ease;
        }

        .btn-primary-custom {
            background: var(--primary-gradient);
            color: #ffffff;
            box-shadow: 0 4px 14px rgba(220, 38, 38, 0.3);
        }

        .btn-primary-custom:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 18px rgba(220, 38, 38, 0.4);
            color: #ffffff;
        }

        .btn-outline-custom {
            background: #ffffff;
            color: #374151;
            border: 1.5px solid #d1d5db;
        }

        .btn-outline-custom:hover {
            background: #f9fafb;
            border-color: var(--primary);
            color: var(--primary);
            transform: translateY(-2px);
        }

        .help-note {
            font-size: 0.84rem;
            color: #64748b;
            border-top: 1px solid #f1f5f9;
            padding-top: 20px;
        }

        .help-note a {
            color: #16a34a;
            font-weight: 700;
            text-decoration: none;
        }
    </style>
</head>
<body>

<div class="error-card">
    <a href="{{ route('home') }}" class="logo-wrap" aria-label="Loku Kade Home">
        <img src="{{ asset('assets/images/logo.webp') }}" alt="Loku Kade Logo" class="logo-img" width="50" height="50">
        <span class="logo-text">Loku <span>Kade</span></span>
    </a>

    <div class="error-code">404</div>

    <h1>පිටුව සොයාගත නොහැක</h1>
    <p class="desc-si">
        ඔබ සොයන පිටුව ඉවත් කර, එහි නම වෙනස් කර හෝ තාවකාලිකව ලබාගත නොහැකි තත්වයක පවතී.
    </p>
    <p class="desc-en">
        The page you are looking for might have been removed, had its name changed, or is temporarily unavailable.
    </p>

    <div class="btn-group-custom">
        <a href="{{ route('home') }}" class="btn-custom btn-primary-custom">
            <i class="bi bi-house-door-fill"></i> මුල් පිටුවට (Home)
        </a>
        <a href="{{ route('products.shop') }}" class="btn-custom btn-outline-custom">
            <i class="bi bi-bag-fill"></i> භාණ්ඩ බලන්න (Shop)
        </a>
    </div>

    <div class="help-note">
        උදව් අවශ්‍යද? <a href="https://wa.me/94706050500" target="_blank"><i class="bi bi-whatsapp"></i> WhatsApp සහය ලබාගන්න</a>
    </div>
</div>

</body>
</html>
