@extends('layouts.frontend')

@section('title', 'Shop Online | Loku Kade – Premium Household & Electronics Sri Lanka')

@section('styles')
    <style>
        :root {
            --bg-base: transparent;
            --neutral-card: #fffcf9;
            --text-dark: #111827;
            --text-secondary: #4b5563;
            --text-muted: #9ca3af;
            
            --accent: #dc2626;
            --accent-gradient: linear-gradient(135deg, #dc2626 0%, #f97316 100%);
            --accent-light: #fef2f2;
            --accent-dark: #991b1b;
            
            --success-color: #10b981;
            --success-light: #ecfdf5;
            --success-dark: #065f46;
            
            --shadow-sm: 0 1px 2px 0 rgba(0, 0, 0, 0.05);
            --shadow-md: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
            --shadow-hover: 0 20px 25px -5px rgba(0, 0, 0, 0.08), 0 10px 10px -5px rgba(0, 0, 0, 0.03);
            
            --radius-md: 12px;
            --radius-lg: 16px;
            
            --transition-smooth: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background-color: var(--bg-base);
            font-family: 'Outfit', sans-serif;
            color: var(--text-dark);
        }

        /* --- Header Offset --- */
        .shop-page-wrapper {
            margin-top: 110px;
            padding-bottom: 5rem;
        }

        /* --- Shop Page Header --- */
        .shop-title-area {
            text-align: center;
            margin-bottom: 2.5rem;
            padding: 3rem 1.5rem;
            background: linear-gradient(135deg, #fffbeb 0%, #fff5f5 100%);
            border: 1px solid #fee2e2;
            border-radius: var(--radius-lg);
        }

        .shop-title-area h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2.4rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .shop-title-area p {
            color: var(--text-secondary);
            font-size: 1.05rem;
            max-width: 650px;
            margin: 0 auto;
            line-height: 1.6;
        }

        /* --- Toolbar & Filters --- */
        .toolbar-wrapper {
            background: var(--neutral-card);
            border: 1px solid #e5e7eb;
            border-radius: var(--radius-md);
            box-shadow: var(--shadow-sm);
            padding: 1rem 1.25rem;
            margin-bottom: 2rem;
        }

        .search-wrapper {
            position: relative;
        }

        .search-wrapper i {
            position: absolute;
            left: 16px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--text-muted);
            font-size: 1.1rem;
        }

        .search-input {
            width: 100%;
            padding: 10px 16px 10px 46px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            background: #ffffff;
            font-size: 0.95rem;
            transition: var(--transition-smooth);
        }

        .search-input:focus {
            outline: none;
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.08);
        }

        .filter-select {
            padding: 10px 16px;
            border: 1.5px solid #e5e7eb;
            border-radius: 8px;
            background: #ffffff;
            font-size: 0.95rem;
            cursor: pointer;
            width: 100%;
            transition: var(--transition-smooth);
        }

        .filter-select:focus {
            outline: none;
            border-color: var(--accent);
        }

        /* --- Product Grid & Cards --- */
        .products-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(260px, 1fr));
            gap: 2rem;
        }

        .product-card {
            background: var(--neutral-card);
            border: 1px solid #e5e7eb;
            border-radius: var(--radius-lg);
            overflow: hidden;
            box-shadow: var(--shadow-sm);
            transition: var(--transition-smooth);
            display: flex;
            flex-direction: column;
            position: relative;
            cursor: pointer;
        }

        .product-card:hover {
            transform: translateY(-6px);
            box-shadow: var(--shadow-hover);
            border-color: rgba(220, 38, 38, 0.2);
        }

        .product-media {
            position: relative;
            aspect-ratio: 1 / 1;
            overflow: hidden;
            background: #fafafa;
            border-bottom: 1px solid #f3f4f6;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .product-thumb {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: transform 0.3s ease;
        }

        .product-card:hover .product-thumb {
            transform: scale(1.03);
        }

        .discount-tag {
            position: absolute;
            top: 12px;
            right: 12px;
            background: var(--accent);
            color: #ffffff;
            font-size: 0.75rem;
            font-weight: 700;
            padding: 4px 10px;
            border-radius: 99px;
            z-index: 2;
            box-shadow: 0 4px 6px rgba(220, 38, 38, 0.15);
        }

        .product-body {
            padding: 1.25rem;
            display: flex;
            flex-direction: column;
            flex-grow: 1;
        }

        .product-title {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.5rem;
            line-height: 1.4;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 3rem;
        }

        .product-short-desc {
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 1rem;
            line-height: 1.5;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.5rem;
        }

        .product-price-section {
            display: flex;
            align-items: center;
            gap: 0.5rem;
            margin-bottom: 0.75rem;
            flex-wrap: wrap;
        }

        .sale-price {
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--accent);
        }

        .regular-price {
            font-size: 0.9rem;
            color: var(--text-muted);
            text-decoration: line-through;
        }

        .savings-tag {
            font-size: 0.72rem;
            color: var(--success-dark);
            background: var(--success-light);
            padding: 2px 6px;
            border-radius: 4px;
            font-weight: 600;
            width: 100%;
        }

        .product-status-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            font-size: 0.78rem;
            margin-top: auto;
            padding-top: 0.75rem;
            border-top: 1px solid #f3f4f6;
        }

        .stock-badge-green {
            background: var(--success-light);
            color: var(--success-dark);
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .stock-badge-red {
            background: var(--accent-light);
            color: var(--accent-dark);
            padding: 3px 8px;
            border-radius: 6px;
            font-weight: 600;
            display: inline-flex;
            align-items: center;
            gap: 4px;
        }

        .order-btn {
            background: var(--accent-gradient);
            border: none;
            color: #ffffff;
            font-weight: 600;
            font-size: 0.85rem;
            padding: 10px;
            border-radius: 8px;
            width: 100%;
            transition: opacity 0.2s ease;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 6px;
            margin-top: 0.75rem;
        }

        .order-btn:hover {
            opacity: 0.95;
            color: #ffffff;
        }

        /* --- Empty State --- */
        .empty-results {
            text-align: center;
            padding: 5rem 2rem;
            background: #ffffff;
            border: 1px solid #e5e7eb;
            border-radius: var(--radius-lg);
            color: var(--text-secondary);
        }

        /* --- Pagination --- */
        .pagination-container {
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 0.35rem;
            margin-top: 3.5rem;
            flex-wrap: wrap;
        }

        .pagination-container a, 
        .pagination-container span {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            padding: 8px 14px;
            min-width: 38px;
            height: 38px;
            background: #ffffff;
            border: 1.5px solid #e5e7eb;
            border-radius: 10px;
            color: #374151;
            font-weight: 600;
            font-size: 0.88rem;
            text-decoration: none;
            transition: all 0.2s ease;
            user-select: none;
        }

        .pagination-container a:hover {
            border-color: #dc2626;
            color: #dc2626;
            background: #fff5f5;
            transform: translateY(-1px);
        }

        .pagination-container .page-num.active {
            background: linear-gradient(135deg, #dc2626 0%, #ef4444 100%) !important;
            border-color: #dc2626 !important;
            color: #ffffff !important;
            font-weight: 700;
            box-shadow: 0 4px 10px rgba(220, 38, 38, 0.25);
        }

        .pagination-container .page-nav.disabled {
            background: #f8fafc;
            border-color: #f1f5f9;
            color: #94a3b8;
            cursor: not-allowed;
            opacity: 0.7;
        }

        .pagination-container .page-dots {
            background: transparent;
            border: none;
            color: #94a3b8;
            padding: 0 4px;
            min-width: auto;
        }

        /* --- Category Sidebar --- */
        .sidebar-card ul li a:hover {
            background: #f9fafb;
            color: #dc2626 !important;
        }
        .sidebar-card ul li a i {
            font-size: 1.05rem;
            color: #4b5563;
            transition: var(--transition-smooth);
        }
        .sidebar-card ul li a:hover i {
            color: #dc2626;
        }
        /* --- Carousels Section --- */
        .carousel-section {
            background: #fff;
            border: 1px solid #e5e7eb;
            border-radius: var(--radius-lg);
            padding: 1.5rem;
            margin-bottom: 2.5rem;
            box-shadow: var(--shadow-sm);
        }
        .carousel-header {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 1.25rem;
        }
        .carousel-header h2 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 1.4rem;
            font-weight: 800;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            gap: 8px;
        }
        .carousel-header .shop-more-btn {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 0.9rem;
            font-weight: 700;
            color: #dc2626;
            text-decoration: none;
            display: flex;
            align-items: center;
            gap: 4px;
            transition: var(--transition-smooth);
        }
        .carousel-header .shop-more-btn:hover {
            color: #b91c1c;
            transform: translateX(3px);
        }
        .carousel-container {
            position: relative;
        }
        .carousel-scroll {
            display: flex;
            overflow-x: auto;
            gap: 1.25rem;
            padding: 0.25rem 0.25rem 1rem;
            scroll-behavior: smooth;
            -webkit-overflow-scrolling: touch;
            scrollbar-width: thin;
        }
        .carousel-scroll::-webkit-scrollbar {
            height: 6px;
        }
        .carousel-scroll::-webkit-scrollbar-track {
            background: #f3f4f6;
            border-radius: 10px;
        }
        .carousel-scroll::-webkit-scrollbar-thumb {
            background: #d1d5db;
            border-radius: 10px;
        }
        .carousel-item-card {
            flex: 0 0 220px;
            scroll-snap-align: start;
            cursor: pointer;
        }
        .carousel-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #fff;
            border: 1px solid #e5e7eb;
            color: var(--text-dark);
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.2rem;
            box-shadow: var(--shadow-sm);
            cursor: pointer;
            z-index: 10;
            transition: var(--transition-smooth);
            opacity: 0.9;
        }
        .carousel-nav-btn:hover {
            background: #f9fafb;
            color: #dc2626;
            box-shadow: var(--shadow-md);
        }
        .carousel-nav-btn.prev-btn {
            left: -15px;
        }
        .carousel-nav-btn.next-btn {
            right: -15px;
        }
        @media (max-width: 768px) {
            .carousel-nav-btn {
                display: none;
            }
        }

        /* ========================================
           MOBILE APP-STYLE OVERRIDES (≤767px)
        ======================================== */
        @media (max-width: 767.98px) {

            /* --- Page offset --- */
            .shop-page-wrapper {
                margin-top: 100px !important;
                padding-bottom: 1rem;
            }

            /* --- Hide desktop elements on mobile --- */
            .shop-title-area { display: none !important; }
            .toolbar-wrapper { display: none !important; }

            /* --- Slim banner --- */
            .shop-banner-img {
                height: 112px !important;
                object-fit: cover;
                border-radius: 14px !important;
            }
            .shop-banner-container { margin-bottom: 0.75rem !important; }

            /* --- Flash Sale / Trending carousel section --- */
            .carousel-section {
                background: #fff !important;
                border: none !important;
                box-shadow: none !important;
                padding: 0.75rem 0 !important;
                margin-bottom: 0.5rem !important;
                border-radius: 0 !important;
            }
            .carousel-header {
                padding: 0 0.25rem;
                margin-bottom: 0.6rem !important;
            }
            .carousel-header h2 {
                font-size: 1rem !important;
                font-weight: 800 !important;
            }
            .carousel-header .shop-more-btn {
                font-size: 0.78rem !important;
            }
            .carousel-item-card {
                flex: 0 0 148px !important;
            }
            .carousel-scroll {
                gap: 0.65rem !important;
                padding: 0.2rem 0.1rem 0.5rem !important;
                scrollbar-width: none !important;
            }
            .carousel-scroll::-webkit-scrollbar { display: none !important; }

            /* --- 2-column product grid --- */
            .products-grid {
                grid-template-columns: repeat(2, 1fr) !important;
                gap: 0.65rem !important;
            }

            /* --- Tighter product card on mobile --- */
            .product-body {
                padding: 0.65rem !important;
            }
            .product-title {
                font-size: 0.82rem !important;
                height: 2.4rem !important;
                margin-bottom: 0.3rem !important;
            }
            .sale-price {
                font-size: 1rem !important;
            }
            .regular-price {
                font-size: 0.75rem !important;
            }
            .savings-tag {
                font-size: 0.66rem !important;
            }
            .product-status-row {
                padding-top: 0.5rem !important;
                font-size: 0.7rem !important;
            }
            .product-price-section {
                margin-bottom: 0.4rem !important;
            }

            /* --- Remove container horizontal padding to maximise card width --- */
            .shop-page-wrapper > .container {
                padding-left: 12px !important;
                padding-right: 12px !important;
            }

            /* --- Divider between sections --- */
            .mobile-section-divider {
                height: 8px;
                background: #f3f4f6;
                margin: 0.5rem -12px;
            }

            /* --- Category chips row --- */
            .mobile-cat-chips-row {
                display: flex !important;
                overflow-x: auto;
                gap: 8px;
                padding: 8px 2px 10px;
                scrollbar-width: none;
                -webkit-overflow-scrolling: touch;
            }
            .mobile-cat-chips-row::-webkit-scrollbar { display: none; }
            .mobile-cat-chip {
                display: inline-flex;
                align-items: center;
                gap: 5px;
                padding: 6px 14px;
                border-radius: 20px;
                font-size: 0.76rem;
                font-weight: 600;
                white-space: nowrap;
                text-decoration: none;
                font-family: 'Outfit', sans-serif;
                background: #f3f4f6;
                color: #374151;
                border: 1.5px solid transparent;
                transition: all 0.15s ease;
            }
            .mobile-cat-chip.active,
            .mobile-cat-chip:hover {
                background: #fef2f2;
                color: #dc2626;
                border-color: #dc2626;
            }
            .mobile-cat-chip i {
                font-size: 0.8rem;
            }

            .mobile-search-wrap {
                position: sticky;
                top: 64px;
                z-index: 20;
                padding: 8px 0 6px;
                background: #fff7ed;
            }
            .mobile-search-wrap input {
                min-height: 44px;
                border-radius: 14px !important;
                box-shadow: 0 4px 14px rgba(15, 23, 42, .06);
            }
            .mobile-results-bar {
                min-height: 44px;
                padding: 6px 0 !important;
                border-top: 1px solid #f3f4f6;
                border-bottom: 1px solid #f3f4f6;
                margin-bottom: .75rem !important;
            }
            .mobile-results-bar select {
                min-height: 34px;
                border-radius: 10px !important;
                padding: 5px 9px !important;
            }
            .product-card { border-radius: 12px !important; }
            .product-card-footer { padding-top: 8px !important; }

            /* --- Pagination compact --- */
            .pagination-container {
                gap: 0.25rem !important;
                margin-top: 2rem !important;
            }
            .pagination-container a,
            .pagination-container span {
                padding: 6px 10px !important;
                min-width: 32px !important;
                height: 32px !important;
                font-size: 0.8rem !important;
                border-radius: 8px !important;
            }
        }
    </style>
