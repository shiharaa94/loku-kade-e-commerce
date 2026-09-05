@extends('layouts.frontend')

@section('title', 'Track Order #' . $order->order_number . ' - Loku Kade')

@section('styles')
<style>
    .track-page-wrapper {
        padding: 90px 0 95px;
        background-color: #f4f5f7;
        min-height: 100vh;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }
    @media (max-width: 767.98px) {
        .track-page-wrapper {
            padding: 85px 0 90px;
        }
    }
    .track-card {
        background: #ffffff;
        border: 1px solid #edf2f7;
        border-radius: 20px;
        box-shadow: 0 4px 20px rgba(0, 0, 0, 0.04);
        padding: 2rem;
        margin-bottom: 1.5rem;
    }
    @media (max-width: 767.98px) {
        .track-card {
            padding: 1.25rem;
            border-radius: 16px;
        }
    }
    
    /* Provider Header Banner */
    .provider-banner {
        background: #fafbfc;
        border: 1px solid #e2e8f0;
        border-radius: 14px;
        padding: 14px 18px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 12px;
        margin-bottom: 1.5rem;
    }
    .provider-title {
        font-size: 0.95rem;
        font-weight: 800;
        color: #111827;
        margin: 0 0 2px 0;
        display: flex;
        align-items: center;
        gap: 6px;
    }
    .provider-tracking-no {
        font-size: 0.82rem;
        font-weight: 600;
        color: #475569;
    }
    .btn-external-track {
        background: #ffffff;
        color: #0f172a;
        border: 1.5px solid #cbd5e1;
        padding: 6px 12px;
        border-radius: 10px;
        font-size: 0.78rem;
        font-weight: 700;
        text-decoration: none;
        display: inline-flex;
        align-items: center;
        gap: 5px;
        transition: all 0.2s;
    }
    .btn-external-track:hover {
        background: #f1f5f9;
        color: #ff1944;
        border-color: #ff1944;
    }

    /* Live Vertical Timeline */
    .live-timeline {
        position: relative;
        padding-left: 28px;
        margin: 1.5rem 0;
    }
    .live-timeline::before {
        content: '';
        position: absolute;
        top: 8px;
        bottom: 8px;
        left: 9px;
        width: 2px;
        background: #e2e8f0;
    }
    .timeline-item {
        position: relative;
        margin-bottom: 1.25rem;
    }
    .timeline-item:last-child {
        margin-bottom: 0;
    }
    .timeline-item-dot {
        position: absolute;
        left: -28px;
        top: 2px;
        width: 20px;
        height: 20px;
        border-radius: 50%;
        background: #ffffff;
        border: 3px solid #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        z-index: 2;
    }
    .timeline-item:first-child .timeline-item-dot {
        border-color: #22c55e;
        background: #22c55e;
        box-shadow: 0 0 0 3px rgba(34, 197, 94, 0.2);
    }
    .timeline-content {
        background: #f8fafc;
        border: 1px solid #f1f5f9;
        border-radius: 12px;
        padding: 10px 14px;
    }
    .timeline-item:first-child .timeline-content {
        background: #f0fdf4;
        border-color: #dcfce7;
    }
    .timeline-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 6px;
        margin-bottom: 3px;
    }
    .timeline-status {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0;
    }
    .timeline-item:first-child .timeline-status {
        color: #15803d;
    }
    .timeline-time {
        font-size: 0.75rem;
        color: #64748b;
        font-weight: 500;
    }
    .timeline-meta {
        font-size: 0.78rem;
        color: #475569;
        display: flex;
        align-items: center;
        gap: 10px;
        flex-wrap: wrap;
    }
    .badge-loc {
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 1px 6px;
        border-radius: 6px;
        font-size: 0.72rem;
        font-weight: 600;
    }

    /* Standard Step Stepper */
    .stepper-container {
        display: flex;
        justify-content: space-between;
        position: relative;
        margin: 2rem 0;
        padding: 0 10px;
    }
    .stepper-container::before {
        content: '';
        position: absolute;
        top: 20px;
        left: 40px;
        right: 40px;
        height: 3px;
        background: #e2e8f0;
        z-index: 1;
    }
    .stepper-progress {
        position: absolute;
        top: 20px;
        left: 40px;
        height: 3px;
        background: #22c55e;
        z-index: 2;
        transition: width 0.4s ease;
    }
    .stepper-step {
        position: relative;
        z-index: 3;
        text-align: center;
        flex: 1;
    }
    .stepper-icon {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #ffffff;
        border: 2px solid #cbd5e1;
        color: #94a3b8;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        margin: 0 auto 8px;
        transition: all 0.3s;
    }
    .stepper-step.active .stepper-icon {
        border-color: #22c55e;
        background: #22c55e;
        color: #ffffff;
        box-shadow: 0 0 0 4px rgba(34, 197, 94, 0.15);
    }
    .stepper-label {
        font-size: 0.82rem;
        font-weight: 700;
        color: #64748b;
    }
    .stepper-step.active .stepper-label {
        color: #111827;
    }
    .stepper-date {
        font-size: 0.72rem;
        color: #94a3b8;
    }
