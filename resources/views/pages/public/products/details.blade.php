@extends('layouts.frontend')

@php
    $metaDesc = !empty($product['short_description']) 
        ? \Illuminate\Support\Str::limit(strip_tags($product['short_description']), 155) 
        : "Buy {$product['product_name']} at best price in Sri Lanka. Islandwide cash on delivery from Loku Kade.";
    $productImage = $product['main_image_url'] ?? ($product['images'][0] ?? asset('assets/images/logo.webp'));
    $productPrice = (float) ($product['discounted_price'] ?? $product['price'] ?? 0);
    $inStock = ($product['total_quantity'] ?? 0) > 0;

    $schemaImages = !empty($product['images']) ? $product['images'] : [$productImage];
    $productSchema = [
        '@context' => 'https://schema.org/',
        '@type' => 'Product',
        'name' => $product['product_name'],
        'image' => $schemaImages,
        'description' => strip_tags($product['short_description'] ?? $metaDesc),
        'sku' => 'LK-' . $product['id'],
        'brand' => [
            '@type' => 'Brand',
            'name' => 'Loku Kade',
        ],
        'offers' => [
            '@type' => 'Offer',
            'url' => url()->current(),
            'priceCurrency' => 'LKR',
            'price' => number_format($productPrice, 2, '.', ''),
            'priceValidUntil' => date('Y-12-31', strtotime('+1 year')),
            'availability' => $inStock ? 'https://schema.org/InStock' : 'https://schema.org/OutOfStock',
            'itemCondition' => 'https://schema.org/NewCondition',
            'seller' => [
                '@type' => 'Organization',
                'name' => 'Loku Kade',
            ],
        ],
    ];

    if (($reviewsCount ?? 0) > 0) {
        $productSchema['aggregateRating'] = [
            '@type' => 'AggregateRating',
            'ratingValue' => (string) $avgRating,
            'reviewCount' => (string) $reviewsCount,
            'bestRating' => '5',
            'worstRating' => '1',
        ];
    }

    $breadcrumbSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'BreadcrumbList',
        'itemListElement' => [
            [
                '@type' => 'ListItem',
                'position' => 1,
                'name' => 'Home',
                'item' => url('/'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 2,
                'name' => 'Shop',
                'item' => route('products.shop'),
            ],
            [
                '@type' => 'ListItem',
                'position' => 3,
                'name' => $product['product_name'],
                'item' => url()->current(),
            ],
        ],
    ];
@endphp

@section('title', $product['product_name'] . ' - Loku Kade')
@section('meta_description', $metaDesc)
@section('og_type', 'product')
@section('og_image', $productImage)

