<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  
  {{-- CSRF Token for Secure Post Requests --}}
  <meta name="csrf-token" content="{{ csrf_token() }}">
  
  <!-- Primary SEO Meta Tags -->
  <title>@yield('title', 'Loku Kade - Premium Wholesale & Retail E-Commerce in Sri Lanka')</title>
  <meta name="description" content="@yield('meta_description', 'Explore high-quality household items, electronics, and kitchen accessories at Loku Kade. Fast Cash on Delivery island-wide.')">
  <meta name="keywords" content="@yield('meta_keywords', 'Loku Kade, online shopping Sri Lanka, cash on delivery, kitchen accessories, electronics, wholesale retail Sri Lanka')">
  <meta name="author" content="Loku Kade">
  <meta name="robots" content="index, follow, max-image-preview:large, max-snippet:-1, max-video-preview:-1">
  <link rel="canonical" href="{{ url()->current() }}">

  <!-- Open Graph Meta Tags -->
  <meta property="og:site_name" content="Loku Kade">
  <meta property="og:type" content="@yield('og_type', 'website')">
  <meta property="og:url" content="{{ url()->current() }}">
  <meta property="og:title" content="@yield('title', 'Loku Kade - Premium Wholesale & Retail E-Commerce')">
  <meta property="og:description" content="@yield('meta_description', 'Explore high-quality household items, electronics, and kitchen accessories at Loku Kade.')">
  <meta property="og:image" content="@yield('og_image', asset('assets/images/logo.webp'))">

  <!-- Twitter Card Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:title" content="@yield('title', 'Loku Kade - Premium Wholesale & Retail E-Commerce')">
  <meta name="twitter:description" content="@yield('meta_description', 'Explore high-quality household items, electronics, and kitchen accessories at Loku Kade.')">
  <meta name="twitter:image" content="@yield('og_image', asset('assets/images/logo.webp'))">

  <!-- Structured Data (JSON-LD Schema) -->
  @yield('schema')

  <!-- Favicon Configuration -->
  <link rel="icon" type="image/png" href="{{ asset('assets/images/favicon.png') }}">
  <link rel="apple-touch-icon" href="{{ asset('assets/images/favicon.png') }}">

  <!-- PWA Settings -->
  <link rel="manifest" href="/manifest.json">
  <meta name="theme-color" content="#dc2626">
  <meta name="mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-capable" content="yes">
  <meta name="apple-mobile-web-app-status-bar-style" content="default">
  <meta name="apple-mobile-web-app-title" content="Loku Kade">
  <link rel="apple-touch-icon" sizes="192x192" href="/assets/images/icon-192x192.png">
  
  <script>
    if ('serviceWorker' in navigator) {
      window.addEventListener('load', () => {
        navigator.serviceWorker.register('/service-worker.js')
          .then((reg) => console.log('PWA Service Worker registered successfully on scope:', reg.scope))
          .catch((err) => console.error('PWA Service Worker registration failed:', err));
      });
    }
  </script>

  <!-- Google Fonts with display=swap & Preload -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Space+Grotesk:wght@500;700&display=swap">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">

  <!-- Bootstrap Icons Asynchronously -->
  <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"></noscript>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Custom Stylesheet -->
  <link rel="stylesheet" href="{{ asset('style.css') }}?v={{ file_exists(public_path('style.css')) ? filemtime(public_path('style.css')) : '1.2' }}">

  <!-- Custom Styles (Cart Drawer & Desktop Search Bar) -->
  <style>
    /* --- Header Layout & Desktop Search Bar Below Nav Links --- */
    header {
      padding: 0.65rem 0 0.75rem !important;
    }

    header .container {
      display: flex !important;
      flex-direction: column !important;
      align-items: center !important;
      gap: 0.6rem !important;
      height: auto !important;
    }

    .header-top-row {
      display: flex !important;
      width: 100% !important;
      justify-content: space-between !important;
      align-items: center !important;
      gap: 1rem !important;
    }

    .header-search-bottom-row {
      display: none;
    }

    @media (min-width: 992px) {
      .header-search-bottom-row {
        display: flex !important;
        justify-content: center !important;
        width: 100% !important;
      }

      .header-search-bottom-row .desktop-search-form {
        width: 100% !important;
        max-width: 600px !important;
        background: #ffffff !important;
        border: 1.5px solid #d1d5db !important;
        border-radius: 99px !important;
        padding: 4px 6px 4px 18px !important;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.05) !important;
        display: flex !important;
        align-items: center !important;
        transition: all 0.25s ease !important;
      }

      .header-search-bottom-row .desktop-search-form:hover {
        border-color: #9ca3af !important;
        box-shadow: 0 4px 12px rgba(0, 0, 0, 0.08) !important;
      }

      .header-search-bottom-row .desktop-search-form:focus-within {
        background: #ffffff !important;
        border-color: #ff1944 !important;
        box-shadow: 0 0 0 3px rgba(255, 25, 68, 0.15) !important;
      }

      .header-search-bottom-row .desktop-search-form .search-icon {
        color: #9ca3af !important;
        font-size: 0.95rem !important;
        margin-right: 10px !important;
        flex-shrink: 0 !important;
      }

      .header-search-bottom-row .desktop-search-form:focus-within .search-icon {
        color: #ff1944 !important;
      }

      .header-search-bottom-row .desktop-search-form input {
        flex: 1 !important;
        border: none !important;
        background: transparent !important;
        outline: none !important;
        font-size: 0.88rem !important;
        color: #111827 !important;
        font-family: inherit !important;
        min-width: 0 !important;
        padding: 6px 0 !important;
        box-shadow: none !important;
      }

      .header-search-bottom-row .desktop-search-form input::placeholder {
        color: #9ca3af !important;
      }

      .header-search-bottom-row .desktop-search-form .search-clear-btn {
        color: #9ca3af !important;
        font-size: 0.95rem !important;
        margin-right: 8px !important;
        display: flex !important;
        align-items: center !important;
        text-decoration: none !important;
      }

      .header-search-bottom-row .desktop-search-form .search-clear-btn:hover {
        color: #4b5563 !important;
      }

      .header-search-bottom-row .desktop-search-form .search-btn {
        background: linear-gradient(135deg, #ff1944 0%, #ea580c 100%) !important;
        color: #ffffff !important;
        border: none !important;
        border-radius: 99px !important;
        padding: 7px 20px !important;
        font-size: 0.82rem !important;
        font-weight: 700 !important;
        letter-spacing: 0.2px !important;
        cursor: pointer !important;
        display: inline-flex !important;
        align-items: center !important;
        gap: 6px !important;
        box-shadow: 0 2px 6px rgba(255, 25, 68, 0.2) !important;
        transition: all 0.2s ease !important;
        white-space: nowrap !important;
        flex-shrink: 0 !important;
        line-height: 1 !important;
      }

      .header-search-bottom-row .desktop-search-form .search-btn:hover {
        background: linear-gradient(135deg, #e5002b 0%, #d97706 100%) !important;
        transform: translateY(-1px) !important;
        box-shadow: 0 4px 10px rgba(255, 25, 68, 0.3) !important;
      }
    }

    /* --- Custom Cart Drawer --- */
    .cart-drawer {
        position: fixed;
        top: 0;
        right: -420px;
        width: 420px;
        height: 100vh;
        height: 100dvh;
        background: #ffffff;
        z-index: 9999;
        box-shadow: -5px 0 25px rgba(0,0,0,0.15);
        transition: right 0.3s cubic-bezier(0.4, 0, 0.2, 1);
        display: flex;
        flex-direction: column;
        font-family: 'Outfit', sans-serif;
     }
     .cart-drawer.open {
         right: 0;
     }
     .cart-backdrop {
         position: fixed;
         top: 0;
         left: 0;
         width: 100vw;
         height: 100vh;
         height: 100dvh;
         background: rgba(0,0,0,0.4);
         backdrop-filter: blur(2px);
         z-index: 9998;
         display: none;
     }
    .cart-backdrop.show {
        display: block;
    }
    .cart-header {
        padding: 1.25rem;
        border-bottom: 1px solid #f3f4f6;
        display: flex;
        justify-content: space-between;
        align-items: center;
        background: #fff;
    }
    .cart-header h3 {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 1.25rem;
        font-weight: 700;
        margin: 0;
        display: flex;
        align-items: center;
        gap: 8px;
        color: #111827;
    }
    .cart-close-btn {
        background: none;
        border: none;
        font-size: 2rem;
        cursor: pointer;
        color: #9ca3af;
        transition: color 0.2s;
        line-height: 1;
    }
    .cart-close-btn:hover {
        color: #dc2626;
    }
    .cart-body {
        flex-grow: 1;
        overflow-y: auto;
        padding: 1.25rem;
        display: flex;
        flex-direction: column;
        gap: 1rem;
        background: #f9fafb;
    }
    .cart-footer {
        padding: 1.25rem;
        border-top: 1px solid #f3f4f6;
        background: #ffffff;
    }

    /* --- Cart Items --- */
    .cart-item {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 10px;
        padding: 0.75rem;
        display: flex;
        gap: 0.75rem;
        position: relative;
    }
    .cart-item-img {
        width: 60px;
        height: 60px;
        object-fit: cover;
        border-radius: 6px;
        background: #fafafa;
    }
    .cart-item-info {
        flex-grow: 1;
        display: flex;
        flex-direction: column;
        justify-content: space-between;
    }
    .cart-item-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #111827;
        margin: 0 1.5rem 0 0;
        line-height: 1.3;
        display: -webkit-box;
        -webkit-line-clamp: 2;
        -webkit-box-orient: vertical;
        overflow: hidden;
    }
    .cart-item-price {
        font-size: 0.9rem;
        font-weight: 700;
        color: #dc2626;
        margin-top: 2px;
        margin-bottom: 4px;
    }
    .cart-item-qty-actions {
        display: flex;
        align-items: center;
        border: 1px solid #d1d5db;
        border-radius: 4px;
        align-self: flex-start;
        background: #fff;
    }
    .cart-item-qty-btn {
        border: none;
        background: none;
        padding: 1px 8px;
        cursor: pointer;
        font-weight: bold;
        font-size: 0.85rem;
    }
    .cart-item-qty-val {
        padding: 1px 8px;
        font-size: 0.85rem;
        font-weight: 700;
        border-left: 1px solid #d1d5db;
        border-right: 1px solid #d1d5db;
        min-width: 20px;
        text-align: center;
    }
    .cart-item-delete {
        position: absolute;
        top: 8px;
        right: 8px;
        color: #9ca3af;
        cursor: pointer;
        font-size: 1.1rem;
        transition: color 0.2s;
    }
    .cart-item-delete:hover {
        color: #dc2626;
    }

    @media (max-width: 450px) {
        .cart-drawer {
            width: 100vw;
            right: -100vw;
        }
    }
    /* --- Mobile Bottom Nav Bar Styles --- */
    .mobile-bottom-nav {
        position: fixed;
        bottom: 0;
        left: 0;
        right: 0;
        height: 62px;
        background-color: #ffffff;
        border-top: 1px solid #e5e7eb;
        display: none;
        justify-content: space-around;
        align-items: center;
        z-index: 1030;
        box-shadow: 0 -2px 10px rgba(0,0,0,0.07);
        padding-bottom: env(safe-area-inset-bottom, 0);
    }
    .bottom-nav-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex: 1;
        height: 100%;
        background: transparent;
        border: none;
        color: #6b7280;
        text-decoration: none !important;
        font-family: 'Outfit', sans-serif;
        font-size: 0.72rem;
        font-weight: 600;
        gap: 3px;
        position: relative;
        padding: 0;
        transition: color 0.15s ease;
    }
    .bottom-nav-item:hover, .bottom-nav-item.active {
        color: #dc2626;
    }
    .bottom-nav-item i {
        font-size: 1.35rem;
    }

    /* --- Center FAB (Shop) Button --- */
    .bottom-nav-fab-wrap {
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        flex: 1;
        position: relative;
    }
    .bottom-nav-fab {
        width: 52px;
        height: 52px;
        background: linear-gradient(135deg, #dc2626 0%, #f97316 100%);
        border-radius: 50%;
        border: 3px solid #fff;
        box-shadow: 0 4px 16px rgba(220, 38, 38, 0.45);
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        color: #fff;
        text-decoration: none !important;
        font-size: 0.6rem;
        font-weight: 700;
        font-family: 'Outfit', sans-serif;
        gap: 1px;
        margin-bottom: 6px;
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        position: relative;
        top: -10px;
    }
    .bottom-nav-fab i {
        font-size: 1.3rem;
    }
    .bottom-nav-fab:hover, .bottom-nav-fab:active {
        transform: scale(1.08);
        box-shadow: 0 6px 20px rgba(220, 38, 38, 0.55);
        color: #fff;
    }
    .bottom-nav-fab.active-fab {
        background: linear-gradient(135deg, #b91c1c 0%, #ea580c 100%);
    }

    @media (max-width: 767.98px) {
        .mobile-bottom-nav {
            display: flex;
        }
        body {
            padding-bottom: calc(72px + env(safe-area-inset-bottom, 0px)) !important;
        }

        header {
            background: rgba(255, 252, 249, 0.94);
        }
        header .container, header.scrolled .container {
            height: 64px;
            padding: 0 14px;
        }
        .header-top-row { gap: .5rem !important; }
        .logo { font-size: 1.1rem; gap: .42rem; }
        .logo img { width: 36px !important; height: 36px !important; min-width: 36px !important; max-width: 36px !important; aspect-ratio: 1 / 1 !important; object-fit: cover !important; border-radius: 50% !important; flex-shrink: 0 !important; }
        .mobile-header-actions { display: flex !important; align-items: center; gap: .4rem; }
        .mobile-header-action {
            width: 38px; height: 38px; border: 1px solid #fed7aa; border-radius: 12px;
            color: #334155; background: #fff; display: inline-flex; align-items: center;
            justify-content: center; position: relative; font-size: 1.15rem;
        }
        .mobile-header-action .badge { font-size: .59rem; }
        .menu-btn { display: none !important; }
        nav {
            top: 64px; height: calc(100dvh - 64px); padding: 1.5rem;
            align-items: stretch; gap: .35rem; background: #fffcf9;
        }
        nav a { padding: .8rem 1rem; border-radius: 12px; background: #fff7ed; font-size: .98rem; }
        .mobile-bottom-nav { height: calc(64px + env(safe-area-inset-bottom, 0px)); padding-bottom: env(safe-area-inset-bottom, 0px); }
        .bottom-nav-item { font-size: .67rem; gap: 2px; }
        .bottom-nav-item i { font-size: 1.22rem; }

        /* Mobile footer: hide quick links & contact us */
        footer .footer-col-links,
        footer .footer-col-contact {
            display: none !important;
        }
        footer .footer-grid {
            grid-template-columns: 1fr !important;
            gap: 1rem !important;
            text-align: center;
        }
        footer .footer-col.brand {
            margin-bottom: 0.5rem;
            display: flex;
            flex-direction: column;
            align-items: center;
        }
        footer .footer-socials {
            justify-content: center;
            margin-top: 0.5rem;
        }
        footer {
            padding: 2rem 0 calc(75px + env(safe-area-inset-bottom, 0px)) !important;
        }
    }

    /* Keep tablet navigation usable as the desktop CTAs are hidden below 992px. */
    @media (min-width: 768px) and (max-width: 991px) {
        .mobile-header-actions { display: flex !important; align-items: center; gap: .5rem; }
        .mobile-header-action {
            width: 42px; height: 42px; border: 1px solid #fed7aa; border-radius: 12px;
            color: #334155; background: #fff; display: inline-flex; align-items: center;
            justify-content: center; position: relative; font-size: 1.2rem;
        }
        .menu-btn { display: none !important; }
    }

    /* Premium Page Loader Styles */
    #pageLoader {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
        background-color: #fffcf9;
        z-index: 99999;
        display: flex;
        flex-direction: column;
        align-items: center;
        justify-content: center;
        transition: opacity 0.25s ease, visibility 0.25s ease;
    }
    #pageLoader.fade-out {
        opacity: 0;
        visibility: hidden;
        pointer-events: none;
    }
    .loader-progress-bar {
        position: absolute;
        top: 0;
        left: 0;
        height: 4px;
        background: linear-gradient(90deg, #dc2626 0%, #f97316 50%, #dc2626 100%);
        background-size: 200% 100%;
        width: 100%;
        animation: progressMove 1.5s infinite linear;
    }
    .loader-content {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 1.5rem;
    }
    .loader-logo-wrap {
        position: relative;
        width: 90px;
        height: 90px;
    }
    .loader-logo {
        width: 80px;
        height: 80px;
        border-radius: 50%;
        position: absolute;
        top: 5px;
        left: 5px;
        z-index: 2;
        animation: logoPulse 2s infinite ease-in-out;
        box-shadow: 0 10px 25px rgba(220, 38, 38, 0.15);
    }
    .loader-ring {
        position: absolute;
        top: 0;
        left: 0;
        width: 90px;
        height: 90px;
        border-radius: 50%;
        border: 3px solid transparent;
        border-top-color: #dc2626;
        border-bottom-color: #f97316;
        animation: spinRing 1.2s cubic-bezier(0.53, 0.21, 0.29, 0.67) infinite;
        z-index: 1;
    }
    .loader-brand {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 1.35rem;
        font-weight: 700;
        color: #111827;
        letter-spacing: 0.5px;
        display: flex;
        align-items: center;
        gap: 3px;
    }
    .loader-brand span {
        color: #dc2626;
    }
    .loader-dots {
        display: inline-flex;
        gap: 4px;
    }
    .loader-dot {
        width: 5px;
        height: 5px;
        background-color: #f97316;
        border-radius: 50%;
        animation: dotPulse 1.4s infinite ease-in-out both;
    }
    .loader-dot:nth-child(2) { animation-delay: 0.2s; }
    .loader-dot:nth-child(3) { animation-delay: 0.4s; }

    @keyframes spinRing {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    @keyframes logoPulse {
        0%, 100% { transform: scale(0.96); opacity: 0.9; }
        50% { transform: scale(1.04); opacity: 1; }
    }
    @keyframes progressMove {
        0% { background-position: 200% 0; }
        100% { background-position: -200% 0; }
    }
    @keyframes dotPulse {
        0%, 80%, 100% { transform: scale(0); opacity: 0.3; }
        40% { transform: scale(1); opacity: 1; }
    }

  </style>
  
  @yield('styles')
</head>
<body>
  <!-- Premium Page Loader -->
  <div id="pageLoader">
      <div class="loader-progress-bar"></div>
      <div class="loader-content">
          <div class="loader-logo-wrap">
              <div class="loader-ring"></div>
              <img src="{{ asset('assets/images/logo.webp') }}" alt="Loku Kade Loading" class="loader-logo" width="72" height="72">
          </div>
          <div class="loader-brand">
              Loku <span>Kade</span>
              <div class="loader-dots">
                  <div class="loader-dot"></div>
                  <div class="loader-dot"></div>
                  <div class="loader-dot"></div>
              </div>
          </div>
      </div>
  </div>

  <!-- --- HEADER & NAVIGATION --- -->
  <header id="mainHeader" class="{{ request()->is('/') ? '' : 'scrolled' }}">
    <div class="container">
      <!-- Row 1: Logo, Navigation links, Call-to-actions -->
      <div class="header-top-row" style="display: flex; width: 100%; justify-content: space-between; align-items: center; gap: 1rem;">
          <a href="{{ route('home') }}" class="logo" id="logoLink" aria-label="Loku Kade Home">
            <img src="{{ asset('assets/images/logo.webp') }}" alt="Loku Kade Logo" width="48" height="48" style="height: 48px; width: 48px; border-radius: 50%; object-fit: cover; aspect-ratio: 1/1;">
            Loku <span>Kade</span>
          </a>

          <nav id="navDrawer">
            <a href="{{ route('home') }}#hero">Home</a>
            <a href="{{ route('home') }}#trackOrder">Track Order</a>
            <a href="{{ route('home') }}#howToOrder">How to Order</a>
            <a href="{{ route('home') }}#popularItems">Popular Items</a>
            <a href="{{ route('home') }}#delivery">Delivery Info</a>
            <a href="{{ route('home') }}#faqs">FAQs</a>
          </nav>

          <div class="header-ctas">
            <a href="{{ route('products.shop') }}" class="btn btn-secondary" id="headerProductsBtn" style="padding: 10px 14px;">
              <i class="bi bi-bag-fill"></i> Shop Now
            </a>
            <button class="btn btn-secondary position-relative" id="headerCartBtn" style="border-radius: 8px; font-weight: 600; padding: 10px 14px; border: 1.5px solid #d1d5db; background: transparent; color: var(--text-dark); transition: var(--transition-smooth);" aria-label="Open Shopping Cart">
              <i class="bi bi-cart3"></i>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartBadgeCount" style="font-size: 0.72rem; display: none;">0</span>
            </button>
            @auth
              <a href="{{ route('profile') }}" class="btn btn-secondary" style="border-radius: 8px; font-weight: 600; padding: 10px 14px; border: 1.5px solid #d1d5db; background: transparent; color: var(--text-dark); display: inline-flex; align-items: center; gap: 6px;">
                <i class="bi bi-person-circle"></i> {{ Auth::user()->first_name }}
              </a>
            @else
              <a href="{{ route('login') }}" class="btn btn-secondary" style="border-radius: 8px; font-weight: 600; padding: 10px 14px; border: 1.5px solid #d1d5db; background: transparent; color: var(--text-dark); display: inline-flex; align-items: center; gap: 6px;">
                <i class="bi bi-box-arrow-in-right"></i> Login
              </a>
            @endauth
            <a href="https://wa.me/94706050500" target="_blank" class="btn btn-whatsapp" id="headerWhatsappBtn">
              <i class="bi bi-whatsapp"></i> Chat Now
            </a>
          </div>

          <div class="mobile-header-actions d-none">
            <button type="button" class="mobile-header-action" id="mobileHeaderCartBtn" aria-label="Open shopping cart">
              <i class="bi bi-bag"></i>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="mobileHeaderCartBadge" style="display: none;">0</span>
            </button>
            <button class="mobile-header-action" id="menuBtn" aria-label="Open menu" aria-expanded="false">
              <i class="bi bi-list"></i>
            </button>
          </div>

      </div>

      <!-- Row 2: Desktop Search Bar (Inside header, directly below links) -->
      <div class="header-search-bottom-row">
        <form action="{{ route('products.shop') }}" method="GET" class="desktop-search-form" role="search">
          <i class="bi bi-search search-icon"></i>
          <input type="text" name="q" value="{{ request('q') }}" placeholder="Search products, electronics, kitchen items in Loku Kade..." aria-label="Search products" autocomplete="off">
          @if(request('q'))
            <a href="{{ route('products.shop') }}" class="search-clear-btn" title="Clear search"><i class="bi bi-x-circle-fill"></i></a>
          @endif
          <button type="submit" class="search-btn">
            <i class="bi bi-search"></i> <span>Search</span>
          </button>
        </form>
      </div>
    </div>
  </header>

  <!-- --- MAIN CONTENT LANDMARK --- -->
  <main id="mainContent">
    @yield('content')
  </main>
  <!-- --- END MAIN CONTENT LANDMARK --- -->

  <!-- --- FOOTER --- -->
  <footer>
    <div class="container footer-grid">
      <div class="footer-col brand">
        <a href="{{ route('home') }}" class="logo" style="margin-bottom: 1.2rem;" aria-label="Loku Kade Home">
          <img src="{{ asset('assets/images/logo.webp') }}" alt="Loku Kade Logo" width="48" height="48" style="height: 48px; width: 48px; border-radius: 50%; object-fit: cover; aspect-ratio: 1/1;">
          Loku <span>Kade</span>
        </a>
        <p>Loku Kade is your trusted online shopping store in Sri Lanka, bringing premium household, kitchen, and electronic items to your door at wholesale prices.</p>
        <div class="footer-socials">
          <a href="https://www.facebook.com/profile.php?id=61569444895967" target="_blank" class="social-icon" aria-label="Facebook"><i class="bi bi-facebook"></i></a>
          <a href="https://www.instagram.com/lokukade" target="_blank" class="social-icon" aria-label="Instagram"><i class="bi bi-instagram"></i></a>
          <a href="https://www.tiktok.com/@loku.kade" target="_blank" class="social-icon" aria-label="TikTok"><i class="bi bi-tiktok"></i></a>
          <a href="https://www.youtube.com/@lokukade" target="_blank" class="social-icon" aria-label="YouTube"><i class="bi bi-youtube"></i></a>
          <a href="https://wa.me/94706050500" target="_blank" class="social-icon" aria-label="WhatsApp"><i class="bi bi-whatsapp"></i></a>
        </div>
      </div>

      <div class="footer-col footer-col-links">
        <h3>Quick Links</h3>
        <ul class="footer-links">
          <li><a href="{{ route('home') }}#hero">Home</a></li>
          <li><a href="{{ route('home') }}#trackOrder">Track Order</a></li>
          <li><a href="{{ route('home') }}#howToOrder">How to Order</a></li>
          <li><a href="{{ route('home') }}#popularItems">Popular Products</a></li>
          <li><a href="{{ route('home') }}#delivery">Shipping Information</a></li>
          <li><a href="{{ route('home') }}#faqs">FAQs</a></li>
        </ul>
      </div>

      <div class="footer-col footer-col-contact">
        <h3>Contact Us</h3>
        <ul class="footer-contact-info">
          <li>
            <i class="bi bi-geo-alt"></i>
            <span>Loku Kade,<br>Polonnaruwa</span>
          </li>
          <li>
            <i class="bi bi-telephone"></i>
            <div>
              <a href="tel:0706050500">070 60 50 500</a>
            </div>
          </li>
          <li>
            <i class="bi bi-whatsapp"></i>
            <a href="https://wa.me/94706050500" target="_blank">Chat on WhatsApp</a>
          </li>
          <li>
            <i class="bi bi-envelope"></i>
            <a href="mailto:info@lokukade.lk">info@lokukade.lk</a>
          </li>
        </ul>
      </div>
    </div>

    <div class="container footer-bottom">
      <p>&copy; 2026 Loku Kade. All Rights Reserved. Developed by <a href="https://velostack.lk" target="_blank" style="color: var(--primary-glow); font-weight: 600;">VeloStack.lk</a></p>
      <p><a href="{{ route('public.terms') }}" style="transition: var(--transition-smooth);">Terms of Service</a> &bull; <a href="{{ route('public.privacy') }}" style="transition: var(--transition-smooth);">Privacy Policy</a></p>
    </div>
  </footer>

  @php
    $courierShippingRate = \Illuminate\Support\Facades\Schema::hasTable('shippings')
        ? (\App\Models\Shipping::where('type', 'Courier')->first()->amount ?? 350.00)
        : 350.00;
  @endphp

  <!-- --- CUSTOM CART DRAWER --- -->
  <div id="cartBackdrop" class="cart-backdrop"></div>
  <div id="cartDrawer" class="cart-drawer">
      <div class="cart-header">
          <h3><i class="bi bi-cart3 text-danger"></i> Shopping Cart</h3>
          <button type="button" class="cart-close-btn" id="cartCloseBtn" aria-label="Close Cart">&times;</button>
      </div>
      <div class="cart-body" id="cartBodyContainer">
          <!-- Items will render dynamically via JS -->
      </div>
      <div class="cart-footer">
          <div id="cartSummaryContainer" style="display: none;">
              <div class="d-flex justify-content-between mb-1 small text-muted">
                  <span>Product Total:</span>
                  <span id="cartProductTotal">Rs. 0.00</span>
              </div>
              <div class="d-flex justify-content-between mb-1 small text-muted">
                  <span>Shipping Cost:</span>
                  <span class="text-success fw-bold">Free (Courier)</span>
              </div>
              <div class="d-flex justify-content-between mb-1 small text-muted d-none" id="cartDiscountRow">
                  <span>Multi-Buy Discount:</span>
                  <span id="cartDiscount" class="text-success fw-bold">-Rs. 0.00</span>
              </div>
              <hr class="my-2">
              <div class="d-flex justify-content-between align-items-center mb-3">
                  <span class="fw-bold">Total Amount to Pay:</span>
                  <strong class="text-danger fs-5" id="cartGrandTotal">Rs. 0.00</strong>
              </div>
          </div>
          
          <div id="cartCheckoutFormContainer" style="display: none;" class="mt-2">
              <a href="{{ url('/checkout') }}" id="cartSubmitBtn" class="btn btn-danger btn-sm w-100 py-2 fw-bold text-decoration-none d-block text-center" style="background: var(--accent-gradient); border: none; border-radius: 8px; color: #fff;">
                  <i class="bi bi-bag-check-fill me-1"></i> Proceed to Checkout
              </a>
          </div>
          
          <div id="cartEmptyMessage" class="text-center py-4 text-muted">
              <i class="bi bi-cart-x fs-1 d-block mb-2 text-muted"></i>
              Your cart is empty.
          </div>
      </div>
  </div>

  <!-- Drawer Menu Script -->
  <script>
    document.addEventListener('DOMContentLoaded', () => {
      const menuBtn = document.getElementById('menuBtn');
      const navDrawer = document.getElementById('navDrawer');
      const menuIcon = menuBtn?.querySelector('i');

      if (menuBtn && navDrawer) {
        menuBtn.addEventListener('click', () => {
          navDrawer.classList.toggle('open');
          menuBtn.setAttribute('aria-expanded', navDrawer.classList.contains('open') ? 'true' : 'false');
          if (menuIcon) {
            if (navDrawer.classList.contains('open')) {
              menuIcon.className = 'bi bi-x-lg';
            } else {
              menuIcon.className = 'bi bi-list';
            }
          }
        });

        navDrawer.querySelectorAll('a').forEach((link) => {
          link.addEventListener('click', () => {
            navDrawer.classList.remove('open');
            menuBtn.setAttribute('aria-expanded', 'false');
            if (menuIcon) menuIcon.className = 'bi bi-list';
          });
        });
      }
    });
  </script>
  
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

  <!-- Global Cart Management Engine -->
  <script>
    $(function() {
        const cartDrawer = $('#cartDrawer');
        const cartBackdrop = $('#cartBackdrop');
        const cartBadgeCount = $('#cartBadgeCount');
        const courierCharge = parseFloat("{{ $courierShippingRate }}");

        // Open cart drawer
        $('#headerCartBtn, #mobileHeaderCartBtn, #mobileBottomCartBtn').on('click', function() {
            cartDrawer.addClass('open');
            cartBackdrop.addClass('show');
            renderCart();
        });

        // Close cart drawer
        $('#cartCloseBtn, #cartBackdrop').on('click', function() {
            cartDrawer.removeClass('open');
            cartBackdrop.removeClass('show');
        });

        // Load cart items from localStorage
        window.getCart = function() {
            try {
                return JSON.parse(localStorage.getItem('lokukade_cart')) || [];
            } catch (e) {
                return [];
            }
        };

        // Save cart items to localStorage
        window.saveCart = function(cart) {
            localStorage.setItem('lokukade_cart', JSON.stringify(cart));
            updateCartBadge();
        };

        // Add item to cart
        window.addToCart = function(product, openDrawer = true) {
            let cart = getCart();
            let maxQty = parseInt(product.max_qty) || 999;
            let addQty = parseInt(product.quantity) || 1;
            let existing = cart.find(item => item.product_id === product.product_id);

            if (existing) {
                let allowedMax = parseInt(existing.max_qty) || maxQty;
                if (existing.quantity + addQty <= allowedMax) {
                    existing.quantity += addQty;
                } else {
                    existing.quantity = allowedMax;
                    Swal.fire({
                        title: 'Stock Limit',
                        text: 'Only ' + allowedMax + ' unit(s) available in stock for this product.',
                        icon: 'warning',
                        confirmButtonColor: '#e12a1a',
                        background: '#fffcf9',
                        color: '#111827'
                    });
                }
            } else {
                let initialQty = Math.min(addQty, maxQty);
                cart.push({
                    product_id: product.product_id,
                    stock_id: product.stock_id,
                    product_name: product.product_name,
                    selling_price: parseFloat(product.selling_price),
                    quantity: initialQty,
                    image: product.image,
                    max_qty: maxQty
                });
            }
            saveCart(cart);
            renderCart();
            
            // Open the drawer to show the product was added
            if (openDrawer) {
                cartDrawer.addClass('open');
                cartBackdrop.addClass('show');
            }
        };

        // Update item quantity
        window.updateQty = function(productId, delta) {
            let cart = getCart();
            let item = cart.find(i => i.product_id === productId);
            if (item) {
                let newQty = item.quantity + delta;
                if (newQty >= 1) {
                    if (newQty <= item.max_qty) {
                        item.quantity = newQty;
                    } else {
                        Swal.fire({
                            title: 'Stock Limit',
                            text: 'Maximum available stock reached.',
                            icon: 'warning',
                            confirmButtonColor: '#e12a1a',
                            background: '#fffcf9',
                            color: '#111827'
                        });
                    }
                }
            }
            saveCart(cart);
            renderCart();
        };

        // Remove item from cart
        window.removeFromCart = function(productId) {
            let cart = getCart();
            cart = cart.filter(item => item.product_id !== productId);
            saveCart(cart);
            renderCart();
        };

        // Update the header cart badge count
        function updateCartBadge() {
            let cart = getCart();
            let totalQty = cart.reduce((sum, item) => sum + item.quantity, 0);
            if (totalQty > 0) {
                cartBadgeCount.text(totalQty).show();
                $('#mobileCartBadgeCount').text(totalQty).show();
                $('#mobileHeaderCartBadge').text(totalQty).show();
            } else {
                cartBadgeCount.hide();
                $('#mobileCartBadgeCount').hide();
                $('#mobileHeaderCartBadge').hide();
            }
        }

        // Render Cart elements dynamically
        function renderCart() {
            let cart = getCart();
            let container = $('#cartBodyContainer');
            container.empty();

            if (cart.length === 0) {
                $('#cartSummaryContainer').hide();
                $('#cartCheckoutFormContainer').hide();
                $('#cartEmptyMessage').show();
                return;
            }

            $('#cartEmptyMessage').hide();
            $('#cartSummaryContainer').show();
            $('#cartCheckoutFormContainer').show();

            let subtotal = 0;
            let totalQty = 0;

            cart.forEach(item => {
                subtotal += item.selling_price * item.quantity;
                totalQty += item.quantity;

                let imageHtml = item.image 
                    ? `<img src="${item.image}" alt="${item.product_name}" class="cart-item-img">`
                    : `<div class="cart-item-img d-flex align-items-center justify-content-center text-secondary bg-light"><i class="bi bi-image"></i></div>`;

                let itemHtml = `
                    <div class="cart-item">
                        ${imageHtml}
                        <div class="cart-item-info">
                            <h4 class="cart-item-title">${item.product_name}</h4>
                            <span class="cart-item-price">Rs. ${item.selling_price.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}</span>
                            <div class="cart-item-qty-actions">
                                <button class="cart-item-qty-btn" onclick="updateQty(${item.product_id}, -1)">-</button>
                                <span class="cart-item-qty-val">${item.quantity}</span>
                                <button class="cart-item-qty-btn" onclick="updateQty(${item.product_id}, 1)">+</button>
                            </div>
                        </div>
                        <i class="bi bi-trash cart-item-delete" onclick="removeFromCart(${item.product_id})"></i>
                    </div>
                `;
                container.append(itemHtml);
            });

            // Summary Math
            $('#cartProductTotal').text('Rs. ' + subtotal.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));

            let discount = 0;
            if (totalQty > 1) {
                discount = courierCharge * (totalQty - 1);
                $('#cartDiscountRow').removeClass('d-none');
                $('#cartDiscount').text('-Rs. ' + discount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            } else {
                $('#cartDiscountRow').addClass('d-none');
            }

            let grandTotal = Math.max(0, subtotal - discount);
            $('#cartGrandTotal').text('Rs. ' + grandTotal.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
        }

        // Global Product Share handler
        $(document).on('click', '.js-share-btn', function(e) {
            e.preventDefault();
            e.stopPropagation();

            const name = $(this).data('name');
            const url = $(this).data('url');

            if (navigator.share) {
                navigator.share({
                    title: name,
                    text: 'Check out this product on Loku Kade: ' + name,
                    url: url
                }).catch(err => console.log('Share canceled or failed:', err));
            } else {
                // Fallback: Copy to clipboard
                const tempInput = document.createElement('input');
                tempInput.value = url;
                document.body.appendChild(tempInput);
                tempInput.select();
                try {
                    document.execCommand('copy');
                    alert('Product link copied to clipboard!');
                } catch (err) {
                    console.error('Copy fallback failed: ', err);
                }
                document.body.removeChild(tempInput);
            }
        });

        // Page transition loading overlay handler
        const hideLoader = () => {
            const loader = document.getElementById('pageLoader');
            if (loader && !loader.classList.contains('fade-out')) {
                loader.classList.add('fade-out');
            }
        };

        // Hide on DOMContentLoaded or window load
        document.addEventListener('DOMContentLoaded', hideLoader);
        window.addEventListener('load', hideLoader);
        if (document.readyState === 'complete' || document.readyState === 'interactive') {
            setTimeout(hideLoader, 300);
        }

        // Failsafe: Force hide loader after 1 second max
        setTimeout(hideLoader, 1000);

        // Show loader on page transition (clicking links)
        document.querySelectorAll('a').forEach(link => {
            const href = link.getAttribute('href');
            if (
                href && 
                !href.startsWith('#') && 
                !href.startsWith('javascript:') && 
                !href.startsWith('tel:') && 
                !href.startsWith('mailto:') &&
                !href.includes('wa.me') &&
                link.getAttribute('target') !== '_blank' &&
                !link.hasAttribute('download')
            ) {
                link.addEventListener('click', (e) => {
                    // Check if it's a left click without modifier keys
                    if (e.button === 0 && !e.ctrlKey && !e.shiftKey && !e.metaKey && !e.altKey) {
                        const loader = document.getElementById('pageLoader');
                        if (loader) {
                            loader.classList.remove('fade-out');
                        }
                    }
                });
            }
        });
        
        // Handle browser back/forward cache (pageshow)
        window.addEventListener('pageshow', (e) => {
            if (e.persisted) {
                const loader = document.getElementById('pageLoader');
                if (loader) {
                    loader.classList.add('fade-out');
                }
            }
        });

        // Initialize Cart Badge count on page load
        updateCartBadge();
    });
  </script>

  <!-- Mobile Bottom Navigation Bar -->
  <div class="mobile-bottom-nav">
      <a href="{{ route('home') }}" class="bottom-nav-item {{ request()->routeIs('home') ? 'active' : '' }}">
          <i class="bi bi-house-door"></i>
          <span>Home</span>
      </a>
      <a href="{{ route('products.flashDeals') }}" class="bottom-nav-item {{ request()->routeIs('products.flashDeals') ? 'active' : '' }}">
          <i class="bi bi-lightning-charge"></i>
          <span>Deals</span>
      </a>

      {{-- Center FAB: Shop --}}
      <div class="bottom-nav-fab-wrap">
          <a href="{{ route('products.shop') }}" class="bottom-nav-fab {{ request()->routeIs('products.shop') ? 'active-fab' : '' }}">
              <i class="bi bi-bag-fill"></i>
              <span style="font-size:0.55rem; letter-spacing:0.5px;">SHOP</span>
          </a>
      </div>

      <button type="button" class="bottom-nav-item" id="mobileBottomCartBtn">
          <i class="bi bi-cart3"></i>
          <span class="badge bg-danger rounded-pill" id="mobileCartBadgeCount" style="position: absolute; top: 6px; right: calc(50% - 22px); font-size: 0.65rem; display: none;">0</span>
          <span>Cart</span>
      </button>
      <a href="{{ Auth::check() ? route('profile') : route('login') }}" class="bottom-nav-item {{ request()->routeIs('profile') || request()->routeIs('login') ? 'active' : '' }}">
          <i class="bi bi-person"></i>
          <span>Account</span>
      </a>
  </div>

  <!-- PWA In-App Install Banner -->
  @include('partials.pwa-install-banner')

  @yield('scripts')
</body>
</html>
