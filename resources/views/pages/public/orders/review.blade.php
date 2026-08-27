@extends('layouts.frontend')

@section('title', 'Leave a Review - Loku Kade')

@section('styles')
<style>
    .review-page-wrapper {
        padding: 85px 0 90px;
        background-color: #f4f5f7;
        min-height: 100vh;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }
    .review-card {
        background: #ffffff;
        border: 1px solid #f0f0f0;
        border-radius: 18px;
        box-shadow: 0 2px 10px rgba(0,0,0,0.03);
        padding: 1.75rem;
    }
    @media (max-width: 767.98px) {
        .review-page-wrapper {
            padding: 80px 0 85px;
        }
        .review-card {
            padding: 1.25rem;
            border-radius: 14px;
        }
    }
    .product-review-item {
        background: #fafafa;
        border: 1px solid #f0f0f0;
        border-radius: 14px;
        padding: 1.25rem;
        margin-bottom: 1.25rem;
    }
    .star-rating-btn {
        font-size: 1.85rem;
        color: #e5e7eb;
        cursor: pointer;
        transition: transform 0.15s ease, color 0.15s ease;
    }
    .star-rating-btn:hover {
        transform: scale(1.1);
    }
    .star-rating-btn.active {
        color: #f59e0b;
    }
    .star-rating-btn.disabled {
        cursor: default;
        transform: none;
    }
    .btn-save-review {
        background: #ff1944;
        color: #ffffff;
        border: none;
        border-radius: 12px;
        font-size: 1rem;
        font-weight: 800;
        padding: 12px 24px;
        width: 100%;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 8px;
        box-shadow: 0 4px 14px rgba(255, 25, 68, 0.25);
        transition: all 0.2s ease;
    }
    .btn-save-review:hover {
        background: #e5002b;
        transform: translateY(-1px);
        box-shadow: 0 6px 18px rgba(255, 25, 68, 0.35);
        color: #ffffff;
    }
    .btn-save-review:active {
        transform: scale(0.98);
    }
</style>
@endsection

@section('content')
<div class="review-page-wrapper">
    <div class="container" style="max-width: 680px;">
        
        <!-- Header Top Back Navigation -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ route('profile') }}" class="btn btn-sm btn-light border fw-bold text-dark px-3 py-2" style="border-radius: 20px; font-size: 0.82rem;">
                <i class="bi bi-chevron-left"></i> Back to Dashboard
            </a>
            <span class="badge bg-danger px-3 py-2 rounded-pill fw-bold" style="font-size: 0.75rem; letter-spacing: 0.3px;">
                Verified Purchase
            </span>
        </div>

        <div class="review-card">
            <div class="text-center mb-4">
                <h1 style="font-size: 1.45rem; font-weight: 800; color: #111827; margin-bottom: 0.25rem;">
                    Review Your Purchase
                </h1>
                <p class="text-muted small mb-0">For Order #{{ $order->order_number }}</p>
            </div>

            @if(session('success'))
                <div class="alert alert-success alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; font-weight: 600;">
                    <i class="bi bi-check-circle-fill me-2"></i> {{ session('success') }}
                    <div class="mt-2">
                        <a href="{{ route('profile') }}" class="btn btn-sm btn-success fw-bold px-3 py-1" style="border-radius: 8px;">
                            View My Reviews <i class="bi bi-arrow-right"></i>
                        </a>
                    </div>
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(session('error'))
                <div class="alert alert-danger alert-dismissible fade show mb-4" role="alert" style="border-radius: 12px; font-weight: 600;">
                    <i class="bi bi-exclamation-triangle-fill me-2"></i> {{ session('error') }}
                    <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
                </div>
            @endif

            @if(!$isEditable)
                <div class="alert alert-warning mb-4" role="alert" style="border-radius: 12px; border-left: 4px solid #f59e0b !important;">
                    <h5 class="alert-heading fw-bold" style="font-size: 0.92rem;"><i class="bi bi-lock-fill me-1"></i> Reviews are Locked</h5>
                    <p class="small mb-0">{{ $editRestrictionMessage }} You can view your submitted feedback below.</p>
                </div>
            @endif

            <form action="{{ route('orders.submitReviews', $order->secure_token) }}" method="POST" id="reviewsForm">
                @csrf
                
                @foreach($order->details as $item)
                    @php
                        $product = \App\Models\Product::find($item->product_id);
                        $review = $existingReviews->get($item->product_id);
                        $ratingVal = $review ? $review->rating : 5; // Default 5 stars for convenience
                        $commentVal = $review ? $review->comment : '';
                    @endphp
                    
                    <div class="product-review-item">
                        <div class="d-flex align-items-center gap-3 mb-3">
                            @if($product && $product->main_image_url)
                                <img src="{{ $product->main_image_url }}" alt="{{ $item->product_name }}" style="width: 62px; height: 62px; object-fit: cover; border-radius: 10px; border: 1px solid #e5e7eb; background: #fff;">
                            @else
                                <div style="width: 62px; height: 62px; border-radius: 10px; background-color: #e5e7eb; display: flex; align-items: center; justify-content: center; color: #9ca3af;"><i class="bi bi-box-seam fs-4"></i></div>
                            @endif
                            <div style="min-width: 0; flex: 1;">
                                <h3 style="font-size: 0.95rem; font-weight: 800; color: #111827; margin: 0 0 2px 0; line-height: 1.3;">{{ $item->product_name }}</h3>
                                <span class="text-muted small">Qty Purchased: {{ $item->quantity }}</span>
                            </div>
                        </div>

                        <!-- Rating Stars Input -->
                        <div class="mb-3">
                            <label class="form-label small fw-bold text-dark d-block mb-1">
                                Your Rating <span class="text-danger">*</span>
                            </label>
                            <div class="d-flex align-items-center gap-2 star-container" data-product-id="{{ $item->product_id }}">
                                @for($i = 1; $i <= 5; $i++)
                                    <i class="bi bi-star-fill star-rating-btn {{ $i <= $ratingVal ? 'active' : '' }} {{ !$isEditable ? 'disabled' : '' }}" data-value="{{ $i }}"></i>
                                @endfor
                                <input type="hidden" name="ratings[{{ $item->product_id }}]" class="rating-input-field" value="{{ $ratingVal }}" required>
                                <span class="ms-2 small fw-bold text-muted rating-text-preview" id="ratingLabel_{{ $item->product_id }}">
                                    {{ $ratingVal == 5 ? '5/5 (Excellent)' : $ratingVal . '/5' }}
                                </span>
                            </div>
                        </div>

                        <!-- Comment Textarea -->
                        <div class="mb-1">
                            <label for="comment_{{ $item->product_id }}" class="form-label small fw-bold text-dark mb-1">Review Comment</label>
                            <textarea name="comments[{{ $item->product_id }}]" 
                                      id="comment_{{ $item->product_id }}" 
                                      rows="3" 
                                      class="form-control" 
                                      style="border-radius: 10px; font-size: 0.9rem; border: 1.5px solid #e5e7eb;" 
                                      placeholder="Tell us what you think about this item (quality, packaging, delivery)..." 
                                      {{ !$isEditable ? 'disabled' : '' }}>{{ $commentVal }}</textarea>
                        </div>
                    </div>
                @endforeach

                @if($isEditable)
                    <div class="mt-4">
                        <button type="submit" class="btn-save-review" id="btnSubmitReviews">
                            <i class="bi bi-check2-circle fs-5"></i> Save & Submit Review
                        </button>
                    </div>
                @endif
            </form>
        </div>
    </div>