</style>
@endsection

@section('content')
<div class="track-page-wrapper">
    <div class="container" style="max-width: 780px;">
        
        <!-- Top Back Navigation -->
        <div class="d-flex justify-content-between align-items-center mb-3">
            <a href="{{ url()->previous() ?: route('profile') }}" class="btn btn-sm btn-light border fw-bold text-dark px-3 py-2" style="border-radius: 20px; font-size: 0.82rem;">
                <i class="bi bi-arrow-left"></i> Back
            </a>
            <span class="badge bg-danger px-3 py-2 rounded-pill fw-bold" style="font-size: 0.75rem;">
                <i class="bi bi-shield-check"></i> Verified Order
            </span>
        </div>

        <div class="track-card">
            
            <!-- Order Header Title -->
            <div class="text-center mb-4 pb-3 border-bottom">
                <span class="badge bg-light text-secondary border mb-2 px-3 py-1 fw-bold" style="font-size: 0.76rem; border-radius: 8px;">
                    Order Tracking
                </span>
                <h1 style="font-size: 1.5rem; font-weight: 800; color: #111827; margin: 0 0 4px 0;">
                    Order #{{ $order->order_number }}
                </h1>
                <p class="text-muted small mb-0">
                    Placed on {{ $order->created_at ? $order->created_at->format('F d, Y') : 'N/A' }} 
                    &bull; {{ $order->customer_city }}
                </p>
            </div>

            <!-- ===================================================================
                 CASE 1: SHIPPING UNAVAILABLE (NON-COURIER DELIVERY)
                 =================================================================== -->
            @if(!$isShippingAvailable)
                <div class="alert alert-warning p-3 rounded-4 mb-4" style="border: 1.5px solid #fde68a; background-color: #fffbeb;">
                    <div class="d-flex gap-3 align-items-start">
                        <i class="bi bi-info-circle-fill text-warning fs-3" style="flex: 0 0 auto;"></i>
                        <div>
                            <h5 class="fw-bold mb-1" style="font-size: 0.95rem; color: #92400e;">Shipping Tracking Unavailable</h5>
                            <p class="small mb-0" style="color: #b45309; line-height: 1.45;">
                                This order was placed with delivery method: <strong>{{ $order->shipping_type ?: 'In-Store Pickup / Local Collection' }}</strong>. 
                                Real-time courier tracking is only active for <strong>Courier & Dropshipping</strong> deliveries.
                            </p>
                        </div>
                    </div>
                </div>

            <!-- ===================================================================
                 CASE 2: LIVE COURIER TRACKING (CITYPAK OR DEX)
                 =================================================================== -->
            @elseif($liveTracking && !empty($liveTracking['timeline']))
                
                <div class="provider-banner">
                    <div>
                        <div class="provider-title">
                            <i class="bi {{ $liveTracking['provider_icon'] }} text-danger"></i>
                            {{ $liveTracking['provider_name'] }}
                        </div>
                        <div class="provider-tracking-no">
                            Tracking No: <strong>{{ $liveTracking['tracking_number'] }}</strong>
                            <span class="badge {{ $liveTracking['status_type'] === 'delivered' ? 'bg-success' : ($liveTracking['status_type'] === 'returns' ? 'bg-danger' : 'bg-primary') }} ms-1">
                                {{ $liveTracking['status_formatted'] }}
                            </span>
                        </div>
                    </div>
                    @if(!empty($liveTracking['direct_url']))
                        <a href="{{ $liveTracking['direct_url'] }}" target="_blank" class="btn-external-track">
                            <i class="bi bi-box-arrow-up-right"></i> Official Portal
                        </a>
                    @endif
                </div>

                <h3 class="fw-bold mb-3" style="font-size: 1rem; color: #111827;">Live Tracking Milestones</h3>
                
                <div class="live-timeline">
                    @foreach($liveTracking['timeline'] as $event)
                        <div class="timeline-item">
                            <div class="timeline-item-dot"></div>
                            <div class="timeline-content">
                                <div class="timeline-header">
                                    <h4 class="timeline-status">{{ $event['status'] }}</h4>
                                    <span class="timeline-time">{{ $event['human_time'] }}</span>
                                </div>
                                <div class="timeline-meta">
                                    @if(!empty($event['location']))
                                        <span class="badge-loc"><i class="bi bi-geo-alt"></i> {{ $event['location'] }}</span>
                                    @endif
                                    @if(!empty($event['shipping_provider']))
                                        <span><i class="bi bi-truck"></i> {{ $event['shipping_provider'] }}</span>
                                    @endif
                                    @if(!empty($event['reason']))
                                        <span class="text-danger fw-bold"><i class="bi bi-exclamation-triangle"></i> {{ $event['reason'] }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endforeach
                </div>

            <!-- ===================================================================
                 CASE 3: STANDARD COURIER STEPPER
                 =================================================================== -->
            @else
                @php
                    $rawStatus = strtolower(trim($order->courier_status ?? 'pending'));
                    $isDispatched = in_array($rawStatus, ['dispatched', 'shipped', 'in_transit', 'out_for_delivery', 'delivered']);
                    $isDelivered = ($rawStatus === 'delivered');
                    $progressWidth = $isDelivered ? '100%' : ($isDispatched ? '50%' : '0%');
                @endphp

                @if(!empty($order->tracking_number))
                    <div class="provider-banner mb-3">
                        <div>
                            <div class="provider-title">
                                <i class="bi bi-truck text-danger"></i> Courier Delivery
                            </div>
                            <div class="provider-tracking-no">
                                Tracking ID: <strong>{{ $order->tracking_number }}</strong>
                            </div>
                        </div>
                        <span class="badge bg-primary px-3 py-2 rounded-pill fw-bold">
                            {{ $order->courier_status ?: 'In Transit' }}
                        </span>
                    </div>
                @endif

                <div class="stepper-container">
                    <div class="stepper-progress" style="width: {{ $progressWidth }};"></div>
                    
                    <div class="stepper-step active">
                        <div class="stepper-icon"><i class="bi bi-check-lg"></i></div>
                        <div class="stepper-label">Order Placed</div>
                        <div class="stepper-date">{{ $order->created_at ? $order->created_at->format('M d') : '' }}</div>
                    </div>

                    <div class="stepper-step {{ $isDispatched ? 'active' : '' }}">
                        <div class="stepper-icon"><i class="bi bi-truck"></i></div>
                        <div class="stepper-label">Dispatched</div>
                        <div class="stepper-date">{{ $order->dispatch_date ? \Carbon\Carbon::parse($order->dispatch_date)->format('M d') : 'Pending' }}</div>
                    </div>

                    <div class="stepper-step {{ $isDelivered ? 'active' : '' }}">
                        <div class="stepper-icon"><i class="bi bi-house-check"></i></div>
                        <div class="stepper-label">Delivered</div>
                        <div class="stepper-date">{{ $isDelivered ? ($order->status_updated_at ? \Carbon\Carbon::parse($order->status_updated_at)->format('M d') : 'Delivered') : 'Pending' }}</div>
                    </div>
                </div>
            @endif

            <!-- Delivery Address Card -->
            <div class="border-top pt-4 mt-4">
                <h3 class="fw-bold mb-3" style="font-size: 1rem; color: #111827;">Delivery Address</h3>
                <div class="p-3 bg-light rounded-3" style="font-size: 0.88rem; line-height: 1.6; border: 1px solid #e2e8f0;">
                    <div class="fw-bold text-dark fs-6">{{ $order->customer_name }}</div>
                    <div class="text-secondary">{{ $order->customer_address }}</div>
                    <div class="text-secondary">{{ $order->customer_city }}</div>
                    <div class="mt-2 text-dark">
                        <i class="bi bi-telephone text-muted me-1"></i> {{ $order->customer_pri_mobile }}
                        @if($order->customer_sec_mobile)
                            &bull; {{ $order->customer_sec_mobile }}
                        @endif
                    </div>
                </div>
            </div>

            <!-- Order Summary Table -->
            <div class="border-top pt-4 mt-4">
                <h3 class="fw-bold mb-3" style="font-size: 1rem; color: #111827;">Items in this Order</h3>
                <div class="table-responsive">
                    <table class="table align-middle" style="font-size: 0.88rem;">
                        <thead>
                            <tr class="table-light">
                                <th>Product</th>
                                <th class="text-center">Qty</th>
                                <th class="text-end">Price</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $subtotal = 0;
                                foreach($order->details as $d) {
                                    $subtotal += ($d->selling_price * $d->quantity);
                                }
                                $discount = max(0, $subtotal - (float) $order->total_amount);
                            @endphp
                            @foreach($order->details as $item)
                                <tr>
                                    <td>
                                        <span class="fw-bold text-dark">{{ $item->product_name }}</span>
                                    </td>
                                    <td class="text-center">{{ $item->quantity }}</td>
                                    <td class="text-end fw-semibold">Rs. {{ number_format($item->selling_price * $item->quantity, 2) }}</td>
                                </tr>
                            @endforeach
                            @if($discount > 0)
                                <tr>
                                    <td colspan="2" class="text-end text-muted">Subtotal:</td>
                                    <td class="text-end fw-semibold">Rs. {{ number_format($subtotal, 2) }}</td>
                                </tr>
                                <tr>
                                    <td colspan="2" class="text-end text-success fw-semibold">Discount:</td>
                                    <td class="text-end fw-bold text-success">- Rs. {{ number_format($discount, 2) }}</td>
                                </tr>
                            @endif
                            <tr class="table-light">
                                <td colspan="2" class="text-end fw-bold">Total Amount:</td>
                                <td class="text-end fw-bold text-danger fs-6">Rs. {{ number_format($order->total_amount, 2) }}</td>
                            </tr>
                        </tbody>
                    </table>
                </div>
            </div>

            <!-- WhatsApp Help Desk CTA -->
            <div class="text-center mt-4 pt-3 border-top">
                <p class="text-muted small mb-2">Have a question regarding your parcel?</p>
                <a href="https://wa.me/94706050500?text={{ urlencode('Hi Loku Kade, I need an update regarding my order #' . $order->order_number) }}" target="_blank" class="btn btn-success px-4 py-2 fw-bold" style="border-radius: 10px; font-size: 0.88rem;">
                    <i class="bi bi-whatsapp me-1"></i> WhatsApp Help Desk
                </a>
            </div>

        </div>
    </div>
</div>
@endsection