@endsection

@section('content')
<div class="shop-page-wrapper">
    <div class="container">
        
        <!-- Shop Title Banner -->
        <div class="shop-banner-container mb-4">
            <style>
                .shop-banner-img {
                    width: 100%;
                    height: auto;
                    max-height: 280px;
                    object-fit: cover;
                    object-position: center;
                    box-shadow: var(--shadow-sm);
                    border: 1px solid #e5e7eb;
                }
                @media (max-width: 767.98px) {
                    .shop-banner-img {
                        height: auto !important;
                    }
                }
            </style>
            <img src="{{ asset('assets/images/shop_banner.webp') }}" alt="Loku Kade Banner" class="shop-banner-img rounded">
        </div>

        {{-- ========== MOBILE-ONLY: Category Chips + Search ========== --}}
        <div class="d-lg-none">
            {{-- Mobile Search Bar --}}
            <div class="mobile-search-wrap" style="margin-bottom: 0.6rem;">
                <form method="GET" action="{{ route('products.shop') }}" style="display:flex; gap:8px;">
                    <div style="position:relative; flex:1;">
                        <i class="bi bi-search" style="position:absolute; left:12px; top:50%; transform:translateY(-50%); color:#9ca3af; font-size:0.9rem;"></i>
                        <input type="text" name="q" value="{{ $search }}"
                               placeholder="Search products..."
                               style="width:100%; padding:9px 12px 9px 36px; border:1.5px solid #e5e7eb; border-radius:22px; font-size:0.85rem; font-family:'Outfit',sans-serif; outline:none; background:#fff;">
                        @if($selectedCategory)
                            <input type="hidden" name="category" value="{{ $selectedCategory }}">
                        @endif
                        <input type="hidden" name="sort" value="{{ $sort }}">
                    </div>
                    @if($search)
                        <a href="{{ route('products.shop') }}?category={{ $selectedCategory }}&sort={{ $sort }}"
                           style="padding:9px 12px; border-radius:22px; background:#f3f4f6; color:#374151; font-size:0.8rem; font-weight:600; text-decoration:none; display:flex; align-items:center; white-space:nowrap;">
                            Clear
                        </a>
                    @endif
                </form>
            </div>

            {{-- Mobile Category Chips --}}
            <div class="mobile-cat-chips-row">
                <a href="{{ route('products.shop') }}?q={{ urlencode($search) }}&sort={{ $sort }}"
                   class="mobile-cat-chip {{ empty($selectedCategory) ? 'active' : '' }}">
                    <i class="bi bi-grid-3x3-gap-fill"></i> All
                </a>
                @foreach($categories as $cat)
                    <a href="{{ route('products.shop') }}?category={{ $cat->id }}&q={{ urlencode($search) }}&sort={{ $sort }}"
                       class="mobile-cat-chip {{ (string)$selectedCategory === (string)$cat->id ? 'active' : '' }}">
                        <i class="{{ $cat->icon_class }}"></i> {{ $cat->name }}
                    </a>
                @endforeach
            </div>
        </div>

        @if($search === '' && $selectedCategory === '' && $products->currentPage() === 1)
            <!-- Flash Deals Section -->
            @if($topFlashDeals->isNotEmpty())
                <div class="carousel-section">
                    <div class="carousel-header">
                        <h2><i class="bi bi-lightning-charge-fill text-warning"></i> Flash Sale</h2>
                        <a href="{{ route('products.flashDeals') }}" class="shop-more-btn">Shop More <i class="bi bi-chevron-right"></i></a>
                    </div>
                    <div class="carousel-container">
                        <button class="carousel-nav-btn prev-btn" onclick="slideCarousel('flashSaleScroll', -1)"><i class="bi bi-chevron-left"></i></button>
                        <div id="flashSaleScroll" class="carousel-scroll">
                            @foreach($topFlashDeals as $p)
                                @php
                                    $img = $p['main_image_url'] ?? ($p['images'][0] ?? null);
                                    $inStock = ($p['total_quantity'] ?? 0) > 0;
                                    $avg = (float) ($p['avg_rating'] ?? 0);
                                    $count = (int) ($p['reviews_count'] ?? 0);
                                @endphp
                                <div class="carousel-item-card product-card js-card" data-id="{{ $p['id'] }}">
                                    <div class="product-media">
                                        <span class="discount-tag" style="background: #ef4444;">-{{ $p['discount_percentage'] }}% Off</span>
                                        @if($img)
                                            <img src="{{ $img }}" alt="{{ $p['product_name'] }}" class="product-thumb" loading="lazy">
                                        @else
                                            <div class="text-secondary"><i class="bi bi-image fs-1"></i></div>
                                        @endif
                                    </div>
                                    <div class="product-body" style="padding: 12px;">
                                        <h3 class="product-title" style="font-size: 0.88rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 6px;">{{ $p['product_name'] }}</h3>
                                        <div class="product-price-section mb-2" style="display: flex; align-items: baseline; gap: 6px; flex-wrap: wrap;">
                                            <span class="sale-price" style="font-size: 0.95rem; color: #ef4444; font-weight: 700;">Rs. {{ number_format($p['discounted_price'], 0) }}</span>
                                            <span class="regular-price text-decoration-line-through text-muted" style="font-size: 0.78rem;">Rs. {{ number_format($p['price'], 0) }}</span>
                                        </div>
                                        
                                        <div class="product-rating-wrap mt-1 mb-2" style="font-size: 0.72rem; color: #6b7280; font-family:'Outfit',sans-serif;">
                                            @if(($p['sales_volume'] ?? 0) > 0)
                                                <div class="sold-row" style="margin-bottom: 3px;">
                                                    <span class="text-secondary fw-bold" style="background: #f3f4f6; padding: 1px 4px; border-radius: 3px; font-size: 0.68rem;">{{ $p['sales_volume'] }} sold</span>
                                                </div>
                                            @endif
                                            @if($count > 0)
                                                <div class="d-flex align-items-center gap-1" style="line-height: 1;">
                                                    <span class="fw-bold" style="color:#111827;">{{ number_format($avg, 1) }}</span>
                                                    <span style="display:inline-flex; align-items:center; gap:1px;">
                                                        @for($si = 1; $si <= 5; $si++)
                                                            @if($si <= floor($avg))
                                                                <i class="bi bi-star-fill" style="font-size:0.65rem; color:#f59e0b;"></i>
                                                            @elseif(($si - $avg) <= 0.5)
                                                                <i class="bi bi-star-half" style="font-size:0.65rem; color:#f59e0b;"></i>
                                                            @else
                                                                <i class="bi bi-star" style="font-size:0.65rem; color:#d1d5db;"></i>
                                                            @endif
                                                        @endfor
                                                    </span>
                                                    <span>({{ $count }})</span>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center gap-1 text-muted" style="line-height: 1;">
                                                    <span style="display:inline-flex; align-items:center; gap:1px;">
                                                        @for($si = 1; $si <= 5; $si++)
                                                            <i class="bi bi-star" style="font-size:0.65rem; color:#d1d5db;"></i>
                                                        @endfor
                                                    </span>
                                                    <span>(0)</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="product-card-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 8px; border-top: 1px solid #f3f4f6;">
                                            <div class="product-status-badge">
                                                @if($inStock)
                                                    <span class="stock-badge-green" style="font-size: 0.68rem; padding: 2px 5px; font-weight: 600; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                                                        <i class="bi bi-check-circle-fill" style="color: #10b981; font-size: 0.65rem;"></i> In Stock
                                                    </span>
                                                @else
                                                    <span class="stock-badge-red" style="font-size: 0.68rem; padding: 2px 5px; font-weight: 600; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                                                        <i class="bi bi-x-circle-fill" style="color: #ef4444; font-size: 0.65rem;"></i> Out of Stock
                                                    </span>
                                                @endif
                                            </div>
                                            <div style="display: flex; gap: 5px; align-items: center;">
                                                @if($inStock)
                                                    <button type="button" class="js-add-to-cart-btn circle-action-btn" 
                                                            style="width: 28px; height: 28px; border-radius: 50%; border: none; background: #374151; color: #fff; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; padding: 0 !important; line-height: 1 !important;"
                                                            data-id="{{ $p['id'] }}"
                                                            data-stock-id="{{ $p['best_stock_id'] ?? '' }}"
                                                            data-name="{{ $p['product_name'] }}"
                                                            data-price="{{ $p['discounted_price'] ?? $p['price'] }}"
                                                            data-image="{{ $img }}"
                                                            data-max-qty="{{ $p['total_quantity'] ?? 999 }}"
                                                            data-tooltip="Add to Cart">
                                                        <i class="bi bi-cart-plus" style="font-size: 0.85rem;"></i>
                                                    </button>
                                                @endif
                                                <a href="https://wa.me/94706050500?text={{ urlencode('Hi, I\'m interested in buying: ' . $p['product_name'] . ' (ID: ' . $p['id'] . ')') }}" 
                                                   target="_blank" class="circle-action-btn" 
                                                   style="width: 28px; height: 28px; border-radius: 50%; background-color: #25d366; color: #fff; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; cursor: pointer;"
                                                   data-tooltip="WhatsApp Order">
                                                    <i class="bi bi-whatsapp" style="font-size: 0.85rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                        </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-nav-btn next-btn" onclick="slideCarousel('flashSaleScroll', 1)"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
            @endif

            <!-- Trending Section -->
            @if($topTrending->isNotEmpty())
                <div class="carousel-section">
                    <div class="carousel-header">
                        <h2><i class="bi bi-graph-up-arrow text-danger"></i> Trending Products</h2>
                        <a href="{{ route('products.trending') }}" class="shop-more-btn">Show All <i class="bi bi-chevron-right"></i></a>
                    </div>
                    <div class="carousel-container">
                        <button class="carousel-nav-btn prev-btn" onclick="slideCarousel('trendingScroll', -1)"><i class="bi bi-chevron-left"></i></button>
                        <div id="trendingScroll" class="carousel-scroll">
                            @foreach($topTrending as $p)
                                @php
                                    $img = $p['main_image_url'] ?? ($p['images'][0] ?? null);
                                    $isDiscounted = !empty($p['has_discount']) && $p['discount_percentage'] > 0;
                                    $inStock = ($p['total_quantity'] ?? 0) > 0;
                                    $avg = (float) ($p['avg_rating'] ?? 0);
                                    $count = (int) ($p['reviews_count'] ?? 0);
                                @endphp
                                <div class="carousel-item-card product-card js-card" data-id="{{ $p['id'] }}">
                                    <div class="product-media">
                                        @if($isDiscounted)
                                            <span class="discount-tag" style="background: #ef4444;">-{{ $p['discount_percentage'] }}% Off</span>
                                        @endif
                                        @if($img)
                                            <img src="{{ $img }}" alt="{{ $p['product_name'] }}" class="product-thumb" loading="lazy">
                                        @else
                                            <div class="text-secondary"><i class="bi bi-image fs-1"></i></div>
                                        @endif
                                    </div>
                                    <div class="product-body" style="padding: 12px;">
                                        <h3 class="product-title" style="font-size: 0.88rem; white-space: nowrap; overflow: hidden; text-overflow: ellipsis; margin-bottom: 6px;">{{ $p['product_name'] }}</h3>
                                        <div class="product-price-section mb-2" style="display: flex; align-items: baseline; gap: 6px; flex-wrap: wrap;">
                                            @if($isDiscounted)
                                                <span class="sale-price" style="font-size: 0.95rem; color: #ef4444; font-weight: 700;">Rs. {{ number_format($p['discounted_price'], 0) }}</span>
                                                <span class="regular-price text-decoration-line-through text-muted" style="font-size: 0.78rem;">Rs. {{ number_format($p['price'], 0) }}</span>
                                            @else
                                                <span class="sale-price" style="font-size: 0.95rem; color: var(--text-dark); font-weight: 700;">Rs. {{ number_format($p['price'], 0) }}</span>
                                            @endif
                                        </div>
                                        
                                        <div class="product-rating-wrap mt-1 mb-2" style="font-size: 0.72rem; color: #6b7280; font-family:'Outfit',sans-serif;">
                                            @if(($p['sales_volume'] ?? 0) > 0)
                                                <div class="sold-row" style="margin-bottom: 3px;">
                                                    <span class="text-secondary fw-bold" style="background: #e0f2fe; color: #0369a1; padding: 1px 4px; border-radius: 3px; font-size: 0.68rem;">{{ $p['sales_volume'] }} sold</span>
                                                </div>
                                            @endif
                                            @if($count > 0)
                                                <div class="d-flex align-items-center gap-1" style="line-height: 1;">
                                                    <span class="fw-bold" style="color:#111827;">{{ number_format($avg, 1) }}</span>
                                                    <span style="display:inline-flex; align-items:center; gap:1px;">
                                                        @for($si = 1; $si <= 5; $si++)
                                                            @if($si <= floor($avg))
                                                                <i class="bi bi-star-fill" style="font-size:0.65rem; color:#f59e0b;"></i>
                                                            @elseif(($si - $avg) <= 0.5)
                                                                <i class="bi bi-star-half" style="font-size:0.65rem; color:#f59e0b;"></i>
                                                            @else
                                                                <i class="bi bi-star" style="font-size:0.65rem; color:#d1d5db;"></i>
                                                            @endif
                                                        @endfor
                                                    </span>
                                                    <span>({{ $count }})</span>
                                                </div>
                                            @else
                                                <div class="d-flex align-items-center gap-1 text-muted" style="line-height: 1;">
                                                    <span style="display:inline-flex; align-items:center; gap:1px;">
                                                        @for($si = 1; $si <= 5; $si++)
                                                            <i class="bi bi-star" style="font-size:0.65rem; color:#d1d5db;"></i>
                                                        @endfor
                                                    </span>
                                                    <span>(0)</span>
                                                </div>
                                            @endif
                                        </div>

                                        <div class="product-card-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 8px; border-top: 1px solid #f3f4f6;">
                                            <div class="product-status-badge">
                                                @if($inStock)
                                                    <span class="stock-badge-green" style="font-size: 0.68rem; padding: 2px 5px; font-weight: 600; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                                                        <i class="bi bi-check-circle-fill" style="color: #10b981; font-size: 0.65rem;"></i> In Stock
                                                    </span>
                                                @else
                                                    <span class="stock-badge-red" style="font-size: 0.68rem; padding: 2px 5px; font-weight: 600; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                                                        <i class="bi bi-x-circle-fill" style="color: #ef4444; font-size: 0.65rem;"></i> Out of Stock
                                                    </span>
                                                @endif
                                            </div>
                                            <div style="display: flex; gap: 5px; align-items: center;">
                                                @if($inStock)
                                                    <button type="button" class="js-add-to-cart-btn circle-action-btn" 
                                                            style="width: 28px; height: 28px; border-radius: 50%; border: none; background: #374151; color: #fff; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; padding: 0 !important; line-height: 1 !important;"
                                                            data-id="{{ $p['id'] }}"
                                                            data-stock-id="{{ $p['best_stock_id'] ?? '' }}"
                                                            data-name="{{ $p['product_name'] }}"
                                                            data-price="{{ $p['discounted_price'] ?? $p['price'] }}"
                                                            data-image="{{ $img }}"
                                                            data-max-qty="{{ $p['total_quantity'] ?? 999 }}"
                                                            data-tooltip="Add to Cart">
                                                        <i class="bi bi-cart-plus" style="font-size: 0.85rem;"></i>
                                                    </button>
                                                @endif
                                                <a href="https://wa.me/94706050500?text={{ urlencode('Hi, I\'m interested in buying: ' . $p['product_name'] . ' (ID: ' . $p['id'] . ')') }}" 
                                                   target="_blank" class="circle-action-btn" 
                                                   style="width: 28px; height: 28px; border-radius: 50%; background-color: #25d366; color: #fff; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; cursor: pointer;"
                                                   data-tooltip="WhatsApp Order">
                                                    <i class="bi bi-whatsapp" style="font-size: 0.85rem;"></i>
                                                </a>
                                            </div>
                                        </div>
                                        </div>
                                </div>
                            @endforeach
                        </div>
                        <button class="carousel-nav-btn next-btn" onclick="slideCarousel('trendingScroll', 1)"><i class="bi bi-chevron-right"></i></button>
                    </div>
                </div>
            @endif
        @endif


        {{-- Mobile-only: Section header for product grid --}}
        <div class="d-lg-none mobile-results-bar" style="display:flex; justify-content:space-between; align-items:center; margin-bottom:0.6rem; padding:0.3rem 0;">
            <span style="font-family:'Space Grotesk',sans-serif; font-size:1rem; font-weight:800; color:#111827;">
                @if($selectedCategory)
                    @foreach($categories as $c)
                        @if((string)$c->id === (string)$selectedCategory) {{ $c->name }} @endif
                    @endforeach
                @elseif($search)
                    Results for "{{ $search }}"
                @else
                    All Products
                @endif
            </span>
            <select aria-label="Sort products" onchange="location.href=this.value" style="font-size:0.75rem; border:1.5px solid #e5e7eb; border-radius:8px; padding:5px 8px; font-family:'Outfit',sans-serif; background:#fff; color:#374151;">
                <option value="{{ route('products.shop') }}?q={{ urlencode($search) }}&category={{ $selectedCategory }}&sort=default" {{ $sort==='default'?'selected':'' }}>Default</option>
                <option value="{{ route('products.shop') }}?q={{ urlencode($search) }}&category={{ $selectedCategory }}&sort=price_asc" {{ $sort==='price_asc'?'selected':'' }}>Price ↑</option>
                <option value="{{ route('products.shop') }}?q={{ urlencode($search) }}&category={{ $selectedCategory }}&sort=price_desc" {{ $sort==='price_desc'?'selected':'' }}>Price ↓</option>
                <option value="{{ route('products.shop') }}?q={{ urlencode($search) }}&category={{ $selectedCategory }}&sort=newest" {{ $sort==='newest'?'selected':'' }}>Newest</option>
            </select>
        </div>

        <div class="row g-4">
            <!-- Left Sidebar: Categories -->
            <div class="col-12 col-lg-3 d-none d-lg-block">
                <div class="sidebar-card" style="background: var(--neutral-card); border: 1px solid #e5e7eb; border-radius: var(--radius-md); padding: 1.5rem; box-shadow: var(--shadow-sm); position: sticky; top: 100px; z-index: 10;">
                    <h3 style="font-family: 'Space Grotesk', sans-serif; font-size: 1.15rem; font-weight: 700; color: var(--text-dark); margin-bottom: 1.25rem; border-bottom: 2px solid #f3f4f6; padding-bottom: 0.5rem; display: flex; align-items: center; justify-content: space-between;">
                        <span>Categories</span>
                        @if(!empty($selectedCategory))
                            <a href="{{ route('products.shop') }}?q={{ urlencode($search) }}&sort={{ $sort }}" class="text-danger small fw-normal text-decoration-none" style="font-size: 0.78rem;">Clear</a>
                        @endif
                    </h3>
                    <ul class="list-unstyled mb-0" style="display: flex; flex-direction: column; gap: 0.25rem;">
                        <li>
                            <a href="{{ route('products.shop') }}?q={{ urlencode($search) }}&sort={{ $sort }}" class="d-flex align-items-center justify-content-between p-2 rounded text-decoration-none {{ empty($selectedCategory) ? 'bg-light text-danger fw-bold' : 'text-secondary' }}" style="font-size: 0.88rem; transition: var(--transition-smooth); font-family: 'Outfit', sans-serif;">
                                <span>All Categories</span>
                            </a>
                        </li>
                        @foreach($categories as $cat)
                            <li>
                                <a href="{{ route('products.shop') }}?category={{ $cat->id }}&q={{ urlencode($search) }}&sort={{ $sort }}" class="d-flex align-items-center justify-content-between p-2 rounded text-decoration-none {{ (string)$selectedCategory === (string)$cat->id ? 'bg-light text-danger fw-bold' : 'text-secondary' }}" style="font-size: 0.88rem; transition: var(--transition-smooth); font-family: 'Outfit', sans-serif;">
                                    <div class="d-flex align-items-center gap-2">
                                        <i class="{{ $cat->icon_class }}" style="font-size: 1rem;"></i>
                                        <span>{{ $cat->name }}</span>
                                    </div>
                                </a>
                            </li>
                        @endforeach
                    </ul>
                </div>
            </div>

            <!-- Right Area: Products Listing -->
            <div class="col-12 col-lg-9">
                @if($products->isEmpty())
                    <div class="empty-results">
                        <i class="bi bi-box-seam fs-1 d-block mb-3 text-muted"></i>
                        <p class="fs-5 mb-0">No products match your search. Try searching for something else!</p>
                    </div>
                @else
                    <!-- Toolbar & Inline Sort (desktop only) -->
                    <div class="d-none d-lg-flex justify-content-between align-items-center mb-3 flex-wrap gap-2">
                        <span class="text-muted small" style="font-family: 'Outfit', sans-serif;">
                            Showing {{ $products->firstItem() ?? 0 }}-{{ $products->lastItem() ?? 0 }} of {{ $products->total() }} items
                            @if($search)
                                for "<strong>{{ $search }}</strong>"
                            @endif
                        </span>
                        
                        <div class="d-flex align-items-center gap-2">
                            {{-- Desktop In-Shop Search --}}
                            <form action="{{ route('products.shop') }}" method="GET" class="d-flex align-items-center" style="position: relative; width: 260px;">
                                <i class="bi bi-search" style="position: absolute; left: 12px; top: 50%; transform: translateY(-50%); color: #9ca3af; font-size: 0.85rem;"></i>
                                <input type="text" name="q" value="{{ $search }}" placeholder="Search products in catalog..." style="width: 100%; padding: 6px 10px 6px 32px; border: 1.5px solid #d1d5db; border-radius: 20px; font-size: 0.84rem; outline: none; background: #fff; font-family: 'Outfit', sans-serif;">
                                @if($selectedCategory)
                                    <input type="hidden" name="category" value="{{ $selectedCategory }}">
                                @endif
                                <input type="hidden" name="sort" value="{{ $sort }}">
                            </form>

                            <form action="{{ route('products.shop') }}" method="GET" id="shopForm" class="d-flex align-items-center gap-2">
                                <input type="hidden" name="category" value="{{ $selectedCategory }}">
                                <input type="hidden" name="q" value="{{ $search }}">
                                <div class="d-flex align-items-center border rounded bg-white px-2 py-1" style="font-size: 0.85rem; border-color: #d1d5db; min-width: 170px;">
                                    <i class="bi bi-sort-down text-secondary me-2" style="font-size: 1.1rem;"></i>
                                    <select name="sort" id="productSort" class="border-0 bg-transparent flex-grow-1" style="outline: none; cursor: pointer; font-size: 0.85rem; color: #4b5563; font-weight: 500; padding: 2px 0;">
                                        <option value="default" {{ $sort == 'default' ? 'selected' : '' }}>Default Sorting</option>
                                        <option value="asc" {{ $sort == 'asc' ? 'selected' : '' }}>Price: Low to High</option>
                                        <option value="desc" {{ $sort == 'desc' ? 'selected' : '' }}>Price: High to Low</option>
                                    </select>
                                </div>
                            </form>
                        </div>
                    </div>

                    <!-- Products Grid -->
                    <div class="products-grid">
                        @foreach($products as $product)
                            @php
                                $image = $product['main_image_url'] ?? ($product['images'][0] ?? null);
                                $isDiscounted = !empty($product['has_discount']) && $product['discount_percentage'] > 0;
                                $inStock = ($product['total_quantity'] ?? 0) > 0;
                                $avg = (float) ($product['avg_rating'] ?? 0);
                                $count = (int) ($product['reviews_count'] ?? 0);
                            @endphp
                            <article class="product-card js-card" data-id="{{ $product['id'] }}">
                                <div class="product-media">
                                    @if($isDiscounted)
                                        <span class="discount-tag">-{{ $product['discount_percentage'] }}% Off</span>
                                    @endif

                                    @if($image)
                                        <img src="{{ $image }}" alt="{{ $product['product_name'] }}" class="product-thumb" loading="lazy" decoding="async">
                                    @else
                                        <div class="text-secondary"><i class="bi bi-image fs-1"></i></div>
                                    @endif
                                </div>

                                <div class="product-body">
                                    <h2 class="product-title">{{ $product['product_name'] }}</h2>

                                    <div class="product-price-section">
                                        @if(!is_null($product['price']))
                                            @if($isDiscounted)
                                                <span class="sale-price">Rs. {{ number_format($product['discounted_price'], 2) }}</span>
                                                <span class="regular-price">Rs. {{ number_format($product['price'], 2) }}</span>
                                                <span class="savings-tag">Save Rs. {{ number_format($product['discount_amount'], 2) }}</span>
                                            @else
                                                <span class="sale-price" style="color: var(--text-dark);">Rs. {{ number_format($product['price'], 2) }}</span>
                                            @endif
                                        @else
                                            <span class="sale-price">N/A</span>
                                        @endif
                                    </div>

                                    <!-- Ratings, Reviews & Sales Volume (split into 2 rows for mobile spacing) -->
                                    <div class="product-rating-wrap mt-1 mb-2" style="font-size: 0.72rem; color: #6b7280; font-family:'Outfit',sans-serif;">
                                        @if(($product['sales_volume'] ?? 0) > 0)
                                            <div class="sold-row" style="margin-bottom: 3px;">
                                                <span class="text-secondary fw-bold" style="background: #f3f4f6; padding: 2px 6px; border-radius: 4px;">{{ $product['sales_volume'] }} sold</span>
                                            </div>
                                        @endif
                                        @if($count > 0)
                                            <div class="d-flex align-items-center gap-1" style="line-height: 1;">
                                                <span class="fw-bold" style="color:#111827;">{{ number_format($avg, 1) }}</span>
                                                <span style="display:inline-flex; align-items:center; gap:1px;">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        @if($i <= floor($avg))
                                                            <i class="bi bi-star-fill" style="font-size: 0.65rem; color: #f59e0b;"></i>
                                                        @elseif(($i - $avg) <= 0.5)
                                                            <i class="bi bi-star-half" style="font-size: 0.65rem; color: #f59e0b;"></i>
                                                        @else
                                                            <i class="bi bi-star" style="font-size: 0.65rem; color: #d1d5db;"></i>
                                                        @endif
                                                    @endfor
                                                </span>
                                                <span>({{ $count }})</span>
                                            </div>
                                        @else
                                            <div class="d-flex align-items-center gap-1 text-muted" style="line-height: 1;">
                                                <span style="display:inline-flex; align-items:center; gap:1px;">
                                                    @for($i = 1; $i <= 5; $i++)
                                                        <i class="bi bi-star" style="font-size: 0.65rem; color: #d1d5db;"></i>
                                                    @endfor
                                                </span>
                                                <span>(0)</span>
                                            </div>
                                        @endif
                                    </div>

                                    <div class="product-card-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 12px; border-top: 1px solid #f3f4f6;">
                                        <div class="product-status-badge">
                                            @if($inStock)
                                                <span class="stock-badge-green" style="font-size: 0.72rem; padding: 2px 6px; font-weight: 600; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                                                    <i class="bi bi-check-circle-fill" style="color: #10b981; font-size: 0.65rem;"></i> In Stock
                                                </span>
                                            @else
                                                <span class="stock-badge-red" style="font-size: 0.72rem; padding: 2px 6px; font-weight: 600; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                                                    <i class="bi bi-x-circle-fill" style="color: #ef4444; font-size: 0.65rem;"></i> Out of Stock
                                                </span>
                                            @endif
                                        </div>
                                        <div style="display: flex; gap: 6px; align-items: center;">
                                            @if($inStock)
                                                <button type="button" class="js-add-to-cart-btn circle-action-btn" 
                                                        style="width: 32px; height: 32px; border-radius: 50%; border: none; background: #374151; color: #fff; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; padding: 0 !important; line-height: 1 !important;"
                                                        data-id="{{ $product['id'] }}"
                                                        data-stock-id="{{ $product['best_stock_id'] ?? '' }}"
                                                        data-name="{{ $product['product_name'] }}"
                                                        data-price="{{ $product['discounted_price'] ?? $product['price'] }}"
                                                        data-image="{{ $image }}"
                                                        data-max-qty="{{ $product['total_quantity'] ?? 999 }}"
                                                        data-tooltip="Add to Cart">
                                                    <i class="bi bi-cart-plus" style="font-size: 1rem;"></i>
                                                </button>
                                            @endif
                                            <a href="https://wa.me/94706050500?text={{ urlencode('Hi, I\'m interested in buying: ' . $product['product_name'] . ' (ID: ' . $product['id'] . ')') }}" 
                                               target="_blank" class="circle-action-btn" 
                                               style="width: 32px; height: 32px; border-radius: 50%; background-color: #25d366; color: #fff; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; cursor: pointer;"
                                               data-tooltip="WhatsApp Order">
                                                <i class="bi bi-whatsapp" style="font-size: 1rem;"></i>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </article>
                        @endforeach
                    </div>

                    <!-- Pagination with Page Numbers -->
                    @if($products->hasPages())
                        @php
                            $currentPage = $products->currentPage();
                            $lastPage = $products->lastPage();
                            $startPage = max(1, $currentPage - 2);
                            $endPage = min($lastPage, $currentPage + 2);
                        @endphp
                        <div class="pagination-container">
                            {{-- Previous Page Link --}}
                            @if($products->onFirstPage())
                                <span class="page-nav disabled"><i class="bi bi-chevron-left"></i> <span class="d-none d-sm-inline ms-1">Prev</span></span>
                            @else
                                <a href="{{ $products->previousPageUrl() }}" class="page-nav"><i class="bi bi-chevron-left"></i> <span class="d-none d-sm-inline ms-1">Prev</span></a>
                            @endif

                            {{-- First Page + Ellipsis if far --}}
                            @if($startPage > 1)
                                <a href="{{ $products->url(1) }}" class="page-num {{ $currentPage == 1 ? 'active' : '' }}">1</a>
                                @if($startPage > 2)
                                    <span class="page-dots">&hellip;</span>
                                @endif
                            @endif

                            {{-- Page Number Range --}}
                            @for($i = $startPage; $i <= $endPage; $i++)
                                @if($i == $currentPage)
                                    <span class="page-num active">{{ $i }}</span>
                                @else
                                    <a href="{{ $products->url($i) }}" class="page-num">{{ $i }}</a>
                                @endif
                            @endfor

                            {{-- Last Page + Ellipsis if far --}}
                            @if($endPage < $lastPage)
                                @if($endPage < $lastPage - 1)
                                    <span class="page-dots">&hellip;</span>
                                @endif
                                <a href="{{ $products->url($lastPage) }}" class="page-num {{ $currentPage == $lastPage ? 'active' : '' }}">{{ $lastPage }}</a>
                            @endif

                            {{-- Next Page Link --}}
                            @if($products->hasMorePages())
                                <a href="{{ $products->nextPageUrl() }}" class="page-nav"><span class="d-none d-sm-inline me-1">Next</span> <i class="bi bi-chevron-right"></i></a>
                            @else
                                <span class="page-nav disabled"><span class="d-none d-sm-inline me-1">Next</span> <i class="bi bi-chevron-right"></i></span>
                            @endif
                        </div>
                    @endif
                @endif
            </div>
        </div>
    </div>