@section('schema')
<script type="application/ld+json">
{!! json_encode($productSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
</script>
<script type="application/ld+json">
{!! json_encode($breadcrumbSchema, JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT | JSON_UNESCAPED_UNICODE) !!}
</script>
@endsection

@section('styles')
    <style>
        /* --- 1. PREMIUM NEOMORPHIC & GLASS VARIABLES --- */
        :root {
            --bg-base: #fdfaf7;
            --card-glass: rgba(255, 255, 255, 0.85);
            --border-glass: rgba(254, 215, 170, 0.4);
            
            --text-dark: #1e1b18;
            --text-secondary: #475569;
            --text-muted: #64748b;
            
            --accent: #ea580c;
            --accent-light: #ffedd5;
            --accent-dark: #c2410c;
            --accent-gradient: linear-gradient(135deg, #dc2626 0%, #f97316 100%);
            
            --shadow-flat: 4px 4px 10px #e2dfdb, -4px -4px 10px #ffffff;
            --shadow-hover: 6px 6px 15px #dad7d3, -6px -6px 15px #ffffff;
            --shadow-glow: 0 10px 25px -5px rgba(234, 88, 12, 0.25);
            
            --radius-sm: 12px;
            --radius-md: 18px;
            --radius-lg: 24px;
            
            --transition-smooth: all 0.35s cubic-bezier(0.16, 1, 0.3, 1);
        }

        .catalog-wrap {
            padding: 145px 0 50px;
            background: transparent;
        }
        @media (max-width: 991.98px) {
            .catalog-wrap { padding: 95px 0 25px !important; }
            .details-nav { margin-bottom: 1rem; padding: 0 14px; }
            .btn-back { width: 36px; height: 36px; font-size: 1.05rem; box-shadow: none; }
            .product-details-container {
                margin-bottom: 1rem;
                padding: 14px;
                border-radius: 18px;
                box-shadow: none;
            }
            .main-preview-box { border-radius: 14px; }
            .checkout-card { position: relative; }
        }

        /* --- 2. BREADCRUMB / BACK TO CATALOG --- */
        .details-nav {
            max-width: 1100px;
            margin: 0 auto 1.5rem;
            padding: 0 1.25rem;
            display: flex;
            align-items: center;
            justify-content: space-between;
        }
        
        .btn-back {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 40px;
            height: 40px;
            border-radius: 50%;
            background: #ffffff;
            border: 1px solid #e2e8f0;
            color: var(--text-dark);
            font-size: 1.15rem;
            box-shadow: 0 2px 8px rgba(0,0,0,0.06);
            text-decoration: none;
            transition: var(--transition-smooth);
            flex: 0 0 40px;
        }
        
        .btn-back:hover {
            color: var(--accent);
            background: #fff5f5;
            border-color: #fecaca;
            transform: translateX(-3px);
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.15);
        }

        /* --- 3. DETAILS CONTAINER --- */
        .product-details-container {
            max-width: 1100px;
            margin: 0 auto 2.5rem;
            padding: 2.2rem;
            background: var(--neutral-white);
            border: 1px solid var(--neutral-border);
            border-radius: var(--radius-lg);
            box-shadow: var(--shadow-flat);
        }

        /* --- 4. GALLERY & PREVIEW --- */
        .image-gallery-wrap {
            display: flex;
            flex-direction: column;
            gap: 1.2rem;
        }
        
        @media (min-width: 768px) {
            .image-gallery-wrap {
                position: sticky;
                top: 100px;
                align-self: start;
            }
        }
        
        .main-preview-box {
            aspect-ratio: 1 / 1;
            background: #fafaf9;
            border: 1.5px solid var(--neutral-border);
            border-radius: var(--radius-md);
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
        }
        
        .main-preview-box img {
            width: 100%;
            height: 100%;
            object-fit: cover;
            transition: var(--transition-smooth);
        }
        
        .preview-nav-btn {
            position: absolute;
            top: 50%;
            transform: translateY(-50%);
            width: 42px;
            height: 42px;
            border-radius: 50%;
            background: rgba(255, 255, 255, 0.88);
            backdrop-filter: blur(8px);
            -webkit-backdrop-filter: blur(8px);
            border: 1px solid rgba(255, 255, 255, 0.9);
            box-shadow: 0 4px 14px rgba(0, 0, 0, 0.15);
            color: #1f2937;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 1.25rem;
            cursor: pointer;
            z-index: 20;
            transition: all 0.25s cubic-bezier(0.16, 1, 0.3, 1);
            outline: none;
            padding: 0;
            user-select: none;
        }

        .preview-nav-btn:hover {
            background: #ffffff;
            color: var(--accent);
            transform: translateY(-50%) scale(1.1);
            box-shadow: 0 6px 20px rgba(220, 38, 38, 0.25);
        }

        .preview-nav-btn:active {
            transform: translateY(-50%) scale(0.92);
        }

        .preview-nav-btn.prev-btn {
            left: 12px;
        }

        .preview-nav-btn.next-btn {
            right: 12px;
        }

        @media (max-width: 767.98px) {
            .preview-nav-btn {
                width: 36px;
                height: 36px;
                font-size: 1.05rem;
            }
            .preview-nav-btn.prev-btn {
                left: 8px;
            }
            .preview-nav-btn.next-btn {
                right: 8px;
            }
        }

        .details-discount-badge {
            position: absolute;
            top: 16px;
            left: 16px;
            background: var(--accent-gradient);
            color: #ffffff;
            font-size: 0.82rem;
            font-weight: 700;
            padding: 4px 12px;
            border-radius: 99px;
            box-shadow: 0 4px 12px rgba(220, 38, 38, 0.3);
            z-index: 10;
        }
        
        .thumb-strip {
            display: flex;
            gap: 0.75rem;
            overflow-x: auto;
            scrollbar-width: none;
            padding: 0.2rem;
        }
        
        .thumb-strip::-webkit-scrollbar {
            display: none;
        }
        
        .thumb-item {
            flex: 0 0 76px;
            aspect-ratio: 1 / 1;
            border: 2px solid var(--neutral-border);
            border-radius: var(--radius-sm);
            cursor: pointer;
            overflow: hidden;
            background: #fafaf9;
            transition: var(--transition-smooth);
        }
        
        .thumb-item img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .thumb-item:hover, .thumb-item.active {
            border-color: var(--accent);
            transform: scale(1.05);
        }
        
        .video-thumb {
            position: relative;
        }
        
        .video-thumb .play-overlay {
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 100%;
            background: rgba(0, 0, 0, 0.4);
            display: flex;
            align-items: center;
            justify-content: center;
            color: #ffffff;
            font-size: 1.5rem;
            transition: var(--transition-smooth);
        }
        
        .video-thumb:hover .play-overlay {
            background: rgba(0, 0, 0, 0.2);
            color: var(--accent);
        }

        /* --- 5. INFO & PRICING --- */
        .info-col {
            display: flex;
            flex-direction: column;
            gap: 1rem;
        }
        
        .details-slogan {
            background: var(--accent-light);
            color: var(--accent-dark);
            padding: 4px 12px;
            border-radius: 99px;
            font-weight: 700;
            font-size: 0.78rem;
            display: inline-block;
            align-self: flex-start;
            font-family: var(--font-display);
        }
        
        .details-title {
            font-family: var(--font-display);
            font-size: 1.85rem;
            font-weight: 700;
            color: var(--text-dark);
            line-height: 1.3;
        }
        
        .details-stock-status {
            font-size: 0.85rem;
            font-weight: 700;
            color: var(--accent-success, #0d9488);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }
        
        .details-stock-status.out {
            color: #dc2626;
        }
        
        .details-price-card {
            background: var(--bg-base);
            border: 1px solid var(--neutral-border);
            border-radius: var(--radius-md);
            padding: 1.25rem;
            box-shadow: inset 2px 2px 5px #e2dfdb, inset -2px -2px 5px #ffffff;
        }
        
        .price-label {
            font-size: 0.78rem;
            color: var(--text-muted);
            text-transform: uppercase;
            letter-spacing: 0.5px;
            margin-bottom: 2px;
        }
        
        .retail-price {
            font-size: 1rem;
            color: var(--text-muted);
            text-decoration: line-through;
            margin-bottom: 0.5rem;
        }
        
        .main-price-val {
            font-size: 2.1rem;
            font-weight: 700;
            color: var(--accent);
            line-height: 1;
        }
        
        .you-save {
            margin-top: 0.5rem;
            font-size: 0.85rem;
            font-weight: 600;
            color: var(--accent-success, #0d9488);
        }
        
        .btn-whatsapp-order {
            background: #25d366;
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            padding: 14px 24px;
            border-radius: var(--radius-sm);
            border: none;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            gap: 0.6rem;
            box-shadow: 0 4px 15px rgba(37, 211, 102, 0.25);
            text-decoration: none;
            transition: var(--transition-smooth);
        }
        
        .btn-whatsapp-order:hover {
            background: #128c7e;
            color: #ffffff;
            transform: translateY(-2px);
        }
        
        .btn-share-product {
            background: var(--card-glass);
            border: 1px solid var(--neutral-border);
            padding: 14px 20px;
            border-radius: var(--radius-sm);
            color: var(--text-secondary);
            font-weight: 600;
            box-shadow: var(--shadow-flat);
            transition: var(--transition-smooth);
        }
        
        .btn-share-product:hover {
            color: var(--accent);
            transform: translateY(-2px);
        }
        
        .trust-promises-box {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.75rem;
            margin-top: 0.5rem;
        }
        
        .promise-pill {
            background: #f8fafc;
            border: 1px solid #f1f5f9;
            padding: 8px 12px;
            border-radius: 8px;
            font-size: 0.78rem;
            font-weight: 600;
            color: var(--text-secondary);
            display: flex;
            align-items: center;
            gap: 0.4rem;
        }

        /* --- 6. CHECKOUT FORM CARD --- */
        .checkout-card {
            background: var(--neutral-white);
            border: 1.5px solid var(--accent-light);
            border-radius: var(--radius-md);
            padding: 1.8rem;
            box-shadow: 0 8px 24px rgba(234, 88, 12, 0.08);
            transition: var(--transition-smooth);
        }
        
        .checkout-card:focus-within {
            border-color: var(--accent);
            box-shadow: 0 8px 30px rgba(234, 88, 12, 0.15);
        }

        .form-control, .form-select {
            padding: 10px 14px;
            border: 1.5px solid var(--neutral-border);
            border-radius: 8px;
            font-size: 0.92rem;
            font-family: var(--font-body);
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(234, 88, 12, 0.15);
            outline: none;
        }

        /* --- 7. DESCRIPTION BOX --- */
        .details-desc-box {
            margin-top: 3rem;
            padding-top: 2rem;
            border-top: 1px dashed var(--neutral-border);
        }
        
        .details-desc-title {
            font-family: var(--font-display);
            font-size: 1.3rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1rem;
        }
        
        .details-desc-content {
            font-size: 0.95rem;
            color: var(--text-secondary);
            line-height: 1.7;
        }

        /* --- 8. RELATED PRODUCTS --- */
        .related-section {
            max-width: 1100px;
            margin: 0 auto;
            padding: 0 1.25rem;
        }
        
        .related-section-title {
            font-family: var(--font-display);
            font-size: 1.4rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 1.5rem;
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .related-products-carousel {
            display: grid;
            grid-template-columns: repeat(2, 1fr);
            gap: 0.85rem;
        }

        @media (min-width: 576px) {
            .related-products-carousel {
                grid-template-columns: repeat(2, 1fr);
                gap: 1.25rem;
            }
        }

        @media (min-width: 992px) {
            .related-products-carousel {
                grid-template-columns: repeat(4, 1fr);
                gap: 1.5rem;
            }
        }
        
        .related-card {
            background: var(--neutral-white);
            border: 1px solid var(--neutral-border);
            border-radius: var(--radius-md);
            overflow: hidden;
            box-shadow: var(--shadow-flat);
            display: flex;
            flex-direction: column;
            text-decoration: none;
            transition: var(--transition-smooth);
        }
        
        .related-card:hover {
            transform: translateY(-4px);
            box-shadow: var(--shadow-hover);
            border-color: var(--accent-light);
        }
        
        .related-card-media {
            aspect-ratio: 1 / 1;
            position: relative;
            background: #fafaf9;
            overflow: hidden;
            display: flex;
            align-items: center;
            justify-content: center;
            border-bottom: 1px solid var(--neutral-border);
        }
        
        .related-card-media img {
            width: 100%;
            height: 100%;
            object-fit: cover;
        }
        
        .related-discount-badge {
            position: absolute;
            top: 10px;
            right: 10px;
            background: var(--accent-gradient);
            color: #ffffff;
            font-size: 0.72rem;
            font-weight: 700;
            padding: 2px 8px;
            border-radius: 99px;
            z-index: 5;
        }
        
        .related-card-content {
            padding: 1rem;
            flex-grow: 1;
        }
        
        .related-card-title {
            font-family: var(--font-display);
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.3rem;
            line-height: 1.35;
            display: -webkit-box;
            -webkit-line-clamp: 2;
            -webkit-box-orient: vertical;
            overflow: hidden;
            height: 2.5rem;
        }
        
        .related-card-prices {
            display: flex;
            align-items: baseline;
            gap: 0.4rem;
        }
        
        .related-price-now {
            font-size: 1.05rem;
            font-weight: 700;
            color: var(--accent);
        }
        
        .related-price-old {
            font-size: 0.8rem;
            color: var(--text-muted);
            text-decoration: line-through;
        }
        
        .related-card-footer {
            padding: 0.75rem 1rem;
            border-top: 1px solid var(--neutral-border);
            display: flex;
            justify-content: space-between;
            align-items: center;
            background: #fafaf9;
        }
        
        .related-qty-status {
            font-size: 0.75rem;
            font-weight: 600;
            color: var(--accent-success, #0d9488);
        }
        
        .related-qty-status.out {
            color: #dc2626;
        }
        
        .btn-related-cart {
            width: 28px;
            height: 28px;
            background: #374151;
            color: #ffffff;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            box-shadow: 0 2px 6px rgba(55, 65, 81, 0.2);
            transition: var(--transition-smooth);
            cursor: pointer;
        }
        
        .btn-related-cart:hover {
            background: var(--accent);
            transform: scale(1.08);
            color: #ffffff;
        }

        .btn-related-wa {
            width: 28px;
            height: 28px;
            background: #25d366;
            color: #ffffff;
            border-radius: 50%;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.95rem;
            box-shadow: 0 2px 6px rgba(37, 211, 102, 0.2);
            transition: var(--transition-smooth);
            cursor: pointer;
        }
        
        .btn-related-wa:hover {
            background: #128c7e;
            transform: scale(1.08);
            color: #ffffff;
        }

        /* --- 9. SHARE TOAST --- */
        .share-toast {
            position: fixed;
            bottom: 30px;
            left: 50%;
            transform: translateX(-50%) translateY(100px);
            background: #1e1b18;
            color: #ffffff;
            padding: 12px 24px;
            border-radius: 99px;
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
            font-size: 0.92rem;
            font-weight: 600;
            z-index: 9999;
            transition: transform 0.4s cubic-bezier(0.175, 0.885, 0.32, 1.275);
            display: flex;
            align-items: center;
            gap: 0.5rem;
        }
        
        .share-toast.show {
            transform: translateX(-50%) translateY(0);
        }
        
        .spin {
            animation: spin 1s linear infinite;
        }
        @keyframes spin {
            100% { transform: rotate(360deg); }
        }
    </style>
@endsection

@section('content')
    @php
        $ytVideoId = null;
        if (!empty($product['youtube_video_url'])) {
            $rawUrl = trim($product['youtube_video_url']);
            if (preg_match('%(?:youtube(?:-nocookie)?\.com/(?:.*[?&]v=|shorts/|embed/|v/)|youtu\.be/)([^"&?/ ]{11})%i', $rawUrl, $match)) {
                $ytVideoId = $match[1];
            } elseif (preg_match('/^[a-zA-Z0-9_-]{11}$/', $rawUrl)) {
                $ytVideoId = $rawUrl;
            }
        }
    @endphp

    <div class="catalog-wrap">
        
        <!-- Breadcrumb / Back to catalog -->
        <div class="details-nav">
            <a href="{{ route('products.shop') }}" class="btn-back" title="Back to Shop" aria-label="Back to Shop">
                <i class="bi bi-arrow-left"></i>
            </a>
            
            <a href="https://wa.me/94706050500" target="_blank" class="d-inline-flex align-items-center gap-2 text-decoration-none">
                <i class="bi bi-whatsapp text-success fs-5"></i>
                <span class="text-dark fw-bold" style="font-size: 0.88rem; font-family: var(--font-display);">WhatsApp Order: 070 60 50 500</span>
            </a>
        </div>

        <!-- Product Card Body -->
        <div class="product-details-container">
            <div class="row g-4">
                
                <!-- Images Slider column -->
                <div class="col-12 col-md-6">
                    <div class="image-gallery-wrap">
                        
                        <!-- Main Preview Container -->
                        <div class="main-preview-box">
                            @if($product['has_discount'] && $product['discount_percentage'] > 0)
                                <span class="details-discount-badge">-{{ $product['discount_percentage'] }}% OFF</span>
                            @endif

                            @if(!empty($product['images']))
                                <img id="mainProductPreview" src="{{ $product['images'][0] }}" alt="{{ $product['product_name'] }}">
                            @else
                                <div id="mainProductPlaceholder" class="product-placeholder">
                                    <i class="bi bi-box-seam"></i>
                                    <span>Loku Kade</span>
                                </div>
                            @endif

                            <!-- YouTube Video Preview Container -->
                            <div id="videoPreviewContainer" class="w-100 h-100 position-absolute top-0 start-0 d-none">
                                <iframe id="ytPlayerFrame" class="w-100 h-100 border-0" src="" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            </div>

                            <!-- Media Navigation Arrows -->
                            @if((count($product['images']) + (!empty($ytVideoId) ? 1 : 0)) > 1)
                                <button type="button" class="preview-nav-btn prev-btn" id="btnPreviewPrev" aria-label="Previous Media" title="Previous Image/Video">
                                    <i class="bi bi-chevron-left"></i>
                                </button>
                                <button type="button" class="preview-nav-btn next-btn" id="btnPreviewNext" aria-label="Next Media" title="Next Image/Video">
                                    <i class="bi bi-chevron-right"></i>
                                </button>
                            @endif
                        </div>

                        <!-- Thumbnails list -->
                        @if(count($product['images']) > 1 || !empty($ytVideoId))
                            <div class="thumb-strip">
                                @foreach($product['images'] as $index => $img)
                                    <div class="thumb-item js-gallery-thumb {{ $index === 0 ? 'active' : '' }}" data-src="{{ $img }}">
                                        <img src="{{ $img }}" alt="Product thumbnail {{ $index+1 }}">
                                    </div>
                                @endforeach

                                @if(!empty($ytVideoId))
                                    <div class="thumb-item position-relative video-thumb js-video-thumb" data-video-id="{{ $ytVideoId }}">
                                        <img src="https://img.youtube.com/vi/{{ $ytVideoId }}/0.jpg" alt="Product Video Thumbnail">
                                        <div class="play-overlay"><i class="bi bi-play-btn-fill"></i></div>
                                    </div>
                                @endif
                            </div>
                        @endif

                    </div>
                </div>

                <!-- Product Text Info & Checkout Column -->
                <div class="col-12 col-md-6">
                    <div class="info-col">
                        <span class="details-slogan">Loku Kade Quality</span>
                        
                        <h1 class="details-title">{{ $product['product_name'] }}</h1>

                        <!-- Rating Stars & Summary -->
                        <div class="d-flex align-items-center gap-2 mb-3 mt-1" style="font-size: 0.9rem;">
                            @if($reviewsCount > 0)
                                <span class="fw-bold text-dark">{{ number_format($avgRating, 1) }}</span>
                                <div class="d-flex text-warning">
                                    @for($i = 1; $i <= 5; $i++)
                                        @if($i <= floor($avgRating))
                                            <i class="bi bi-star-fill" style="margin-right: 2px;"></i>
                                        @elseif(($i - $avgRating) <= 0.5)
                                            <i class="bi bi-star-half" style="margin-right: 2px;"></i>
                                        @else
                                            <i class="bi bi-star text-muted" style="margin-right: 2px;"></i>
                                        @endif
                                    @endfor
                                </div>
                                <span class="text-secondary">({{ $reviewsCount }} Reviews)</span>
                            @else
                                <div class="d-flex text-muted">
                                    @for($i = 1; $i <= 5; $i++)
                                        <i class="bi bi-star" style="margin-right: 2px;"></i>
                                    @endfor
                                </div>
                                <span class="text-secondary">(No reviews yet)</span>
                            @endif
                        </div>
                        
                        @if(($product['total_quantity'] ?? 0) > 0)
                            <div class="details-stock-status">
                                <i class="bi bi-check-circle-fill"></i> In Stock ({{ $product['total_quantity'] }} items available)
                            </div>
                        @else
                            <div class="details-stock-status out">
                                <i class="bi bi-x-circle-fill"></i> Out of Stock
                            </div>
                        @endif

                        <!-- Pricing Box -->
                        <div class="details-price-card">
                            @if($product['has_discount'] && $product['price'] > 0)
                                <div class="price-label">Original Price</div>
                                <div class="retail-price">Rs. {{ number_format($product['price'], 2) }}</div>
                            @endif

                            <div class="price-label">Special Offer Price</div>
                            <div class="main-price-val">Rs. {{ number_format($product['discounted_price'] ?? $product['price'], 2) }}</div>
                            
                            @if($product['has_discount'] && $product['price'] > 0 && ($product['price'] - $product['discounted_price']) > 0)
                                <div class="you-save">
                                    <i class="bi bi-gift-fill me-1"></i> You Save: Rs. {{ number_format($product['price'] - $product['discounted_price'], 2) }}
                                </div>
                            @endif
                        </div>

                        <!-- Direct WhatsApp Order button variables -->
                        @php
                            $waMessage = "Hi, I am interested in ordering: {$product['product_name']} (Product ID: {$product['id']}). Please guide me through placing this order.";
                            $waUrl = "https://wa.me/94706050500?text=" . urlencode($waMessage);
                        @endphp

                        <!-- Direct Purchase Guarantees -->
                        <div class="trust-promises-box">
                            <div class="promise-pill">
                                <i class="bi bi-truck"></i> Free Islandwide Delivery
                            </div>
                            <div class="promise-pill">
                                <i class="bi bi-cash-coin"></i> Cash on Delivery
                            </div>
                            <div class="promise-pill">
                                <i class="bi bi-patch-check"></i> Package open verification
                            </div>
                            <div class="promise-pill">
                                <i class="bi bi-chat-dots"></i> 24/7 WhatsApp help desk
                            </div>
                        </div>

                        <!-- Quantity Selector -->
                        @if(($product['total_quantity'] ?? 0) > 0)
                            <div class="quantity-selector-wrap mt-2 d-flex align-items-center gap-3">
                                <span class="fw-bold text-dark" style="font-family: var(--font-display);">Quantity (ප්‍රමාණය):</span>
                                <div class="d-flex align-items-center border rounded" style="max-width: 150px; background: #fff; box-shadow: var(--shadow-flat);">
                                    <button class="btn btn-sm px-3 py-2 border-0" id="btnQtyMinus"><i class="bi bi-dash fs-5"></i></button>
                                    <input type="number" id="inputQuantity" value="1" min="1" max="{{ $product['total_quantity'] }}" class="border-0 text-center fw-bold w-100" readonly style="background: transparent; box-shadow: none; color: #111827; font-size: 1.1rem; padding: 0; outline: none;">
                                    <button class="btn btn-sm px-3 py-2 border-0" id="btnQtyPlus"><i class="bi bi-plus fs-5"></i></button>
                                </div>
                                <span class="text-muted small">(Max: {{ $product['total_quantity'] }})</span>
                            </div>

                            <!-- On-Site Checkout Form Section -->
                            <div class="checkout-card mt-3" id="checkoutFormSection">
                                <h3 class="mb-3 fs-5" style="font-family: var(--font-display); font-weight: 700; color: var(--text-dark);">
                                    <i class="bi bi-cart-check text-danger me-2"></i> Order Calculations
                                </h3>
                                <div class="p-3 bg-light rounded mt-1 border">
                                    <div class="d-flex justify-content-between mb-1 small text-muted">
                                        <span>Product Total:</span>
                                        <span id="checkoutProductTotal">Rs. 0.00</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1 small text-muted">
                                        <span>Shipping Cost:</span>
                                        <span id="checkoutShippingCost" class="text-success fw-bold">Free</span>
                                    </div>
                                    <div class="d-flex justify-content-between mb-1 small text-muted d-none" id="checkoutDiscountRow">
                                        <span>Multi-Buy Discount:</span>
                                        <span id="checkoutDiscount" class="text-success fw-bold">-Rs. 0.00</span>
                                    </div>
                                    <hr class="my-2">
                                    <div class="d-flex justify-content-between align-items-center">
                                        <span class="fw-bold" style="font-size: 0.88rem;">Total Amount to Pay:</span>
                                        <strong class="text-danger fs-5" id="checkoutGrandTotal">Rs. 0.00</strong>
                                    </div>
                                </div>
                                
                                <div class="mt-3">
                                    <!-- Row 1: Buy Now & Add to Cart -->
                                    <div class="d-flex gap-2 align-items-stretch w-100">
                                        <button type="button" id="btnBuyNow" class="btn btn-danger py-2 fw-bold flex-grow-1" style="background: var(--accent-gradient); border: none; border-radius: 10px; box-shadow: var(--shadow-glow); transition: var(--transition-smooth); color: #fff; font-size: 0.85rem;">
                                            <i class="bi bi-bag-check-fill me-1"></i> Buy Now (මිලදී ගන්න)
                                        </button>
                                        <button type="button" id="btnAddToCart" class="btn btn-outline-dark py-2 px-3 fw-bold" style="border-radius: 10px; border: 2px solid #374151; color: #374151; background: #fff; transition: var(--transition-smooth); display: inline-flex; align-items: center; justify-content: center; font-size: 1rem;" title="Add to Cart (කරත්තයට එකතු කරන්න)">
                                            <i class="bi bi-cart-plus-fill"></i>
                                        </button>
                                    </div>
                                    <!-- Row 2: WhatsApp & Share -->
                                    <div class="d-flex gap-2 align-items-stretch w-100 mt-2">
                                        <a href="{{ $waUrl }}" target="_blank" class="btn btn-success py-2 fw-bold flex-grow-1 d-flex align-items-center justify-content-center gap-2" style="background-color: #25d366; border: none; border-radius: 10px; transition: var(--transition-smooth); color: #fff; text-decoration: none; box-shadow: 0 4px 10px rgba(37, 211, 102, 0.2); font-size: 0.85rem;">
                                            <i class="bi bi-whatsapp"></i> WhatsApp Order
                                        </a>
                                        @php
                                            $sharePrice = !is_null($product['discounted_price']) ? $product['discounted_price'] : ($product['price'] ?? 0);
                                            $formattedSharePrice = "Rs. " . number_format((float)$sharePrice, 2);
                                        @endphp
                                        <button type="button" id="btnShareProduct" class="btn btn-outline-dark py-2 px-3 fw-bold" style="border-radius: 10px; border: 2px solid #374151; color: #374151; background: #fff; transition: var(--transition-smooth); display: inline-flex; align-items: center; justify-content: center; font-size: 1rem;" data-title="{{ $product['product_name'] }}" data-price="{{ $formattedSharePrice }}" data-url="{{ Request::url() }}" title="Share Product">
                                            <i class="bi bi-share-fill"></i>
                                        </button>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="alert alert-danger mt-3 text-center" role="alert" style="border-radius: 12px;">
                                <i class="bi bi-exclamation-triangle-fill me-2"></i> This product is currently out of stock. You can still message us on WhatsApp for pre-ordering.
                            </div>
                        @endif

                    </div>
                </div>

            </div>

            <!-- Product specifications and details -->
            <div class="details-desc-box">
                <h2 class="details-desc-title">Product Description</h2>
                <div class="details-desc-content">
                    {!! nl2br(e($product['short_description'] ?? 'No additional description is currently registered for this product. Contact customer care on WhatsApp to get detailed specifications, custom parameters, or use instructions.')) !!}
                </div>
            </div>

            <!-- Product Reviews Section -->
            <div class="details-desc-box mt-4">
                <h2 class="details-desc-title">Ratings & Reviews</h2>
                
                <div class="row g-4 p-4">
                    <!-- Rating Summary Column -->
                    <div class="col-12 col-md-4 text-center border-end">
                        <h3 style="font-size: 3rem; font-weight: 700; color: #111827; margin-bottom: 0.25rem;">{{ number_format($avgRating, 1) }}</h3>
                        <div class="d-flex justify-content-center text-warning fs-4 mb-2">
                            @for($i = 1; $i <= 5; $i++)
                                @if($i <= floor($avgRating))
                                    <i class="bi bi-star-fill me-1"></i>
                                @elseif(($i - $avgRating) <= 0.5)
                                    <i class="bi bi-star-half me-1"></i>
                                @else
                                    <i class="bi bi-star text-muted me-1"></i>
                                @endif
                            @endfor
                        </div>
                        <p class="text-muted small">Based on {{ $reviewsCount }} reviews</p>
                        
                        <!-- Star Breakdown -->
                        <div class="mt-4" style="text-align: left; max-width: 250px; margin: 0 auto;">
                            @foreach([5,4,3,2,1] as $star)
                                @php
                                    $pct = $reviewsCount > 0 ? ($ratingBreakdown[$star] / $reviewsCount) * 100 : 0;
                                @endphp
                                <div class="d-flex align-items-center mb-1" style="font-size: 0.8rem;">
                                    <span style="width: 15px; font-weight: bold;">{{ $star }}</span>
                                    <i class="bi bi-star-fill text-warning ms-1 me-2" style="font-size: 0.75rem;"></i>
                                    <div class="progress flex-grow-1" style="height: 6px;">
                                        <div class="progress-bar bg-warning" role="progressbar" style="width: {{ $pct }}%" aria-valuenow="{{ $pct }}" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <span class="text-muted ms-2" style="width: 25px; text-align: right;">{{ $ratingBreakdown[$star] }}</span>
                                </div>
                            @endforeach
                        </div>
                    </div>

                    <!-- Reviews List Column -->
                    <div class="col-12 col-md-8">
                        <!-- Review Notice -->
                        <div class="mb-4 p-3 border rounded bg-light" style="text-align: left; border-left: 4px solid #3b82f6 !important;">
                            <h4 class="fs-6 fw-bold mb-2 text-primary" style="font-family: 'Space Grotesk', sans-serif;"><i class="bi bi-info-circle-fill me-1"></i> Verified Purchase Reviews Only</h4>
                            <p class="small text-muted mb-0" style="font-family: 'Outfit', sans-serif; font-size: 0.82rem;">To ensure the authenticity of product reviews, only verified buyers can leave feedback. Once your order has been delivered, you will receive a secure review link in your email.</p>
                        </div>

                        <!-- Existing Reviews List -->
                        <h4 class="fs-6 fw-bold mb-3 border-bottom pb-2" style="text-align: left;">Customer Reviews</h4>
                        
                        <div id="reviewsListContainer" style="display: flex; flex-direction: column; gap: 1rem; max-height: 400px; overflow-y: auto; padding-right: 0.5rem; text-align: left;">
                            @if($reviews->isEmpty())
                                <p class="text-muted text-center py-4">No reviews yet for this product. Be the first to write a review!</p>
                            @else
                                @foreach($reviews as $rev)
                                    <div class="p-3 border-bottom">
                                        <div class="d-flex justify-content-between align-items-center mb-1">
                                            <strong class="text-dark" style="font-size: 0.88rem;">{{ $rev->customer_name }}</strong>
                                            <span class="text-muted" style="font-size: 0.75rem;">{{ $rev->created_at->diffForHumans() }}</span>
                                        </div>
                                        <div class="text-warning mb-2" style="font-size: 0.8rem;">
                                            @for($i = 1; $i <= 5; $i++)
                                                <i class="bi {{ $i <= $rev->rating ? 'bi-star-fill' : 'bi-star' }} me-1"></i>
                                            @endfor
                                        </div>
                                        <p class="text-secondary mb-0" style="font-size: 0.85rem; line-height: 1.5;">{{ $rev->comment }}</p>
                                    </div>
                                @endforeach
                            @endif
                        </div>
                    </div>
                </div>
            </div>

        </div>

        <!-- Related Products Section -->
        @if(isset($relatedProducts) && count($relatedProducts) > 0)
            <div class="related-section">
                <h2 class="related-section-title">
                    <i class="bi bi-grid-3x3-gap-fill" style="color: var(--accent);"></i> Related Products
                </h2>
                
                <div class="related-products-carousel">
                    @foreach($relatedProducts as $relProduct)
                        @php
                            $relImg = !empty($relProduct['images']) ? $relProduct['images'][0] : asset('images/brand.png');
                            $relWaMsg = "Hi, I am interested in ordering: {$relProduct['product_name']} (Product ID: {$relProduct['id']}). Please guide me through placing this order.";
                            $relWaUrl = "https://wa.me/94706050500?text=" . urlencode($relWaMsg);
                        @endphp
                        
                        <a href="{{ route('products.publicDetails', ['id' => $relProduct['id'], 'slug' => \Illuminate\Support\Str::slug($relProduct['product_name'])]) }}" class="related-card">
                            <div class="related-card-media">
                                @if($relProduct['has_discount'] && $relProduct['discount_percentage'] > 0)
                                    <span class="related-discount-badge">-{{ $relProduct['discount_percentage'] }}% OFF</span>
                                @endif
                                <img src="{{ $relImg }}" alt="{{ $relProduct['product_name'] }}" loading="lazy">
                            </div>
                            
                            <div class="related-card-content">
                                <h3 class="related-card-title">{{ $relProduct['product_name'] }}</h3>
                                
                                <div class="related-card-prices">
                                    <span class="related-price-now">Rs. {{ number_format($relProduct['discounted_price'] ?? $relProduct['price'], 0) }}</span>
                                    @if($relProduct['has_discount'] && $relProduct['price'] > 0)
                                        <span class="related-price-old">Rs. {{ number_format($relProduct['price'], 0) }}</span>
                                    @endif
                                </div>
                            </div>
                            
                            <div class="related-card-footer">
                                @if(($relProduct['total_quantity'] ?? 0) > 0)
                                    <span class="related-qty-status"><i class="bi bi-check-circle-fill"></i> In Stock ({{ $relProduct['total_quantity'] }})</span>
                                @else
                                    <span class="related-qty-status out"><i class="bi bi-x-circle-fill"></i> Out of Stock</span>
                                @endif
                                
                                <div style="display: flex; gap: 6px; align-items: center;">
                                    @if(($relProduct['total_quantity'] ?? 0) > 0)
                                        <span class="btn-related-cart js-btn-related-cart" 
                                              data-id="{{ $relProduct['id'] }}"
                                              data-stock-id="{{ $relProduct['best_stock_id'] ?? '' }}"
                                              data-name="{{ $relProduct['product_name'] }}"
                                              data-price="{{ $relProduct['discounted_price'] ?? $relProduct['price'] }}"
                                              data-image="{{ $relImg }}"
                                              data-max-qty="{{ $relProduct['total_quantity'] ?? 999 }}">
                                            <i class="bi bi-cart-plus"></i>
                                        </span>
                                    @endif
                                    <span class="btn-related-wa js-btn-related-wa" data-url="{{ $relWaUrl }}">
                                        <i class="bi bi-whatsapp"></i>
                                    </span>
                                </div>
                            </div>
                        </a>
                    @endforeach
                </div>
            </div>
        @endif

    </div>
@endsection

@section('scripts')
    @php
        $courierShipping = $shippings->firstWhere('type', 'Courier');
        $courierCharge = $courierShipping ? $courierShipping->amount : 350.00;
    @endphp
    <script>
        function showShareToast(message) {
            let toast = document.createElement('div');
            toast.className = 'share-toast';
            toast.innerHTML = `<i class="bi bi-check-circle-fill text-success"></i> ${message}`;
            document.body.appendChild(toast);
            setTimeout(() => {
                toast.classList.add('show');
            }, 50);
            setTimeout(() => {
                toast.classList.remove('show');
                setTimeout(() => toast.remove(), 400);
            }, 2500);
        }

        function updatePreviewImage(src, element) {
            // Hide video container and clear src
            const videoCont = document.getElementById('videoPreviewContainer');
            if (videoCont) {
                videoCont.classList.add('d-none');
                document.getElementById('ytPlayerFrame').src = '';
            }

            // Show main image / placeholder
            const previewImg = document.getElementById('mainProductPreview');
            if (previewImg) {
                previewImg.classList.remove('d-none');
                previewImg.src = src;
            }
            const placeholder = document.getElementById('mainProductPlaceholder');
            if (placeholder) {
                placeholder.classList.remove('d-none');
            }

            // Manage thumbnail visual state
            const items = document.querySelectorAll('.thumb-item');
            items.forEach(function(item) {
                item.classList.remove('active');
            });
            element.classList.add('active');
        }

        function updatePreviewToVideo(videoId, element) {
            // Hide main image / placeholder
            const previewImg = document.getElementById('mainProductPreview');
            if (previewImg) {
                previewImg.classList.add('d-none');
            }
            const placeholder = document.getElementById('mainProductPlaceholder');
            if (placeholder) {
                placeholder.classList.add('d-none');
            }

            // Show video container and load iframe src
            const videoCont = document.getElementById('videoPreviewContainer');
            if (videoCont) {
                videoCont.classList.remove('d-none');
                document.getElementById('ytPlayerFrame').src = 'https://www.youtube.com/embed/' + videoId + '?autoplay=1&mute=0';
            }

            // Manage thumbnail visual state
            const items = document.querySelectorAll('.thumb-item');
            items.forEach(function(item) {
                item.classList.remove('active');
            });
            element.classList.add('active');
        }

        document.addEventListener('DOMContentLoaded', function() {
            // Click image thumbnail
            $(document).on('click', '.js-gallery-thumb', function() {
                const src = $(this).attr('data-src') || $(this).data('src');
                updatePreviewImage(src, this);
            });

            // Click video thumbnail
            $(document).on('click', '.js-video-thumb', function() {
                const videoId = $(this).attr('data-video-id') || $(this).data('video-id');
                updatePreviewToVideo(videoId, this);
            });

            // Click WhatsApp button in related products
            $(document).on('click', '.js-btn-related-wa', function(e) {
                e.preventDefault();
                e.stopPropagation();
                const url = $(this).attr('data-url') || $(this).data('url');
                window.open(url, '_blank');
            });

            // Click Add to Cart button in related products
            $(document).on('click', '.js-btn-related-cart', function(e) {
                e.preventDefault();
                e.stopPropagation();
                
                const productId = parseInt($(this).attr('data-id'));
                const stockId = $(this).attr('data-stock-id') ? parseInt($(this).attr('data-stock-id')) : null;
                const productName = $(this).attr('data-name');
                const sellingPrice = parseFloat($(this).attr('data-price'));
                const image = $(this).attr('data-image');
                const maxQty = $(this).attr('data-max-qty') ? parseInt($(this).attr('data-max-qty')) : 999;
                
                if (window.addToCart) {
                    window.addToCart({
                        product_id: productId,
                        stock_id: stockId,
                        product_name: productName,
                        selling_price: sellingPrice,
                        quantity: 1,
                        image: image,
                        max_qty: maxQty
                    });
                }
            });

            // Media navigation function (Prev / Next)
            function navigateMedia(direction) {
                const thumbItems = $('.thumb-strip .thumb-item');
                if (!thumbItems.length) return;

                let activeIndex = thumbItems.index($('.thumb-strip .thumb-item.active'));
                if (activeIndex === -1) activeIndex = 0;

                let targetIndex;
                if (direction === 'next') {
                    targetIndex = (activeIndex + 1) % thumbItems.length;
                } else {
                    targetIndex = (activeIndex - 1 + thumbItems.length) % thumbItems.length;
                }

                const targetThumb = thumbItems.eq(targetIndex);
                targetThumb.trigger('click');

                // Smoothly scroll active thumbnail into view
                const strip = document.querySelector('.thumb-strip');
                if (strip && targetThumb[0]) {
                    const stripWidth = strip.clientWidth;
                    const thumbLeft = targetThumb[0].offsetLeft;
                    const thumbWidth = targetThumb[0].clientWidth;

                    strip.scrollTo({
                        left: thumbLeft - (stripWidth / 2) + (thumbWidth / 2),
                        behavior: 'smooth'
                    });
                }
            }

            $(document).on('click', '#btnPreviewPrev', function(e) {
                e.preventDefault();
                e.stopPropagation();
                navigateMedia('prev');
            });

            $(document).on('click', '#btnPreviewNext', function(e) {
                e.preventDefault();
                e.stopPropagation();
                navigateMedia('next');
            });

            // Touch swipe gesture support for mobile preview box
            const previewBox = document.querySelector('.main-preview-box');
            if (previewBox) {
                let touchStartX = 0;
                let touchEndX = 0;

                previewBox.addEventListener('touchstart', function(e) {
                    touchStartX = e.changedTouches[0].screenX;
                }, { passive: true });

                previewBox.addEventListener('touchend', function(e) {
                    touchEndX = e.changedTouches[0].screenX;
                    const swipeThreshold = 45;
                    if (touchEndX < touchStartX - swipeThreshold) {
                        navigateMedia('next');
                    } else if (touchEndX > touchStartX + swipeThreshold) {
                        navigateMedia('prev');
                    }
                }, { passive: true });
            }

            // Click Share Product Button (Includes Product Name, Price, and Link)
            $(document).on('click', '#btnShareProduct', async function() {
                const title = $(this).attr('data-title') || $(this).data('title');
                const price = $(this).attr('data-price') || $(this).data('price');
                const url = $(this).attr('data-url') || $(this).data('url') || window.location.href;

                const shareTitle = `${title} (${price}) | Loku Kade`;
                const shareText = `Check out "${title}" on Loku Kade!\n💰 Price: ${price}\n🚚 Free Shipping & Cash on Delivery Island-wide`;

                if (navigator.share) {
                    try {
                        await navigator.share({
                            title: shareTitle,
                            text: shareText,
                            url: url
                        });
                    } catch (error) {
                        if (error.name !== 'AbortError') {
                            console.log('Error sharing product', error);
                        }
                    }
                } else {
                    // Fallback: Copy product name, price, and URL to clipboard
                    const copyContent = `Check out "${title}" on Loku Kade!\n💰 Price: ${price}\n🚚 Free Shipping & Cash on Delivery Island-wide\n🔗 Order Now: ${url}`;
                    if (navigator.clipboard && window.isSecureContext) {
                        navigator.clipboard.writeText(copyContent).then(() => {
                            showShareToast('Product details & link copied to clipboard!');
                        }).catch(() => {
                            fallbackCopy(copyContent);
                        });
                    } else {
                        fallbackCopy(copyContent);
                    }
                }
            });

            function fallbackCopy(text) {
                const tempInput = document.createElement('textarea');
                tempInput.value = text;
                tempInput.style.position = 'fixed';
                tempInput.style.left = '-9999px';
                document.body.appendChild(tempInput);
                tempInput.focus();
                tempInput.select();
                try {
                    document.execCommand('copy');
                    showShareToast('Product details & link copied to clipboard!');
                } catch (err) {
                    showShareToast('Link copied to clipboard!');
                }
                document.body.removeChild(tempInput);
            }

            @if(empty($product['images']) && !empty($ytVideoId))
                setTimeout(function() {
                    const videoThumb = document.querySelector('.js-video-thumb');
                    if (videoThumb) {
                        videoThumb.click();
                    }
                }, 100);
            @endif

            // --- QUANTITY SELECTOR & CHECKOUT CALCULATION LOGIC ---
            const singleUnitPrice = parseFloat("{{ $product['discounted_price'] ?? $product['price'] ?? 0 }}");
            const courierCharge = parseFloat("{{ $courierCharge }}");
            const inputQuantity = $('#inputQuantity');
            const formQtyVal = $('#formQtyVal');
            const checkoutProductTotal = $('#checkoutProductTotal');
            const checkoutShippingCost = $('#checkoutShippingCost');
            const checkoutDiscount = $('#checkoutDiscount');
            const checkoutDiscountRow = $('#checkoutDiscountRow');
            const checkoutGrandTotal = $('#checkoutGrandTotal');

            function updateCheckoutSummary() {
                const qty = parseInt(inputQuantity.val()) || 1;
                formQtyVal.val(qty);
                
                // Update item quantity in checkout form request payload structure
                $('input[name="items[0][quantity]"]').val(qty);

                const productTotal = qty * singleUnitPrice;
                checkoutProductTotal.text('Rs. ' + productTotal.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));

                // Shipping is free
                checkoutShippingCost.text('Free');

                // Calculate multi-buy discount: courierCharge * (qty - 1)
                let discount = 0;
                if (qty > 1) {
                    discount = courierCharge * (qty - 1);
                    checkoutDiscountRow.removeClass('d-none');
                    checkoutDiscount.text('-Rs. ' + discount.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
                } else {
                    checkoutDiscountRow.addClass('d-none');
                }

                const grandTotal = Math.max(0, productTotal - discount);
                checkoutGrandTotal.text('Rs. ' + grandTotal.toLocaleString(undefined, { minimumFractionDigits: 2, maximumFractionDigits: 2 }));
            }

            $('#btnQtyPlus').on('click', function() {
                const max = parseInt(inputQuantity.attr('max')) || 999;
                let current = parseInt(inputQuantity.val()) || 1;
                if (current < max) {
                    inputQuantity.val(current + 1);
                    updateCheckoutSummary();
                } else {
                    if (typeof Swal !== 'undefined') {
                        Swal.fire({
                            title: 'Stock Limit',
                            text: 'Only ' + max + ' item' + (max > 1 ? 's' : '') + ' available in stock for this product.',
                            icon: 'warning',
                            confirmButtonColor: '#e12a1a',
                            background: '#fffcf9',
                            color: '#111827'
                        });
                    } else {
                        alert('Only ' + max + ' items available in stock.');
                    }
                }
            });

            $('#btnQtyMinus').on('click', function() {
                let current = parseInt(inputQuantity.val()) || 1;
                if (current > 1) {
                    inputQuantity.val(current - 1);
                    updateCheckoutSummary();
                }
            });

            // Bind Add to Cart action
            $('#btnAddToCart').on('click', function() {
                const qty = parseInt(inputQuantity.val()) || 1;
                const product = {
                    product_id: parseInt("{{ $product['id'] }}"),
                    stock_id: parseInt("{{ $product['best_stock_id'] }}") || null,
                    product_name: {!! json_encode($product['product_name']) !!},
                    selling_price: parseFloat("{{ $product['discounted_price'] ?? $product['price'] ?? 0 }}"),
                    quantity: qty,
                    image: "{{ $product['main_image_url'] ?? ($product['images'][0] ?? null) }}",
                    max_qty: parseInt("{{ $product['total_quantity'] ?? 999 }}")
                };
                if (typeof window.addToCart === 'function') {
                    window.addToCart(product);
                } else {
                    console.error('addToCart function is not defined globally.');
                }
            });

            // Bind Buy Now action
            $('#btnBuyNow').on('click', function() {
                const qty = parseInt(inputQuantity.val()) || 1;
                const product = {
                    product_id: parseInt("{{ $product['id'] }}"),
                    stock_id: parseInt("{{ $product['best_stock_id'] }}") || null,
                    product_name: {!! json_encode($product['product_name']) !!},
                    selling_price: parseFloat("{{ $product['discounted_price'] ?? $product['price'] ?? 0 }}"),
                    quantity: qty,
                    image: "{{ $product['main_image_url'] ?? ($product['images'][0] ?? null) }}",
                    max_qty: parseInt("{{ $product['total_quantity'] ?? 999 }}")
                };
                
                if (typeof window.addToCart === 'function') {
                    // Add silently without opening the drawer, then navigate to checkout
                    window.addToCart(product, false);
                    window.location.href = '{{ url("/checkout") }}';
                } else {
                    window.location.href = '{{ url("/checkout") }}';
                }
            });

            // Initial summary calculation
            updateCheckoutSummary();

            // Star rating click handler in form
            $('.js-star-btn').on('click', function() {
                const val = $(this).data('value');
                $('#reviewRatingVal').val(val);
                $('.js-star-btn').each(function() {
                    const starVal = $(this).data('value');
                    if (starVal <= val) {
                        $(this).removeClass('bi-star text-muted').addClass('bi-star-fill text-warning');
                    } else {
                        $(this).removeClass('bi-star-fill text-warning').addClass('bi-star text-muted');
                    }
                });
            });

            // Review Form submit handler
            $('#reviewSubmitForm').on('submit', async function(e) {
                e.preventDefault();
                
                const form = $(this);
                const url = form.attr('action');
                const rating = $('#reviewRatingVal').val();
                
                if (!rating) {
                    alert('Please select a rating star count.');
                    return;
                }

                try {
                    const response = await $.ajax({
                        url: url,
                        type: 'POST',
                        data: form.serialize(),
                    });

                    if (response.success) {
                        form.trigger('reset');
                        // Reset star icons
                        $('.js-star-btn').removeClass('bi-star-fill text-warning').addClass('bi-star text-muted');
                        $('#reviewRatingVal').val('');
                        
                        // Append new review to list container
                        const newReviewHtml = 
                            '<div class="p-3 border-bottom">' +
                                '<div class="d-flex justify-content-between align-items-center mb-1">' +
                                    '<strong class="text-dark" style="font-size: 0.88rem;">' + response.review.customer_name + '</strong>' +
                                    '<span class="text-muted" style="font-size: 0.75rem;">' + response.review.created_at + '</span>' +
                                '</div>' +
                                '<div class="text-warning mb-2" style="font-size: 0.8rem;">' +
                                    Array.from({length: 5}, (_, i) => '<i class="bi ' + (i < response.review.rating ? 'bi-star-fill' : 'bi-star') + ' me-1"></i>').join('') +
                                '</div>' +
                                '<p class="text-secondary mb-0" style="font-size: 0.85rem; line-height: 1.5;">' + (response.review.comment || '') + '</p>' +
                            '</div>';
                        
                        // Remove empty placeholder if any
                        if ($('#reviewsListContainer p.text-center').length) {
                            $('#reviewsListContainer').empty();
                        }
                        $('#reviewsListContainer').prepend(newReviewHtml);
                        
                        // Show success alert
                        $('#reviewSuccessMsg').text(response.message).removeClass('d-none');
                        setTimeout(() => $('#reviewSuccessMsg').addClass('d-none'), 5000);
                    }
                } catch (error) {
                    alert('Failed to submit review. Please try again.');
                }
            });
        });
    </script>
@endsection
