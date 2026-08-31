@extends('layouts.frontend')

@section('title', 'Flash Sale - Loku Kade')

@section('content')
<style>
    .deals-page-wrapper {
        margin-top: 110px;
        padding-bottom: 5rem;
        background-color: transparent;
    }
    @media (max-width: 767.98px) {
        .deals-page-wrapper { margin-top: 100px !important; padding-bottom: 2rem; }
    }
    .deals-title-area {
        text-align: center;
        margin-bottom: 2.5rem;
        padding: 3.5rem 1.5rem;
        background: linear-gradient(rgba(0, 0, 0, 0.25), rgba(0, 0, 0, 0.45)), url('{{ asset('assets/images/flash_deals_banner.webp') }}') no-repeat center center;
        background-size: cover;
        border: none;
        border-radius: 24px;
        box-shadow: 0 10px 30px rgba(239, 68, 68, 0.25);
        color: #ffffff;
        position: relative;
        overflow: hidden;
    }
    .deals-title-area::before {
        content: '';
        position: absolute;
        top: -50%;
        left: -30%;
        width: 100%;
        height: 200%;
        background: radial-gradient(circle, rgba(255,255,255,0.15) 0%, rgba(255,255,255,0) 70%);
        transform: rotate(30deg);
        pointer-events: none;
    }
    .deals-title-area h1 {
        font-family: 'Space Grotesk', sans-serif;
        font-size: 2.8rem;
        font-weight: 800;
        color: #ffffff;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: center;
        gap: 12px;
        text-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    .deals-title-area p {
        color: rgba(255, 255, 255, 0.9) !important;
        font-size: 1.1rem;
        font-weight: 500;
        max-width: 600px;
        margin: 0 auto;
    }
    @media (max-width: 767.98px) {
        .deals-title-area {
            padding: 2rem 1rem !important;
            margin-bottom: 1.5rem !important;
            border-radius: 16px !important;
        }
        .deals-title-area h1 {
            font-size: 1.8rem !important;
            margin-bottom: 0.4rem !important;
        }
        .deals-title-area p {
            font-size: 0.88rem !important;
        }
    }
</style>

<div class="deals-page-wrapper">
    <div class="container">
        
        <!-- Deals Title Banner -->
        <div class="shop-banner-container mb-4">
            <style>
                .shop-banner-img {
                    width: 100%;
                    height: auto;
                    max-height: 280px;
                    object-fit: cover;
                    object-position: center;
                    box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
                    border: 1px solid #e5e7eb;
                }
                @media (max-width: 767.98px) {
                    .shop-banner-img {
                        height: auto !important;
                    }
                }
            </style>
            <img src="{{ asset('assets/images/flash_deals_banner.webp') }}" alt="Loku Kade Flash Sale Banner" class="shop-banner-img rounded">
        </div>

        @if(empty($products) || count($products) === 0)
            <div class="text-center py-5">
                <i class="bi bi-emoji-frown fs-1 text-muted d-block mb-3"></i>
                <h3 class="fw-bold">No active flash deals right now</h3>
                <p class="text-muted">Check back soon for new discounts and promotions!</p>
                <a href="{{ route('products.shop') }}" class="btn btn-danger mt-3 px-4 py-2" style="border-radius: 8px; font-weight: 600; font-family: 'Space Grotesk', sans-serif;">Browse Products</a>
            </div>
        @else
            <!-- Products Grid -->
            <div class="products-grid">
                @foreach($products as $product)
                    @php
                        $image = $product['main_image_url'] ?? ($product['images'][0] ?? null);
                        $inStock = ($product['total_quantity'] ?? 0) > 0;
                        $avg = (float) ($product['avg_rating'] ?? 0);
                        $count = (int) ($product['reviews_count'] ?? 0);
                    @endphp
                    <article class="product-card js-card" data-id="{{ $product['id'] }}" data-url="{{ route('products.publicDetails', ['id' => $product['id'], 'slug' => \Illuminate\Support\Str::slug($product['product_name'])]) }}">
                        <div class="product-media">
                            <span class="discount-tag" style="background: #ef4444;">-{{ $product['discount_percentage'] }}% Off</span>

                            @if($image)
                                <img src="{{ $image }}" alt="{{ $product['product_name'] }}" class="product-thumb" loading="lazy" decoding="async">
                            @else
                                <div class="text-secondary"><i class="bi bi-image fs-1"></i></div>
                            @endif
                        </div>

                        <div class="product-body">
                            <h2 class="product-title">{{ $product['product_name'] }}</h2>

                            <div class="product-price-section">
                                <span class="sale-price">Rs. {{ number_format($product['discounted_price'], 2) }}</span>
                                <span class="regular-price">Rs. {{ number_format($product['price'], 2) }}</span>
                                <span class="savings-tag">Save Rs. {{ number_format($product['discount_amount'], 2) }}</span>
                            </div>

                            <!-- Ratings, Reviews & Sales Volume -->
                            <div class="product-rating d-flex align-items-center gap-2 mt-1 mb-2" style="font-size: 0.78rem; color: #6b7280; flex-wrap: wrap;">
                                @if(($product['sales_volume'] ?? 0) > 0)
                                    <span class="text-secondary fw-bold" style="background: #f3f4f6; padding: 2px 6px; border-radius: 4px;">{{ $product['sales_volume'] }} sold</span>
                                    <span class="text-muted">|</span>
                                @endif
                                @if($count > 0)
                                    <span class="fw-bold text-dark">{{ number_format($avg, 1) }}</span>
                                    <div class="d-flex align-items-center text-warning">
                                        @for($i = 1; $i <= 5; $i++)
                                            @if($i <= floor($avg))
                                                <i class="bi bi-star-fill" style="margin-right: 1px;"></i>
                                            @elseif(($i - $avg) <= 0.5)
                                                <i class="bi bi-star-half" style="margin-right: 1px;"></i>
                                            @else
                                                <i class="bi bi-star text-muted" style="margin-right: 1px;"></i>
                                            @endif
                                        @endfor
                                    </div>
                                    <span>({{ $count }})</span>
                                @else
                                    <div class="d-flex align-items-center text-muted">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi bi-star" style="margin-right: 1px;"></i>
                                        @endfor
                                    </div>
                                    <span>(0)</span>
                                @endif
                            </div>

                            <div class="product-card-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 12px; border-top: 1px solid #f3f4f6;">
                                <div class="product-status-badge">
                                    @if($inStock)
                                        <span class="stock-badge-green" style="font-size: 0.72rem; padding: 2px 6px; font-weight: 600; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
                                            <i class="bi bi-check-circle-fill" style="color: #10b981; font-size: 0.65rem;"></i> In Stock ({{ $p['total_quantity'] }})
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
        @endif
    </div>
</div>
@endsection

@section('scripts')
    <script>
        $(function() {
            // Product card redirect
            $('.js-card').on('click', function(e) {
                if ($(e.target).closest('.order-btn, .js-add-to-cart-btn').length === 0) {
                    const url = $(this).data('url') || ('{{ url("/shop/product") }}/' + $(this).data('id'));
                    window.location.href = url;
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
        });
    </script>
@endsection
