<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <meta name="robots" content="index, follow">
  
  <!-- Primary SEO Meta Tags -->
  <title>Loku Kade - Premium Wholesale & Retail E-Commerce in Sri Lanka</title>
  <meta name="description" content="Explore high-quality household items, electronics, and kitchen accessories at Loku Kade. Order easily via WhatsApp. Fast Cash on Delivery island-wide.">
  <meta name="keywords" content="Loku Kade, online shopping Sri Lanka, cash on delivery, kitchen accessories, electronics, WhatsApp shopping, buy more save more">
  <meta name="author" content="Loku Kade">

  <!-- Open Graph / Facebook / WhatsApp Meta Tags -->
  <meta property="og:type" content="website">
  <meta property="og:url" content="https://lokukade.lk">
  <meta property="og:title" content="Loku Kade - Premium Wholesale & Retail E-Commerce in Sri Lanka">
  <meta property="og:description" content="Explore high-quality household items, electronics, and kitchen accessories. Order easily via WhatsApp. Fast Cash on Delivery island-wide.">
  <meta property="og:image" content="{{ asset('assets/images/logo.jpg') }}">

  <!-- Twitter Meta Tags -->
  <meta name="twitter:card" content="summary_large_image">
  <meta name="twitter:url" content="https://lokukade.lk">
  <meta name="twitter:title" content="Loku Kade - Premium Wholesale & Retail E-Commerce in Sri Lanka">
  <meta name="twitter:description" content="Explore high-quality household items, electronics, and kitchen accessories. Order easily via WhatsApp. Fast Cash on Delivery island-wide.">
  <meta name="twitter:image" content="{{ asset('assets/images/logo.jpg') }}">

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

  <!-- Structured Data (JSON-LD) for LocalBusiness SEO -->
  <script type="application/ld+json">
  {
    "@@context": "https://schema.org",
    "@@type": "Store",
    "name": "Loku Kade",
    "image": "https://lokukade.lk/assets/images/logo.jpg",
    "@@id": "https://lokukade.lk",
    "url": "https://lokukade.lk",
    "telephone": "070 60 50 500",
    "priceRange": "$$",
    "address": {
      "@@type": "PostalAddress",
      "streetAddress": "No 309, Track 05, Jayanthipura",
      "addressLocality": "Polonnaruwa",
      "addressRegion": "North Central Province",
      "postalCode": "51024",
      "addressCountry": "LK"
    },
    "geo": {
      "@@type": "GeoCoordinates",
      "latitude": 7.9399,
      "longitude": 80.9995
    },
    "openingHoursSpecification": {
      "@@type": "OpeningHoursSpecification",
      "dayOfWeek": [
        "Monday",
        "Tuesday",
        "Wednesday",
        "Thursday",
        "Friday",
        "Saturday",
        "Sunday"
      ],
      "opens": "00:00",
      "closes": "23:59"
    },
    "sameAs": [
      "https://www.facebook.com/profile.php?id=61569444895967",
      "https://www.instagram.com/lokukade",
      "https://www.youtube.com/@@lokukade",
      "https://www.tiktok.com/@@loku.kade"
    ]
  }
  </script>

  <!-- Preload Critical LCP Hero Image -->
  <link rel="preload" as="image" href="{{ asset('assets/images/hero_banner.webp') }}" type="image/webp" fetchpriority="high">

  <!-- Google Fonts with display=swap & Preload -->
  <link rel="preconnect" href="https://fonts.googleapis.com">
  <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
  <link rel="preload" as="style" href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Space+Grotesk:wght@500;700&display=swap">
  <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@300;400;600;700&family=Space+Grotesk:wght@500;700&display=swap" rel="stylesheet" media="print" onload="this.media='all'">

  <!-- Bootstrap Icons Asynchronously -->
  <link rel="preload" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css" as="style" onload="this.onload=null;this.rel='stylesheet'">
  <noscript><link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.11.3/font/bootstrap-icons.min.css"></noscript>

  <!-- Custom Stylesheet -->
  <link rel="stylesheet" href="{{ asset('style.css') }}">

  <!-- Custom Cart Drawer Styling -->
  <style>
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
    .category-card {
        transition: transform 0.2s ease, border-color 0.2s ease, box-shadow 0.2s ease !important;
    }
    .category-card:hover {
        transform: translateY(-4px);
        border-color: #f97316 !important;
        box-shadow: 0 10px 15px -3px rgba(249, 115, 22, 0.1), 0 4px 6px -4px rgba(249, 115, 22, 0.1) !important;
    }
    .category-card:hover .category-icon-wrap {
        background: linear-gradient(135deg, #f97316 0%, #ff8c00 100%) !important;
        color: #ffffff !important;
        border-color: #f97316 !important;
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
            padding-bottom: 62px !important;
        }
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
</head>
<body>
  <!-- Premium Page Loader -->
  <div id="pageLoader">
      <div class="loader-progress-bar"></div>
      <div class="loader-content">
          <div class="loader-logo-wrap">
              <div class="loader-ring"></div>
              <img src="{{ asset('assets/images/logo.jpg') }}" alt="Loku Kade Loading" class="loader-logo">
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
  <header id="mainHeader">
    <div class="container">
      <!-- Row 1: Logo, Navigation links, Call-to-actions -->
      <div class="header-top-row" style="display: flex; width: 100%; justify-content: space-between; align-items: center; gap: 1rem;">
          <a href="#" class="logo" id="logoLink">
            <img src="{{ asset('assets/images/logo.webp') }}" alt="Loku Kade Logo" width="48" height="48" style="height: 48px; border-radius: 50%; width: 48px;">
            Loku <span>Kade</span>
          </a>

          <nav id="navDrawer">
            <a href="#hero" id="navHome">Home</a>
            <a href="#trackOrder" id="navTrack">Track Order</a>
            <a href="#howToOrder" id="navSteps">How to Order</a>
            <a href="#popularItems" id="navPopular">Popular Items</a>
            <a href="#delivery" id="navDelivery">Delivery Info</a>
            <a href="#faqs" id="navFaqs">FAQs</a>
          </nav>

          <div class="header-ctas">
            <a href="{{ route('products.shop') }}" class="btn btn-secondary" id="headerCatalogBtn" style="padding: 10px 14px;">
              <i class="bi bi-bag-fill"></i> Shop Now
            </a>
            <button class="btn btn-secondary position-relative" id="headerCartBtn" style="border-radius: 8px; font-weight: 600; padding: 10px 14px; border: 1.5px solid #d1d5db; background: transparent; color: var(--text-dark); transition: var(--transition-smooth);" aria-label="Open Shopping Cart">
              <i class="bi bi-cart3"></i>
              <span class="position-absolute top-0 start-100 translate-middle badge rounded-pill bg-danger" id="cartBadgeCount" style="font-size: 0.72rem; display: none;">0</span>
            </button>
            <a href="https://wa.me/94706050500" target="_blank" class="btn btn-whatsapp" id="headerWhatsappBtn">
              <i class="bi bi-whatsapp"></i> Chat Now
            </a>
          </div>

          <button class="menu-btn" id="menuBtn" aria-label="Toggle Menu">
            <i class="bi bi-list"></i>
          </button>
      </div>

    </div>
  </header>

  <!-- --- HERO SECTION --- -->
  <section class="hero" id="hero">
    <div class="container hero-grid">
      <div class="hero-content reveal active">
        <div class="hero-slogan">
          <i class="bi bi-stars"></i>
          <span>වැඩියෙන් ගන්න වැඩියෙන් ඉතිරිකර ගන්න</span>
        </div>
        <h1 id="heroTitle">Shop the Best Deals, Delivered <span>to Your Door</span></h1>
        <p id="heroDescription">Discover premium quality household accessories, kitchen items, and smart gadgets at unbeatable wholesale rates. Buy more to save more on every single order!</p>
        
        <div class="hero-ctas">
          <a href="{{ route('products.shop') }}" class="btn btn-primary" id="heroCatalogBtn">
            <i class="bi bi-cart3"></i> Shop Now
          </a>
          <a href="https://wa.me/94706050500?text=Hi%20Loku%20Kade,%20I'm%20interested%20in%20shopping%20with%20you!" target="_blank" class="btn btn-whatsapp" id="heroWhatsappBtn">
            <i class="bi bi-whatsapp"></i> Order via WhatsApp
          </a>
        </div>

        <div class="hero-trust-badges">
          <div class="trust-badge">
            <i class="bi bi-truck"></i>
            <div>
              <strong>Free Islandwide Delivery</strong>
              No shipping charges
            </div>
          </div>
          <div class="trust-badge">
            <i class="bi bi-cash-stack"></i>
            <div>
              <strong>Cash on Delivery</strong>
              Inspect then pay
            </div>
          </div>
          <div class="trust-badge">
            <i class="bi bi-shield-check"></i>
            <div>
              <strong>Trusted Quality</strong>
              100% genuine products
            </div>
          </div>
        </div>
      </div>

      <div class="hero-image-wrap reveal active">
        <img src="{{ asset('assets/images/hero_banner.webp') }}" alt="Loku Kade Online Store Showcase" id="heroBannerImg" width="600" height="400" fetchpriority="high" decoding="async">
      </div>
    </div>
  </section>

  <!-- --- TRACK ORDER SECTION --- -->
  <section class="track-order-section" id="trackOrder">
    <div class="container">
      <div class="track-card reveal">
        <div class="track-header text-center">
          <h2><i class="bi bi-box-seam text-danger"></i> Track Your Package</h2>
          <p>Enter your Mobile Number or Order/Tracking Number to check real-time package delivery status.</p>
        </div>
        
        <form class="track-form" id="orderTrackForm">
          <div class="track-input-wrap">
            <i class="bi bi-search search-icon"></i>
            <input type="text" id="trackQueryInput" placeholder="Enter Mobile Number (e.g. 0706050500) or Order ID" required>
          </div>
          <button type="submit" class="btn btn-primary" id="trackSubmitBtn">
            <i class="bi bi-search"></i> Track Order
          </button>
        </form>
        
        <div id="trackResultContainer" class="track-results" style="display: none;"></div>
      </div>
    </div>
  </section>

  <!-- --- HOW TO ORDER --- -->
  <section class="how-it-works" id="howToOrder">
    <div class="container">
      <div class="section-header reveal">
        <span>Simple Process</span>
        <h2>How to Place Your Order</h2>
        <p>Shopping at Loku Kade is simple, quick, and stress-free. Follow these three basic steps to get your products home.</p>
      </div>

      <div class="steps-grid">
        <!-- Step 1 -->
        <article class="step-card reveal" id="step1">
          <span class="step-num">1</span>
          <div class="step-icon-wrap">
            <i class="bi bi-cart-plus"></i>
          </div>
          <h3>Browse & Cart</h3>
          <p>Browse our products, check live stocks, and add your favorite items directly to your shopping cart.</p>
        </article>

        <!-- Step 2 -->
        <article class="step-card reveal" id="step2">
          <span class="step-num">2</span>
          <div class="step-icon-wrap">
            <i class="bi bi-bag-check"></i>
          </div>
          <h3>Place Order</h3>
          <p>Fill in your delivery details at checkout and place your order instantly. No upfront payment required!</p>
        </article>

        <!-- Step 3 -->
        <article class="step-card reveal" id="step3">
          <span class="step-num">3</span>
          <div class="step-icon-wrap">
            <i class="bi bi-house-check"></i>
          </div>
          <h3>Receive & Pay (COD)</h3>
          <p>We deliver island-wide with free shipping. Inspect your package and pay safely in cash upon delivery!</p>
        </article>
      </div>
    </div>
  </section>

  <!-- --- DYNAMIC CATEGORIES GRID --- -->
  @php
    $homeCategories = \App\Models\Category::orderBy('name')->get();
  @endphp
  @if($homeCategories->isNotEmpty())
  <section class="categories-section" id="categoriesSection" style="padding: 4rem 0 2rem; background: #f9fafb; border-bottom: 1px solid #e5e7eb;">
    <div class="container">
      <div class="section-header reveal active" style="margin-bottom: 2rem; text-align: left;">
        <span style="color: var(--primary-glow); font-weight: 700; text-transform: uppercase; letter-spacing: 0.1em; font-size: 0.85rem; display: block; margin-bottom: 0.5rem;">Browse By</span>
        <h2 style="font-family: var(--font-display); font-size: 2rem; font-weight: 700; color: var(--primary-base); margin: 0;">Categories</h2>
      </div>

      <div class="categories-grid" style="display: grid; grid-template-columns: repeat(auto-fill, minmax(130px, 1fr)); gap: 1rem;">
        @foreach($homeCategories as $cat)
          <a href="{{ route('products.shop') }}?category={{ $cat->id }}" class="category-card reveal active" style="background: #ffffff; border: 1px solid #e5e7eb; border-radius: var(--border-radius-md); padding: 1.5rem 1rem; text-align: center; text-decoration: none; color: inherit; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 0.75rem; box-shadow: var(--shadow-sm); cursor: pointer;">
            <div class="category-icon-wrap" style="width: 50px; height: 50px; border-radius: 50%; background: linear-gradient(135deg, #fff5f5 0%, #fffbeb 100%); border: 1px solid #fee2e2; display: flex; align-items: center; justify-content: center; color: #dc2626; font-size: 1.5rem; transition: background 0.2s ease, color 0.2s ease, border-color 0.2s ease;">
              <i class="{{ $cat->icon_class }}"></i>
            </div>
            <span class="category-name" style="font-size: 0.82rem; font-weight: 600; color: #4b5563; line-height: 1.3; display: -webkit-box; -webkit-line-clamp: 2; -webkit-box-orient: vertical; overflow: hidden; height: 2.6em;">{{ $cat->name }}</span>
          </a>
        @endforeach
      </div>
    </div>
  </section>
  @endif

  <!-- --- FEATURED PRODUCTS --- -->
  <section class="featured-showcase" id="popularItems">
    <div class="container">
      <div class="section-header reveal">
        <span>Hot Picks</span>
        <h2>Popular Products</h2>
        <p>These are some of our fastest-moving items. Click the button below to view many more products and real-time stocks.</p>
      </div>

      <div class="products-grid" id="productsGrid">
        <!-- Products will load dynamically via JS -->
      </div>

      <div class="showcase-action reveal">
        <a href="{{ route('products.shop') }}" class="btn btn-secondary btn-lg" id="browseAllBtn">
          <i class="bi bi-arrow-right-circle-fill"></i> Shop Now (100+ Products)
        </a>
      </div>
    </div>
  </section>

  <!-- --- DELIVERY HIGHLIGHT --- -->
  <section class="delivery-feature" id="delivery">
    <div class="container delivery-grid">
      <div class="delivery-img-wrap reveal">
        <img src="{{ asset('assets/images/delivery_mockup.webp') }}" alt="Doorstep Delivery Service Illustration" id="deliveryImg" width="500" height="350" loading="lazy" decoding="async">
      </div>
      <div class="delivery-text reveal">
        <h2>Free & Fast Delivery <br><span>Across Sri Lanka</span></h2>
        <p>We make sure that your shopping experience is completely hassle-free. Enjoy 100% Free Shipping on all orders, securely delivered to your doorstep by our premium logistics partners.</p>
        
        <div class="delivery-benefits">
          <div class="benefit-item">
            <i class="bi bi-gift-fill"></i>
            <div>
              <h4>100% Free Shipping</h4>
              <p>No delivery fees or hidden charges applied to any order.</p>
            </div>
          </div>
          <div class="benefit-item">
            <i class="bi bi-calendar2-check-fill"></i>
            <div>
              <h4>1-3 Days Delivery</h4>
              <p>Quick dispatches directly from our warehouse to any major city.</p>
            </div>
          </div>
          <div class="benefit-item">
            <i class="bi bi-shield-fill-check"></i>
            <div>
              <h4>Safe Inspection</h4>
              <p>Open and verify your package condition before handing over cash.</p>
            </div>
          </div>
          <div class="benefit-item">
            <i class="bi bi-geo-alt-fill"></i>
            <div>
              <h4>Live Order Tracking</h4>
              <p>Track your delivery status anytime using your mobile number or Order ID — right here on this website.</p>
            </div>
          </div>
        </div>

        <a href="https://wa.me/94706050500" target="_blank" class="btn btn-primary" id="deliveryCallBtn">
          <i class="bi bi-telephone-outbound"></i> Delivery Help Desk
        </a>
      </div>
    </div>
  </section>

  <!-- --- CUSTOMER TESTIMONIALS --- -->
  <section class="testimonials" id="testimonials">
    <div class="container">
      <div class="section-header reveal">
        <span>Customer Love</span>
        <h2>What Our Customers Say</h2>
        <p>We pride ourselves on offering the best customer service and quality. Here is what some of our genuine buyers have to say.</p>
      </div>

      <div class="slider-container reveal">
        <button class="slider-btn slider-btn-prev" id="sliderPrev" aria-label="Previous Slide"><i class="bi bi-chevron-left"></i></button>
        <button class="slider-btn slider-btn-next" id="sliderNext" aria-label="Next Slide"><i class="bi bi-chevron-right"></i></button>

        <div class="testimonial-track-wrap">
          <div class="testimonial-track" id="testimonialTrack">
            <!-- Slide 1 -->
            <div class="testimonial-slide">
              <div class="testimonial-card">
                <div class="testimonial-stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p class="testimonial-text">"ගොඩක් හොඳ service එකක්. මම order කරපු thermos එක දවස් දෙකෙන් ගෙදරටම ලැබුණා. packing එකත් ගොඩක් ආරක්ෂිතව කරලා තිබුණා. බොහොම ස්තූතියි Loku Kade!"</p>
                <div class="testimonial-user">
                  <div class="testimonial-user-icon">K</div>
                  <div class="testimonial-user-info">
                    <h5>Kasun Perera</h5>
                    <span>Colombo, Verified Buyer</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- Slide 2 -->
            <div class="testimonial-slide">
              <div class="testimonial-card">
                <div class="testimonial-stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p class="testimonial-text">"Highly recommended! The multi-buy discounts are real. Ordered 3 motion sensor lights and got a great discount. Cash on delivery was seamless."</p>
                <div class="testimonial-user">
                  <div class="testimonial-user-icon">N</div>
                  <div class="testimonial-user-info">
                    <h5>Nilanthi Silva</h5>
                    <span>Kandy, Verified Buyer</span>
                  </div>
                </div>
              </div>
            </div>
            <!-- Slide 3 -->
            <div class="testimonial-slide">
              <div class="testimonial-card">
                <div class="testimonial-stars">
                  <i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i><i class="bi bi-star-fill"></i>
                </div>
                <p class="testimonial-text">"WhatsApp එකෙන් order කරන්න තියෙන එක ලේසියි. Item එක ආවම බලලා තමයි සල්ලි දුන්නේ. Quality එකත් සුපිරි. ආයෙත් අනිවාර්යයෙන්ම ගන්නවා."</p>
                <div class="testimonial-user">
                  <div class="testimonial-user-icon">S</div>
                  <div class="testimonial-user-info">
                    <h5>Suresh Kumar</h5>
                    <span>Jaffna, Verified Buyer</span>
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>

        <div class="slider-dots" id="sliderDots"></div>
      </div>
    </div>
  </section>

  <!-- --- FAQS --- -->
  <section class="faqs" id="faqs">
    <div class="container">
      <div class="section-header reveal">
        <span>Got Questions?</span>
        <h2>Frequently Asked Questions</h2>
        <p>Here are answers to the most common queries from our buyers. If you have any other questions, feel free to chat with us on WhatsApp.</p>
      </div>

      <div class="faq-container reveal">
        <!-- FAQ 1 -->
        <article class="faq-item" id="faq1">
          <div class="faq-header">
            <h3>How do I place an order?</h3>
            <span class="faq-icon"><i class="bi bi-plus-lg"></i></span>
          </div>
          <div class="faq-body">
            <p>You can click on "Browse Products" to view our items. If you like something, click "Buy Now" to view its detail page, where you can securely complete your purchase using our on-site Cash on Delivery (COD) form.</p>
          </div>
        </article>

        <!-- FAQ 2 -->
        <article class="faq-item" id="faq2">
          <div class="faq-header">
            <h3>How long does delivery take?</h3>
            <span class="faq-icon"><i class="bi bi-plus-lg"></i></span>
          </div>
          <div class="faq-body">
            <p>Standard delivery takes between 1 to 3 business days depending on your location. Orders in Polonnaruwa and surrounding areas are usually delivered within 24 to 48 hours.</p>
          </div>
        </article>

        <!-- FAQ 3 -->
        <article class="faq-item" id="faq3">
          <div class="faq-header">
            <h3>Is cash on delivery (COD) available?</h3>
            <span class="faq-icon"><i class="bi bi-plus-lg"></i></span>
          </div>
          <div class="faq-body">
            <p>Yes, we offer Cash on Delivery (COD) island-wide. You can check your package status and inspect the item before handing over the cash payment to the delivery rider.</p>
          </div>
        </article>

        <!-- FAQ 4 -->
        <article class="faq-item" id="faq4">
          <div class="faq-header">
            <h3>What is the shipping cost?</h3>
            <span class="faq-icon"><i class="bi bi-plus-lg"></i></span>
          </div>
          <div class="faq-body">
            <p>Shipping is 100% FREE! We do not charge anything for delivery island-wide, regardless of your order size or weight. The price you see on the product is the only price you pay.</p>
          </div>
        </article>

        <!-- FAQ 5 -->
        <article class="faq-item" id="faq5">
          <div class="faq-header">
            <h3>Can I return or exchange an item?</h3>
            <span class="faq-icon"><i class="bi bi-plus-lg"></i></span>
          </div>
          <div class="faq-body">
            <p>Yes, if there is a manufacturing defect or the item was damaged during shipping, we offer a hassle-free 7-day exchange program. Simply contact our support team on WhatsApp at 070 60 50 500 with photos of the issue, and we will assist you.</p>
          </div>
        </article>
      </div>
    </div>
  </section>

  <!-- --- FOOTER --- -->
  <footer>
    <div class="container footer-grid">
      <div class="footer-col brand">
        <a href="#" class="logo" style="margin-bottom: 1.2rem;">
          <img src="{{ asset('assets/images/logo.jpg') }}" alt="Loku Kade Logo" style="height: 48px; border-radius: 50%; width: auto;">
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

      <div class="footer-col">
        <h3>Quick Links</h3>
        <ul class="footer-links">
          <li><a href="#hero">Home</a></li>
          <li><a href="#trackOrder">Track Order</a></li>
          <li><a href="#howToOrder">How to Order</a></li>
          <li><a href="#popularItems">Popular Products</a></li>
          <li><a href="#delivery">Shipping Information</a></li>
          <li><a href="#faqs">FAQs</a></li>
        </ul>
      </div>

      <div class="footer-col">
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

  <!-- Custom Scripts -->
  <script src="https://code.jquery.com/jquery-3.7.1.min.js"></script>
  <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>

  <!-- Global Cart Management Engine -->
  <script>
    $(function() {
        const cartDrawer = $('#cartDrawer');
        const cartBackdrop = $('#cartBackdrop');
        const cartBadgeCount = $('#cartBadgeCount');
        const courierCharge = parseFloat("{{ $courierShippingRate }}");

        // Open cart drawer
        $('#headerCartBtn, #mobileBottomCartBtn').on('click', function() {
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
            let existing = cart.find(item => item.product_id === product.product_id);
            if (existing) {
                if (existing.quantity < product.max_qty) {
                    existing.quantity += product.quantity || 1;
                } else {
                    alert('Maximum available stock reached for this product.');
                }
            } else {
                cart.push({
                    product_id: product.product_id,
                    stock_id: product.stock_id,
                    product_name: product.product_name,
                    selling_price: parseFloat(product.selling_price),
                    quantity: product.quantity || 1,
                    image: product.image,
                    max_qty: product.max_qty
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
                        alert('Maximum available stock reached.');
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
            } else {
                cartBadgeCount.hide();
                $('#mobileCartBadgeCount').hide();
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

  <script src="{{ asset('main.js') }}"></script>
</body>
</html>