</div>
@endsection

@section('scripts')
@if($isEditable)
<script>
    document.addEventListener('DOMContentLoaded', function() {
        const starContainers = document.querySelectorAll('.star-container');
        const ratingDescriptions = {
            1: '1/5 (Very Poor)',
            2: '2/5 (Poor)',
            3: '3/5 (Average)',
            4: '4/5 (Good)',
            5: '5/5 (Excellent)'
        };
        
        starContainers.forEach(container => {
            const stars = container.querySelectorAll('.star-rating-btn');
            const input = container.querySelector('.rating-input-field');
            const label = container.querySelector('.rating-text-preview');
            
            stars.forEach(star => {
                // Hover highlights
                star.addEventListener('mouseover', function() {
                    const val = parseInt(this.getAttribute('data-value'));
                    stars.forEach(s => {
                        const sVal = parseInt(s.getAttribute('data-value'));
                        if (sVal <= val) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                    if (label) label.textContent = ratingDescriptions[val] || val + '/5';
                });
                
                // Reset to active selected rating on mouseout
                star.addEventListener('mouseout', function() {
                    const currentVal = parseInt(input.value) || 0;
                    stars.forEach(s => {
                        const sVal = parseInt(s.getAttribute('data-value'));
                        if (sVal <= currentVal) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                    if (label) label.textContent = ratingDescriptions[currentVal] || (currentVal > 0 ? currentVal + '/5' : 'Select rating');
                });
                
                // Click selects rating
                star.addEventListener('click', function() {
                    const val = parseInt(this.getAttribute('data-value'));
                    input.value = val;
                    stars.forEach(s => {
                        const sVal = parseInt(s.getAttribute('data-value'));
                        if (sVal <= val) {
                            s.classList.add('active');
                        } else {
                            s.classList.remove('active');
                        }
                    });
                    if (label) label.textContent = ratingDescriptions[val] || val + '/5';
                });
            });
        });

        // Form submission safety
        document.getElementById('reviewsForm').addEventListener('submit', function(e) {
            const ratings = document.querySelectorAll('.rating-input-field');
            let allValid = true;
            ratings.forEach(r => {
                if (!r.value || parseInt(r.value) < 1) {
                    allValid = false;
                }
            });

            if (!allValid) {
                e.preventDefault();
                alert('Please select a star rating (1-5 stars) before submitting.');
                return false;
            }

            const submitBtn = document.getElementById('btnSubmitReviews');
            if (submitBtn) {
                submitBtn.disabled = true;
                submitBtn.innerHTML = '<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Saving Reviews...';
            }
        });
    });
</script>
@endif
@endsection