</div>
@endsection

@section('scripts')
    <script>
        window.slideCarousel = function(id, direction) {
            const el = document.getElementById(id);
            if (el) {
                const scrollAmount = el.clientWidth * 0.8;
                el.scrollBy({
                    left: direction * scrollAmount,
                    behavior: 'smooth'
                });
            }
        };

        $(function() {
            // Auto slide carousels
            function initAutoSlide(id) {
                const el = document.getElementById(id);
                if (!el) return;
                
                let isInteracting = false;
                el.addEventListener('mouseenter', () => isInteracting = true);
                el.addEventListener('mouseleave', () => isInteracting = false);
                el.addEventListener('touchstart', () => isInteracting = true);
                el.addEventListener('touchend', () => isInteracting = false);

                setInterval(() => {
                    if (isInteracting) return;
                    
                    const maxScroll = el.scrollWidth - el.clientWidth;
                    if (el.scrollLeft >= maxScroll - 5) {
                        el.scrollTo({ left: 0, behavior: 'smooth' });
                    } else {
                        el.scrollBy({ left: 240, behavior: 'smooth' });
                    }
                }, 4000);
            }

            initAutoSlide('flashSaleScroll');
            initAutoSlide('trendingScroll');

            // Product card redirect
            $('.js-card').on('click', function(e) {
                if ($(e.target).closest('.order-btn, .js-add-to-cart-btn').length === 0) {
                    const id = $(this).data('id');
                    window.location.href = '{{ url("/shop/product") }}/' + id;
                }
            });

            // Quick Add to Cart click handler
            $('.js-add-to-cart-btn').on('click', function(e) {
                e.preventDefault();
                e.stopPropagation();

                const product = {
                    product_id: parseInt($(this).data('id')),
                    stock_id: parseInt($(this).data('stock-id')) || null,
                    product_name: $(this).data('name'),
                    selling_price: parseFloat($(this).data('price')),
                    quantity: 1,
                    image: $(this).data('image') || null,
                    max_qty: parseInt($(this).data('max-qty')) || 999
                };

                if (typeof window.addToCart === 'function') {
                    window.addToCart(product);
                } else {
                    console.error('addToCart function is not defined globally.');
                }
            });

            // Sync sort select
            $('#productSort').val(@json($sort ?? 'default'));



            $('#productSort').on('change', function() {
                this.form.submit();
            });
        });
    </script>
@endsection
