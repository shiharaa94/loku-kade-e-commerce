@extends('layouts.frontend')

@section('title', 'Customer Dashboard - Loku Kade')

@section('styles')
<style>
    /* ==========================================================
       ALIEXPRESS / DARAZ STYLE CLIENT MOBILE DASHBOARD
       ========================================================== */
    .dashboard-wrapper {
        padding: 82px 0 90px;
        background-color: #f4f5f7;
        min-height: 100vh;
        overflow-x: hidden;
        width: 100%;
        box-sizing: border-box;
        font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Helvetica, Arial, sans-serif;
    }
    .dashboard-wrapper > .container {
        width: 100%;
        max-width: 1200px;
        box-sizing: border-box;
    }
    
    .dashboard-grid {
        display: grid;
        grid-template-columns: 280px minmax(0, 1fr);
        gap: 1.5rem;
        align-items: start;
        width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }
    @media (max-width: 991.98px) {
        .dashboard-grid {
            grid-template-columns: minmax(0, 1fr);
            gap: 1rem;
        }
        .dashboard-sidebar {
            display: none !important;
        }
    }
    .dashboard-main {
        min-width: 0;
        width: 100%;
        box-sizing: border-box;
    }

    /* Desktop Sidebar */
    .dashboard-sidebar {
        background: #ffffff;
        border: 1px solid #e5e7eb;
        border-radius: 16px;
        padding: 1.5rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
    }
    .profile-summary {
        text-align: center;
        border-bottom: 1px solid #f3f4f6;
        padding-bottom: 1.25rem;
        margin-bottom: 1.25rem;
    }
    .profile-avatar {
        width: 72px;
        height: 72px;
        background: linear-gradient(135deg, #ff2442 0%, #ff6b81 100%);
        color: #ffffff;
        border-radius: 50%;
        display: inline-flex;
        align-items: center;
        justify-content: center;
        font-size: 1.8rem;
        font-weight: 700;
        margin-bottom: 0.75rem;
        box-shadow: 0 4px 12px rgba(255, 36, 66, 0.2);
    }
    .profile-name {
        font-size: 1.15rem;
        font-weight: 700;
        color: #111827;
        margin-bottom: 0.2rem;
    }
    .profile-email {
        font-size: 0.85rem;
        color: #6b7280;
    }
    .dashboard-nav {
        display: flex;
        flex-direction: column;
        gap: 0.4rem;
    }
    .nav-tab-btn {
        display: flex;
        align-items: center;
        gap: 0.75rem;
        padding: 0.75rem 1rem;
        background: transparent;
        border: none;
        border-radius: 10px;
        color: #4b5563;
        font-weight: 600;
        font-size: 0.92rem;
        text-align: left;
        cursor: pointer;
        transition: all 0.2s ease;
        box-sizing: border-box;
    }
    .dashboard-sidebar .nav-tab-btn {
        width: 100%;
    }
    .nav-tab-btn:hover {
        background-color: #f3f4f6;
        color: #111827;
    }
    .nav-tab-btn.active {
        background-color: #ffe8ec;
        color: #ff2442;
        font-weight: 700;
    }
    
    .tab-content {
        display: none;
        width: 100%;
        min-width: 0;
        box-sizing: border-box;
    }
    .tab-content.active {
        display: block;
        animation: fadeInTab 0.25s ease-out;
    }
    @keyframes fadeInTab {
        from { opacity: 0; transform: translateY(4px); }
        to { opacity: 1; transform: translateY(0); }
    }

    /* ----------------------------------------------------
       OVERVIEW TAB - CLEAN APP LAYOUT
       ---------------------------------------------------- */
    
    /* 1. Header Profile Card */
    .profile-header-card {
        background: #ffffff;
        padding: 14px 16px;
        border-radius: 16px;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        margin-bottom: 0.75rem;
        border: 1px solid #f0f0f0;
    }
    .profile-header-info {
        display: flex;
        align-items: center;
        justify-content: space-between;
    }
    .profile-user-detail {
        display: flex;
        align-items: center;
        gap: 0.75rem;
    }
    .profile-avatar-redesign {
        width: 48px;
        height: 48px;
        border-radius: 50%;
        background: #fdf2f4;
        color: #ff2442;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.35rem;
        font-weight: 700;
        border: 1.5px solid #fed7dd;
    }
    .profile-user-name {
        font-size: 1.12rem;
        font-weight: 700;
        color: #111827;
        margin: 0;
        line-height: 1.2;
    }
    .profile-header-actions {
        display: flex;
        align-items: center;
        gap: 0.65rem;
    }
    .header-action-icon {
        width: 36px;
        height: 36px;
        border-radius: 50%;
        background: #f5f6f8;
        color: #262626;
        display: flex;
        align-items: center;
        justify-content: center;
        font-size: 1.15rem;
        border: none;
        cursor: pointer;
        position: relative;
        transition: background-color 0.15s;
    }
    .header-action-icon:hover {
        background: #e9eaec;
    }
    .badge-count-red {
        position: absolute;
        top: -3px;
        right: -3px;
        background: #ff2442;
        color: #ffffff;
        font-size: 0.62rem;
        font-weight: 800;
        padding: 1px 5px;
        border-radius: 10px;
        border: 1.5px solid #ffffff;
        min-width: 17px;
        text-align: center;
        line-height: 1.2;
    }

    /* 3. My Orders Card (5 Top + 4 Bottom) */
    .orders-overview-panel {
        background: #ffffff;
        border-radius: 16px;
        padding: 14px 16px 12px;
        margin-bottom: 0.75rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        border: 1px solid #f0f0f0;
    }
    .panel-header {
        display: flex;
        justify-content: space-between;
        align-items: center;
        margin-bottom: 1rem;
    }
    .panel-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #191919;
        margin: 0;
    }
    .panel-link {
        font-size: 0.8rem;
        color: #8c8c8c;
        text-decoration: none;
        font-weight: 600;
        cursor: pointer;
        display: inline-flex;
        align-items: center;
        gap: 2px;
    }
    .panel-link:hover {
        color: #ff2442;
    }
    
    .quick-grid-5 {
        display: grid;
        grid-template-columns: repeat(5, 1fr);
        gap: 2px;
        text-align: center;
        margin-bottom: 1rem;
    }
    .quick-grid-4 {
        display: grid;
        grid-template-columns: repeat(4, 1fr);
        gap: 4px;
        text-align: center;
    }
    .quick-grid-4.bottom-row {
        border-top: 1px solid #f5f5f5;
        padding-top: 0.85rem;
    }
    .quick-grid-item {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 5px;
        text-decoration: none;
        color: #262626;
        position: relative;
        cursor: pointer;
        background: transparent;
        border: none;
        padding: 4px 0;
        transition: transform 0.15s;
    }
    .quick-grid-item:active {
        transform: scale(0.95);
    }
    .quick-grid-item i {
        font-size: 1.45rem;
        color: #262626;
        line-height: 1;
    }
    .quick-grid-item span {
        font-size: 0.72rem;
        font-weight: 600;
        color: #262626;
    }
    .badge-counter-floating {
        position: absolute;
        top: -4px;
        right: calc(50% - 20px);
        background: #ff7800; /* Light Warm Orange for high visibility */
        color: #ffffff;
        font-size: 0.68rem;
        font-weight: 800;
        padding: 1px 5px;
        border-radius: 10px;
        border: 1.5px solid #ffffff;
        min-width: 17px;
        line-height: 1.2;
        box-shadow: 0 2px 5px rgba(255, 120, 0, 0.35);
    }

    /* 4. Mini Games & Utilities Panel */
    .mini-services-panel {
        background: #ffffff;
        border-radius: 16px;
        padding: 14px 16px 12px;
        margin-bottom: 0.75rem;
        box-shadow: 0 2px 10px rgba(0, 0, 0, 0.02);
        border: 1px solid #f0f0f0;
    }
    .games-row {
        display: grid;
        grid-template-columns: repeat(3, minmax(0, 1fr));
        gap: 8px;
        text-align: center;
        margin-bottom: 1rem;
    }
    .game-item-btn {
        display: flex;
        flex-direction: column;
        align-items: center;
        gap: 4px;
        cursor: pointer;
        text-decoration: none;
    }
    .game-item-btn span {
        font-size: 0.72rem;
        font-weight: 600;
        color: #262626;
    }
    
    .services-grid-5 {
        display: grid;
        grid-template-columns: repeat(5, minmax(0, 1fr));
        gap: 2px;
        text-align: center;
        border-top: 1px solid #f5f5f5;
        padding-top: 0.85rem;
    }

    /* ----------------------------------------------------
       SUB-TABS (ORDERS, REVIEWS, SETTINGS)
       ---------------------------------------------------- */
    .subtab-header-card {
        background: #ffffff;
        border-radius: 16px;
        padding: 12px 14px;
        margin-bottom: 0.75rem;
        display: flex;
        align-items: center;
        justify-content: space-between;
        border: 1px solid #f0f0f0;
        width: 100%;
        box-sizing: border-box;
    }
    .subtab-title {
        font-size: 1.05rem;
        font-weight: 800;
        color: #111827;
        margin: 0;
        text-align: center;
        flex: 1;
    }
    .btn-back-overview {
        display: inline-flex;
        align-items: center;
        gap: 4px;
        background: #f5f6f8;
        color: #111827;
        border: none;
        border-radius: 20px;
        padding: 6px 12px;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        transition: background-color 0.15s;
        width: auto !important;
        flex: 0 0 auto;
        white-space: nowrap;
    }
    .btn-back-overview:hover {
        background: #e9eaec;
    }
    
    /* Order Status Filter Pills */
    .order-filter-pills {
        display: flex;
        gap: 0.45rem;
        overflow-x: auto;
        padding-bottom: 0.45rem;
        margin-bottom: 0.85rem;
        scrollbar-width: none;
        width: 100%;
        box-sizing: border-box;
    }
    .order-filter-pills::-webkit-scrollbar { display: none; }
    .order-filter-btn {
        flex: 0 0 auto;
        padding: 6px 12px;
        border-radius: 20px;
        border: 1px solid #e5e7eb;
        background: #ffffff;
        color: #4b5563;
        font-size: 0.78rem;
        font-weight: 700;
        cursor: pointer;
        transition: all 0.15s;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        white-space: nowrap;
    }
    .order-filter-btn:hover {
        background: #f9fafb;
    }
    .order-filter-btn.active {
        background: #ff1944;
        color: #ffffff;
        border-color: #ff1944;
    }
    .order-filter-btn .filter-count-badge {
        font-size: 0.65rem;
        padding: 1px 5px;
        border-radius: 10px;
        background: rgba(0,0,0,0.06);
    }
    .order-filter-btn.active .filter-count-badge {
        background: rgba(255,255,255,0.25);
        color: #ffffff;
    }

    .order-item-card {
        background: #ffffff;
        border: 1px solid #f0f0f0;
        border-radius: 16px;
        padding: 14px;
        margin-bottom: 0.75rem;
        box-shadow: 0 2px 8px rgba(0, 0, 0, 0.02);
        transition: all 0.2s ease;
        width: 100%;
        box-sizing: border-box;
    /* --- ULTRA-PREMIUM MODERN ORDER CARD --- */
    .order-item-card {
        background: #ffffff;
        border: 1px solid #eef2f6;
        border-radius: 18px;
        margin-bottom: 1.15rem;
        box-shadow: 0 4px 16px rgba(0, 0, 0, 0.03);
        transition: transform 0.2s ease, box-shadow 0.2s ease;
        width: 100%;
        box-sizing: border-box;
        overflow: hidden;
    }
    .order-item-card:hover {
        box-shadow: 0 8px 24px rgba(0, 0, 0, 0.06);
        border-color: #e2e8f0;
    }
    .order-card-header {
        background: #fafbfc;
        padding: 12px 16px;
        border-bottom: 1px solid #f1f5f9;
        display: flex;
        justify-content: space-between;
        align-items: center;
        flex-wrap: wrap;
        gap: 8px;
    }
    .order-header-left {
        display: flex;
        align-items: center;
        gap: 8px;
        flex-wrap: wrap;
    }
    .order-id-badge {
        font-weight: 800;
        color: #111827;
        font-size: 0.92rem;
        letter-spacing: -0.2px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .order-date-pill {
        font-size: 0.76rem;
        color: #64748b;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 2px 8px;
        border-radius: 12px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        font-weight: 500;
    }
    .order-status-badge {
        font-size: 0.72rem;
        font-weight: 800;
        padding: 4px 10px;
        border-radius: 20px;
        display: inline-flex;
        align-items: center;
        gap: 4px;
        letter-spacing: 0.3px;
        text-transform: capitalize;
    }
    .status-pending { background-color: #fff7ed; color: #c2410c; border: 1px solid #ffedd5; }
    .status-dispatched { background-color: #eff6ff; color: #1d4ed8; border: 1px solid #dbeafe; }
    .status-delivered { background-color: #f0fdf4; color: #15803d; border: 1px solid #dcfce7; }
    .status-canceled { background-color: #fef2f2; color: #b91c1c; border: 1px solid #fee2e2; }

    /* Order Products List */
    .order-products-container {
        padding: 12px 16px;
    }
    .order-product-row {
        display: flex;
        align-items: center;
        gap: 12px;
        padding: 10px 0;
        border-bottom: 1px dashed #f1f5f9;
    }
    .order-product-row:last-child {
        border-bottom: none;
        padding-bottom: 2px;
    }
    .order-product-thumb {
        width: 56px;
        height: 56px;
        border-radius: 12px;
        object-fit: cover;
        border: 1px solid #f1f5f9;
        background: #f8fafc;
        flex: 0 0 56px;
    }
    .order-product-info {
        flex: 1;
        min-width: 0;
    }
    .order-product-title {
        font-size: 0.88rem;
        font-weight: 700;
        color: #1e293b;
        margin: 0 0 4px 0;
        line-height: 1.35;
        overflow: hidden;
        text-overflow: ellipsis;
        white-space: nowrap;
    }
    .order-product-meta {
        display: flex;
        align-items: center;
        gap: 8px;
        font-size: 0.78rem;
        color: #64748b;
    }
    .badge-order-qty {
        background: #f1f5f9;
        color: #334155;
        font-weight: 700;
        font-size: 0.72rem;
        padding: 1px 6px;
        border-radius: 6px;
    }
    .order-product-price {
        font-size: 0.88rem;
        font-weight: 700;
        color: #0f172a;
        text-align: right;
        white-space: nowrap;
    }

    /* Order Footer & Actions */
    .order-card-footer {
        background: #fafbfc;
        border-top: 1px solid #f1f5f9;
        padding: 12px 16px;
        display: flex;
        align-items: center;
        justify-content: space-between;
        flex-wrap: wrap;
        gap: 10px;
    }
    .payment-chip {
        font-size: 0.76rem;
        font-weight: 600;
        color: #475569;
        background: #ffffff;
        border: 1px solid #e2e8f0;
        padding: 4px 9px;
        border-radius: 8px;
        display: inline-flex;
        align-items: center;
        gap: 5px;
    }
    .order-total-block {
        display: flex;
        align-items: baseline;
        gap: 6px;
    }
    .order-total-label {
        font-size: 0.8rem;
        color: #64748b;
        font-weight: 600;
    }
    .order-total-price {
        font-size: 1.12rem;
        font-weight: 800;
        color: #ff1944;
        letter-spacing: -0.3px;
    }
    .order-actions-bar {
        width: 100%;
        display: flex;
        gap: 8px;
        margin-top: 4px;
    }
    .action-btn {
        display: inline-flex;
        align-items: center;
        justify-content: center;
        gap: 6px;
        padding: 9px 14px;
        font-size: 0.82rem;
        font-weight: 700;
        border-radius: 10px;
        text-decoration: none;
        cursor: pointer;
        border: 1.5px solid transparent;
        transition: all 0.2s ease;
        flex: 1;
        text-align: center;
    }
    .btn-solid {
        background-color: #ff1944;
        color: #ffffff;
        box-shadow: 0 2px 8px rgba(255, 25, 68, 0.2);
    }
    .btn-solid:hover {
        background-color: #e5002b;
        color: #ffffff;
        transform: translateY(-1px);
    }
    .btn-outline {
        border-color: #e2e8f0;
        background-color: #ffffff;
        color: #334155;
    }
    .btn-outline:hover {
        background-color: #f8fafc;
        border-color: #cbd5e1;
        color: #0f172a;
    }
    .btn-reviewed-tag {
        border: 1.5px solid #dcfce7;
        background-color: #f0fdf4;
        color: #15803d;
        font-weight: 700;
    }
    
    .review-item-card {
        display: flex;
        gap: 0.85rem;
        background: #ffffff;
        border: 1px solid #f0f0f0;
        border-radius: 16px;
        padding: 14px;
        margin-bottom: 0.75rem;
    }
    .review-product-thumb {
        width: 58px;
        height: 58px;
        border-radius: 10px;
        object-fit: cover;
        border: 1px solid #f0f0f0;
    }
    .review-content {
        flex: 1;
    }
    .review-stars {
        color: #f59e0b;
        font-size: 0.8rem;
        margin: 2px 0 6px;
    }
    .review-comment {
        font-size: 0.85rem;
        color: #4b5563;
        margin: 0;
    }
    
    /* Settings Form */
    .settings-card {
        background: #ffffff;
        border: 1px solid #f0f0f0;
        border-radius: 16px;
        padding: 16px;
    }
    .form-group {
        margin-bottom: 1rem;
    }
    .form-label {
        display: block;
        font-size: 0.85rem;
        font-weight: 700;
        color: #374151;
        margin-bottom: 0.35rem;
    }
    .form-control {
        width: 100%;
        padding: 10px 12px;
        border: 1.5px solid #e5e7eb;
        border-radius: 10px;
        font-size: 0.92rem;
        transition: border-color 0.2s;
    }
    .form-control:focus {
        border-color: #ff1944;
        outline: none;
    }

    /* Mobile First Tuning */
    @media (max-width: 767.98px) {
        .dashboard-wrapper { padding: 80px 0 85px; }
        .dashboard-wrapper > .container { padding-left: 10px; padding-right: 10px; }
        .dashboard-sidebar { display: none; }
        
        .profile-header-card,
        .orders-overview-panel,
        .mini-services-panel,
        .settings-card,
        .subtab-header-card,
        .order-item-card,
        .review-item-card { border-radius: 14px; }
        .profile-header-card { padding: 12px; }
        .profile-user-detail { gap: 0.55rem; min-width: 0; }
        .profile-user-name {
            font-size: 1rem;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
        }
        .profile-header-actions { gap: 0.35rem; }
        .header-action-icon { width: 34px; height: 34px; }
        .quick-grid-5,
        .quick-grid-4,
        .services-grid-5,
        .games-row { width: 100%; min-width: 0; }
        .quick-grid-5,
        .quick-grid-4,
        .services-grid-5 { gap: 0; }
        .quick-grid-item {
            width: auto;
            min-width: 0;
            padding: 5px 1px;
        }
        .quick-grid-item i { font-size: 1.25rem; }
        .quick-grid-item span { font-size: 0.64rem; line-height: 1.2; overflow-wrap: anywhere; }
        .badge-counter-floating { right: calc(50% - 17px); }
        .subtab-header-card {
            display: flex;
            align-items: center;
            justify-content: space-between;
            gap: 0.5rem;
            padding: 10px 12px;
            width: 100%;
            box-sizing: border-box;
        }
        .subtab-title {
            font-size: 0.95rem;
            text-align: center;
            overflow: hidden;
            text-overflow: ellipsis;
            white-space: nowrap;
            flex: 1;
            margin: 0;
        }
        .btn-back-overview { padding: 6px 9px; }
        .order-meta { align-items: flex-start; gap: 0.5rem; }
        .order-meta > div { min-width: 0; }
        .order-id,
        .order-date { display: block; }
        .order-date { margin-top: 2px; }
        .status-pill { flex: 0 0 auto; }
        .order-details-summary { align-items: flex-start; }
        .order-details-summary > div:first-child { width: 100%; }
        .order-details-summary .text-end { width: 100%; text-align: left !important; }
        .review-item-card { gap: 0.65rem; padding: 12px; }
        .review-product-thumb { width: 52px; height: 52px; flex: 0 0 52px; }
        .review-content .d-flex { display: block !important; }
        .review-content h4 { overflow-wrap: anywhere; }
        .settings-card { padding: 14px 12px; }
        .form-control { min-height: 44px; }
        .action-btn { min-height: 42px; padding: 8px 10px; }
    }

    @media (max-width: 374.98px) {
        .dashboard-wrapper > .container { padding-left: 8px; padding-right: 8px; }
        .profile-user-name { max-width: 145px; }
        .orders-overview-panel,
        .mini-services-panel { padding-left: 10px; padding-right: 10px; }
        .quick-grid-item span { font-size: 0.6rem; }
    }
</style>
@endsection

@section('content')
@php
    $reviewedOrderNumbers = $reviews->pluck('order_number')->filter()->unique()->toArray();

    // 1. To Ship: pending status
    $toShipOrders = $orders->filter(function($o) {
        $status = strtolower(trim($o->courier_status ?? 'pending'));
        return in_array($status, ['pending', '']);
    });
    $toShipCount = $toShipOrders->count();

    // 2. Shipped: orders != pending and orders != delivered and orders != return and orders != return collected (and not canceled)
    $shippedOrders = $orders->filter(function($o) {
        $status = strtolower(trim($o->courier_status ?? ''));
        return !empty($status) && !in_array($status, ['pending', 'delivered', 'return', 'return collected', 'canceled', 'cancelled']);
    });
    $shippedCount = $shippedOrders->count();

    // 3. Delivered: delivered orders
    $deliveredOrders = $orders->filter(function($o) {
        $status = strtolower(trim($o->courier_status ?? ''));
        return $status === 'delivered';
    });
    $deliveredCount = $deliveredOrders->count();

    // 4. To Review: customer review dala nathi delivered orders tika
    $toReviewOrders = $deliveredOrders->filter(function($o) use ($reviewedOrderNumbers) {
        return !in_array($o->order_number, $reviewedOrderNumbers);
    });
    $toReviewCount = $toReviewOrders->count();

    // 5. Returns: return / return collected / canceled orders
    $returnsOrders = $orders->filter(function($o) {
        $status = strtolower(trim($o->courier_status ?? ''));
        return in_array($status, ['return', 'return collected', 'canceled', 'cancelled']);
    });
    $returnsCount = $returnsOrders->count();
@endphp

<div class="dashboard-wrapper">
    <div class="container">
        @if (session('success'))
            <div class="alert alert-success alert-dismissible fade show mb-3" role="alert" style="border-radius: 12px; font-weight: 600;">
                {{ session('success') }}
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        @if ($errors->any())
            <div class="alert alert-danger alert-dismissible fade show mb-3" role="alert" style="border-radius: 12px; font-weight: 600;">
                <ul style="margin: 0; padding-left: 1.2rem;">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        @endif

        <div class="dashboard-grid">
            <!-- Sidebar Column (Desktop Only) -->
            <aside class="dashboard-sidebar d-none d-lg-block">
                <div class="profile-summary">
                    <div class="profile-avatar">
                        {{ strtoupper(substr($user->first_name, 0, 1)) }}
                    </div>
                    <div class="profile-identity">
                        <h2 class="profile-name">{{ $user->first_name }} {{ $user->last_name }}</h2>
                        <span class="profile-email">{{ $user->email }}</span>
                    </div>
                </div>

                <nav class="dashboard-nav">
                    <button type="button" class="nav-tab-btn active" data-target="overview">
                        <i class="bi bi-grid-1x2"></i> Overview
                    </button>
                    <button type="button" class="nav-tab-btn" data-target="orders" data-filter="all">
                        <i class="bi bi-bag-check"></i> My Orders
                    </button>
                    <button type="button" class="nav-tab-btn" data-target="address">
                        <i class="bi bi-geo-alt"></i> Delivery Address
                    </button>
                    <button type="button" class="nav-tab-btn" data-target="reviews">
                        <i class="bi bi-star"></i> My Reviews
                    </button>
                    <button type="button" class="nav-tab-btn" data-target="settings">
                        <i class="bi bi-person-gear"></i> Profile Settings
                    </button>
                    <form action="{{ route('logout') }}" method="POST" style="width: 100%; margin-top: 0.5rem;">
                        @csrf
                        <button type="submit" class="nav-tab-btn text-danger" style="color: #ff1944;">
                            <i class="bi bi-box-arrow-right"></i> Logout
                        </button>
                    </form>
                </nav>
            </aside>

            <!-- Content Area -->
            <main class="dashboard-main">
                
                <!-- ==========================================
                     TAB 1: OVERVIEW
                     ========================================== -->
                <div id="tab-overview" class="tab-content active">
                    
                    <!-- Top User Profile Bar -->
                    <div class="profile-header-card">
                        <div class="profile-header-info">
                            <div class="profile-user-detail">
                                <div class="profile-avatar-redesign">
                                    {{ strtoupper(substr($user->first_name, 0, 1)) }}
                                </div>
                                <h2 class="profile-user-name">{{ $user->first_name }} {{ $user->last_name }}</h2>
                            </div>
                            <div class="profile-header-actions">
                                <button type="button" class="header-action-icon nav-tab-btn" data-target="settings" title="Settings">
                                    <i class="bi bi-gear"></i>
                                </button>
                                <div class="header-action-icon" title="Notifications" onclick="showCustomAlert('No new notifications at this time.')">
                                    <i class="bi bi-bell"></i>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- My Orders Overview Card (5 Top + 4 Bottom) -->
                    <div class="orders-overview-panel">
                        <div class="panel-header">
                            <h3 class="panel-title">My orders</h3>
                            <button type="button" class="panel-link nav-tab-btn border-0 bg-transparent p-0" data-target="orders" data-filter="all">
                                View all <i class="bi bi-chevron-right"></i>
                            </button>
                        </div>
                        
                        <!-- Top 5 Order Status Icons -->
                        <div class="quick-grid-5">
                            <button type="button" class="quick-grid-item nav-tab-btn" data-target="orders" data-filter="to_ship">
                                <i class="bi bi-box-seam"></i>
                                <span>To ship</span>
                                @if($toShipCount > 0)
                                    <span class="badge-counter-floating">{{ $toShipCount }}</span>
                                @endif
                            </button>
                            <button type="button" class="quick-grid-item nav-tab-btn" data-target="orders" data-filter="shipped">
                                <i class="bi bi-truck"></i>
                                <span>Shipped</span>
                                @if($shippedCount > 0)
                                    <span class="badge-counter-floating">{{ $shippedCount }}</span>
                                @endif
                            </button>
                            <button type="button" class="quick-grid-item nav-tab-btn" data-target="orders" data-filter="delivered">
                                <i class="bi bi-bag-check"></i>
                                <span>Delivered</span>
                                @if($deliveredCount > 0)
                                    <span class="badge-counter-floating">{{ $deliveredCount }}</span>
                                @endif
                            </button>
                            <button type="button" class="quick-grid-item nav-tab-btn" data-target="orders" data-filter="to_review">
                                <i class="bi bi-chat-square-text"></i>
                                <span>To review</span>
                                @if($toReviewCount > 0)
                                    <span class="badge-counter-floating">{{ $toReviewCount }}</span>
                                @endif
                            </button>
                            <button type="button" class="quick-grid-item nav-tab-btn" data-target="orders" data-filter="returns">
                                <i class="bi bi-arrow-counterclockwise"></i>
                                <span>Returns</span>
                                @if($returnsCount > 0)
                                    <span class="badge-counter-floating">{{ $returnsCount }}</span>
                                @endif
                            </button>
                        </div>
                        
                        <!-- Bottom 4 General Option Icons -->
                        <div class="quick-grid-4 bottom-row">
                            <button type="button" class="quick-grid-item nav-tab-btn" data-target="orders" data-filter="all">
                                <i class="bi bi-clock-history"></i>
                                <span>History</span>
                            </button>
                            <button type="button" class="quick-grid-item nav-tab-btn" data-target="address">
                                <i class="bi bi-geo-alt"></i>
                                <span>Address</span>
                            </button>
                            <div class="quick-grid-item" onclick="showCouponToast()">
                                <i class="bi bi-ticket-perforated"></i>
                                <span>Coupons</span>
                            </div>
                            <a href="https://wa.me/94706050500?text={{ urlencode('Hi Loku Kade, I need help with my account/orders') }}" target="_blank" class="quick-grid-item text-decoration-none">
                                <i class="bi bi-headset"></i>
                                <span>Helpdesk</span>
                            </a>
                        </div>
                    </div>

                    <!-- Mobile Logout Button -->
                    <form action="{{ route('logout') }}" method="POST" class="d-md-none mb-3" style="width: 100%;">
                        @csrf
                        <button type="submit" class="btn btn-outline-danger w-100 py-2" style="border-radius: 12px; font-weight: 700;">
                            <i class="bi bi-box-arrow-right"></i> Logout Account
                        </button>
                    </form>

                </div>

                <!-- ==========================================
                     TAB 2: MY ORDERS LIST
                     ========================================== -->
                <div id="tab-orders" class="tab-content">
                    <div class="subtab-header-card">
                        <button type="button" class="btn-back-overview nav-tab-btn" data-target="overview">
                            <i class="bi bi-chevron-left"></i> Dashboard
                        </button>
                        <h2 class="subtab-title">My Order History</h2>
                        <div style="width: 28px; flex: 0 0 28px;"></div>
                    </div>

                    <!-- Order Filter Pills -->
                    <div class="order-filter-pills">
                        <button type="button" class="order-filter-btn active" data-filter="all">
                            All <span class="filter-count-badge">{{ $orders->count() }}</span>
                        </button>
                        <button type="button" class="order-filter-btn" data-filter="to_ship">
                            To Ship <span class="filter-count-badge">{{ $toShipCount }}</span>
                        </button>
                        <button type="button" class="order-filter-btn" data-filter="shipped">
                            Shipped <span class="filter-count-badge">{{ $shippedCount }}</span>
                        </button>
                        <button type="button" class="order-filter-btn" data-filter="delivered">
                            Delivered <span class="filter-count-badge">{{ $deliveredCount }}</span>
                        </button>
                        <button type="button" class="order-filter-btn" data-filter="to_review">
                            To Review <span class="filter-count-badge">{{ $toReviewCount }}</span>
                        </button>
                        <button type="button" class="order-filter-btn" data-filter="returns">
                            Returns <span class="filter-count-badge">{{ $returnsCount }}</span>
                        </button>
                    </div>
                    
                    @if($orders->isEmpty())
                        <div class="text-center py-5 bg-white rounded-4 border">
                            <i class="bi bi-bag-x text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">You haven't placed any orders yet.</p>
                            <a href="{{ route('products.shop') }}" class="action-btn btn-solid mt-2">Shop Our Products</a>
                        </div>
                    @else
                        <div id="ordersListContainer">
                            @foreach($orders as $order)
                                @php
                                    $rawStatus = strtolower(trim($order->courier_status ?? 'pending'));
                                    $statusClass = 'status-pending';
                                    $orderGroup = 'to_ship';

                                    if (in_array($rawStatus, ['pending', ''])) {
                                        $orderGroup = 'to_ship';
                                        $statusClass = 'status-pending';
                                    } elseif ($rawStatus === 'delivered') {
                                        $orderGroup = 'delivered';
                                        $statusClass = 'status-delivered';
                                    } elseif (in_array($rawStatus, ['return', 'return collected', 'canceled', 'cancelled'])) {
                                        $orderGroup = 'returns';
                                        $statusClass = 'status-canceled';
                                    } else {
                                        // Any other status: dispatched, in_transit, etc.
                                        $orderGroup = 'shipped';
                                        $statusClass = 'status-dispatched';
                                    }

                                    $hasReviewed = in_array($order->order_number, $reviewedOrderNumbers);
                                    $isToReview = ($rawStatus === 'delivered' && !$hasReviewed);
                                @endphp
                                <article class="order-item-card" 
                                         data-order-group="{{ $orderGroup }}" 
                                         data-to-review="{{ $isToReview ? 'true' : 'false' }}">
                                    <!-- Card Header -->
                                    <div class="order-card-header">
                                        <div class="order-header-left">
                                            <span class="order-id-badge">
                                                <i class="bi bi-box-seam-fill text-danger"></i> Order #{{ $order->order_number }}
                                            </span>
                                            <span class="order-date-pill">
                                                <i class="bi bi-calendar3"></i> {{ $order->created_at->format('M d, Y') }}
                                            </span>
                                        </div>
                                        <div>
                                            @if($orderGroup === 'to_ship')
                                                <span class="order-status-badge status-pending"><i class="bi bi-hourglass-split"></i> To Ship</span>
                                            @elseif($orderGroup === 'delivered')
                                                <span class="order-status-badge status-delivered"><i class="bi bi-check-circle-fill"></i> Delivered</span>
                                            @elseif($orderGroup === 'returns')
                                                <span class="order-status-badge status-canceled"><i class="bi bi-arrow-counterclockwise"></i> Returned</span>
                                            @else
                                                <span class="order-status-badge status-dispatched"><i class="bi bi-truck"></i> Shipped</span>
                                            @endif
                                        </div>
                                    </div>

                                    <!-- Products in this Order -->
                                    <div class="order-products-container">
                                        @foreach($order->details as $detail)
                                            @php
                                                $prod = $detail->product;
                                                $detailImg = $prod ? ($prod->main_image_url ?: ($prod->main_image ? \App\Support\PublicImagePathResolver::resolveAssetUrl($prod->main_image) : null)) : null;
                                                $linePrice = $detail->amount ?: ($detail->selling_price * $detail->quantity);
                                            @endphp
                                            <div class="order-product-row">
                                                @if($detailImg)
                                                    <img src="{{ $detailImg }}" alt="{{ $detail->product_name }}" class="order-product-thumb" onerror="this.onerror=null; this.src='{{ asset('assets/images/logo.jpg') }}';">
                                                @else
                                                    <div class="d-flex align-items-center justify-content-center text-secondary order-product-thumb">
                                                        <i class="bi bi-box-seam fs-4"></i>
                                                    </div>
                                                @endif
                                                <div class="order-product-info">
                                                    <h4 class="order-product-title">{{ $detail->product_name }}</h4>
                                                    <div class="order-product-meta">
                                                        <span class="badge-order-qty">Qty: {{ $detail->quantity }}</span>
                                                        @if($detail->selling_price > 0)
                                                            <span>Rs. {{ number_format($detail->selling_price, 2) }}</span>
                                                        @endif
                                                    </div>
                                                </div>
                                                <div class="order-product-price">
                                                    Rs. {{ number_format($linePrice, 2) }}
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>

                                    <!-- Card Summary & Actions Footer -->
                                    <div class="order-card-footer">
                                        <span class="payment-chip">
                                            <i class="bi bi-cash-stack text-success"></i> {{ $order->payment_type ?? 'Cash on Delivery' }}
                                        </span>
                                        <div class="order-total-block">
                                            <span class="order-total-label">Total:</span>
                                            <span class="order-total-price">Rs. {{ number_format($order->total_amount, 2) }}</span>
                                        </div>

                                        <div class="order-actions-bar">
                                            <a href="{{ route('orders.track', $order->secure_token) }}" class="action-btn btn-outline">
                                                <i class="bi bi-geo-alt"></i> Track Order
                                            </a>
                                            @if($rawStatus === 'delivered')
                                                @if($hasReviewed)
                                                    <button type="button" class="action-btn btn-reviewed-tag" disabled>
                                                        <i class="bi bi-check2-circle"></i> Reviewed
                                                    </button>
                                                @else
                                                    <a href="{{ route('orders.review', $order->secure_token) }}" class="action-btn btn-solid">
                                                        <i class="bi bi-star-fill text-warning"></i> Review Items
                                                    </a>
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </article>
                            @endforeach
                        </div>

                        <div id="noFilteredOrdersMessage" class="text-center py-5 bg-white rounded-4 border" style="display: none;">
                            <i class="bi bi-inbox text-muted" style="font-size: 2.5rem;"></i>
                            <p class="text-muted mt-2 mb-0" id="noFilteredOrdersText">No orders found in this category.</p>
                        </div>
                    @endif
                </div>

                <!-- ==========================================
                     TAB 3: MY REVIEWS LIST
                     ========================================== -->
                <div id="tab-reviews" class="tab-content">
                    <div class="subtab-header-card">
                        <button type="button" class="btn-back-overview nav-tab-btn" data-target="overview">
                            <i class="bi bi-chevron-left"></i> Dashboard
                        </button>
                        <h2 class="subtab-title">My Product Reviews</h2>
                        <div style="width: 28px; flex: 0 0 28px;"></div>
                    </div>
                    
                    @if($reviews->isEmpty())
                        <div class="text-center py-5 bg-white rounded-4 border">
                            <i class="bi bi-star-half text-muted" style="font-size: 3rem;"></i>
                            <p class="text-muted mt-3">You haven't submitted any product reviews yet.</p>
                        </div>
                    @else
                        @foreach($reviews as $review)
                            @php
                                $product = $review->product;
                                $imgUrl = $product ? ($product->main_image_url ?: ($product->main_image ? \App\Support\PublicImagePathResolver::resolveAssetUrl($product->main_image) : null)) : null;
                            @endphp
                            <article class="review-item-card">
                                @if($imgUrl)
                                    <img src="{{ $imgUrl }}" alt="{{ $product->product_name ?? 'Product' }}" class="review-product-thumb" onerror="this.onerror=null; this.src='{{ asset('assets/images/logo.jpg') }}';">
                                @else
                                    <div class="d-flex align-items-center justify-content-center text-secondary bg-light" style="width: 58px; height: 58px; border-radius: 10px; border: 1px solid #f0f0f0; flex: 0 0 58px;">
                                        <i class="bi bi-box-seam fs-4"></i>
                                    </div>
                                @endif
                                <div class="review-content">
                                    <div class="d-flex justify-content-between align-items-start flex-wrap">
                                        <h4 style="margin: 0 0 2px 0; font-size: 0.92rem; font-weight: 700; color: #111827;">{{ $review->product->product_name ?? 'Product' }}</h4>
                                        <span style="font-size: 0.75rem; color: #8c8c8c;">{{ $review->created_at->format('M d, Y') }}</span>
                                    </div>
                                    
                                    <div class="review-stars">
                                        @for($i = 1; $i <= 5; $i++)
                                            <i class="bi {{ $i <= $review->rating ? 'bi-star-fill' : 'bi-star' }}"></i>
                                        @endfor
                                    </div>
                                    <p class="review-comment">{{ $review->comment ?: 'No comments provided.' }}</p>
                                </div>
                            </article>
                        @endforeach
                    @endif
                </div>

                <!-- ==========================================
                     TAB: DELIVERY ADDRESS
                     ========================================== -->
                <div id="tab-address" class="tab-content">
                    <div class="subtab-header-card">
                        <button type="button" class="btn-back-overview nav-tab-btn" data-target="overview">
                            <i class="bi bi-chevron-left"></i> Dashboard
                        </button>
                        <h2 class="subtab-title">Delivery Address</h2>
                        <div style="width: 28px; flex: 0 0 28px;"></div>
                    </div>

                    @if(!empty($user->address))
                        <!-- Saved Address Card -->
                        <div class="settings-card mb-3" id="savedAddressCard">
                            <div class="d-flex justify-content-between align-items-center mb-3">
                                <span class="badge bg-success px-3 py-2 rounded-pill fw-bold" style="font-size: 0.76rem;">
                                    <i class="bi bi-check-circle-fill me-1"></i> Default Delivery Address
                                </span>
                                <button type="button" class="btn btn-outline-danger btn-sm px-3 fw-bold rounded-3" onclick="toggleEditAddress(true)" style="font-size: 0.82rem;">
                                    <i class="bi bi-pencil-square me-1"></i> Edit Address
                                </button>
                            </div>

                            <div class="p-3 bg-light rounded-3 border" style="font-size: 0.92rem; line-height: 1.6;">
                                <div class="fw-bold text-dark fs-6">{{ $user->first_name }} {{ $user->last_name }}</div>
                                <div class="text-secondary mt-1"><i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ $user->address }}</div>
                                <div class="text-secondary fw-semibold"><i class="bi bi-building text-muted me-1"></i> {{ $user->city }}</div>
                                <div class="mt-2 text-dark">
                                    <i class="bi bi-telephone-fill text-muted me-1"></i> <strong>{{ $user->pri_mobile }}</strong>
                                    @if($user->sec_mobile)
                                        &bull; <span class="text-muted">{{ $user->sec_mobile }}</span>
                                    @endif
                                </div>
                            </div>
                        </div>
                    @endif

                    <!-- Address Add / Edit Form Card -->
                    <div class="settings-card" id="addressFormCard" style="{{ !empty($user->address) ? 'display: none;' : '' }}">
                        <div class="d-flex justify-content-between align-items-center mb-3">
                            <h3 style="font-size: 1.05rem; font-weight: 800; color: #191919; margin: 0;">
                                <i class="bi bi-geo-alt-fill text-danger me-1"></i> {{ !empty($user->address) ? 'Edit Delivery Address' : 'Add New Delivery Address' }}
                            </h3>
                            @if(!empty($user->address))
                                <button type="button" class="btn btn-link text-muted btn-sm p-0 fw-bold text-decoration-none" onclick="toggleEditAddress(false)">
                                    Cancel
                                </button>
                            @endif
                        </div>
                        
                        @if(empty($user->address))
                            <div class="alert alert-warning p-3 rounded-3 mb-3" style="font-size: 0.85rem; border: 1px solid #fef08a; background: #fefce8; color: #854d0e;">
                                <i class="bi bi-info-circle-fill me-1"></i> You haven't saved a delivery address yet. Please save your default delivery details below for faster 1-click checkout!
                            </div>
                        @endif

                        <form action="{{ route('profile') }}" method="POST">
                            @csrf
                            <input type="hidden" name="first_name" value="{{ $user->first_name }}">
                            <input type="hidden" name="last_name" value="{{ $user->last_name }}">

                            <div class="form-group">
                                <label class="form-label" for="addr_input">Delivery Address (භාණ්ඩ එවිය යුතු ලිපිනය) *</label>
                                <textarea name="address" id="addr_input" class="form-control" rows="3" placeholder="House no, Street name, Village or Town" required>{{ old('address', $user->address) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="city_input">City (නගරය) *</label>
                                        <input type="text" name="city" id="city_input" class="form-control" value="{{ old('city', $user->city) }}" placeholder="e.g. Polonnaruwa" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="pri_mobile_input">Primary Mobile (දුරකථනය) *</label>
                                        <input type="tel" name="pri_mobile" id="pri_mobile_input" class="form-control" value="{{ old('pri_mobile', $user->pri_mobile) }}" placeholder="0706050500" required>
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="sec_mobile_input">Secondary Mobile (Optional)</label>
                                        <input type="tel" name="sec_mobile" id="sec_mobile_input" class="form-control" value="{{ old('sec_mobile', $user->sec_mobile) }}" placeholder="0771234567">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="action-btn btn-solid w-100 justify-content-center mt-3 py-2" style="border-radius: 12px; font-weight: 800;">
                                <i class="bi bi-check-circle"></i> Save Delivery Address
                            </button>
                        </form>
                    </div>
                </div>

                <!-- ==========================================
                     TAB 4: PROFILE SETTINGS
                     ========================================== -->
                <div id="tab-settings" class="tab-content">
                    <div class="subtab-header-card">
                        <button type="button" class="btn-back-overview nav-tab-btn" data-target="overview">
                            <i class="bi bi-chevron-left"></i> Dashboard
                        </button>
                        <h2 class="subtab-title">Profile Settings</h2>
                        <div style="width: 28px; flex: 0 0 28px;"></div>
                    </div>
                    
                    <div class="settings-card">
                        <form action="{{ route('profile') }}" method="POST">
                            @csrf
                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="first_name">First Name</label>
                                        <input type="text" name="first_name" id="first_name" class="form-control" value="{{ $user->first_name }}" required>
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="last_name">Last Name</label>
                                        <input type="text" name="last_name" id="last_name" class="form-control" value="{{ $user->last_name }}" required>
                                    </div>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="form-label">Email Address</label>
                                <input type="email" class="form-control" value="{{ $user->email }}" style="background-color: #f9fafb; color: #6b7280;" disabled>
                                <small style="color: #9ca3af; display: block; margin-top: 4px;">Email address cannot be changed.</small>
                            </div>

                            <div style="border-top: 1px solid #f0f0f0; margin: 1.5rem 0 1rem; padding-top: 1rem;">
                                <h3 style="font-size: 0.98rem; font-weight: 800; color: #191919; margin: 0;"><i class="bi bi-geo-alt-fill text-danger me-1"></i> Default Delivery Address</h3>
                                <small class="text-muted">Used for automatic checkout and island-wide COD delivery</small>
                            </div>

                            <div class="form-group">
                                <label class="form-label" for="address">Delivery Address (භාණ්ඩ එවිය යුතු ලිපිනය)</label>
                                <textarea name="address" id="address" class="form-control" rows="2" placeholder="House no, Street name, Village or Town">{{ old('address', $user->address) }}</textarea>
                            </div>

                            <div class="row">
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="city">City (නගරය)</label>
                                        <input type="text" name="city" id="city" class="form-control" value="{{ old('city', $user->city) }}" placeholder="e.g. Polonnaruwa">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="pri_mobile">Primary Mobile (දුරකථනය)</label>
                                        <input type="tel" name="pri_mobile" id="pri_mobile" class="form-control" value="{{ old('pri_mobile', $user->pri_mobile) }}" placeholder="0706050500">
                                    </div>
                                </div>
                                <div class="col-md-4">
                                    <div class="form-group">
                                        <label class="form-label" for="sec_mobile">Secondary Mobile</label>
                                        <input type="tel" name="sec_mobile" id="sec_mobile" class="form-control" value="{{ old('sec_mobile', $user->sec_mobile) }}" placeholder="0771234567">
                                    </div>
                                </div>
                            </div>

                            <div style="border-top: 1px solid #f0f0f0; margin: 1.5rem 0 1rem; padding-top: 1rem;">
                                <h3 style="font-size: 0.98rem; font-weight: 800; color: #191919; margin: 0;">Update Password</h3>
                                <small class="text-muted">Leave blank to keep your current password</small>
                            </div>

                            <div class="row">
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="password">New Password</label>
                                        <input type="password" name="password" id="password" class="form-control" placeholder="••••••">
                                    </div>
                                </div>
                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="form-label" for="password_confirmation">Confirm New Password</label>
                                        <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="••••••">
                                    </div>
                                </div>
                            </div>

                            <button type="submit" class="action-btn btn-solid w-100 justify-content-center mt-3 py-2" style="border-radius: 12px; font-weight: 800;">
                                <i class="bi bi-check-circle"></i> Save Changes
                            </button>
                        </form>
                    </div>
                </div>

            </main>
        </div>
    </div>
</div>
@endsection

@section('scripts')
<script>
    // Toggle Address Edit form visibility
    function toggleEditAddress(showForm) {
        if (showForm) {
            $('#addressFormCard').slideDown(250);
            $('#savedAddressCard').slideUp(250);
            $('#addr_input').focus();
        } else {
            $('#addressFormCard').slideUp(250);
            $('#savedAddressCard').slideDown(250);
        }
    }
    
    // Modern notification helpers using SweetAlert2
    function showCouponToast() {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                iconColor: '#f97316',
                title: 'Coupons Not Allowed Yet',
                text: 'Promotional coupons and vouchers are not active at the moment. Please stay tuned for upcoming discount offers!',
                confirmButtonColor: '#ff1944',
                confirmButtonText: 'OK, Got It',
                customClass: {
                    popup: 'rounded-4 shadow-lg border',
                    title: 'fw-bold fs-5 text-dark',
                    confirmButton: 'px-4 py-2 rounded-3 fw-bold'
                }
            });
        }
    }

    function showCustomAlert(msg) {
        if (typeof Swal !== 'undefined') {
            Swal.fire({
                icon: 'info',
                text: msg,
                confirmButtonColor: '#ff1944',
                confirmButtonText: 'OK'
            });
        }
    }

    // Filter Orders by Group/Category
    function applyOrderFilter(filter) {
        $('.order-filter-btn').removeClass('active');
        $('.order-filter-btn[data-filter="' + filter + '"]').addClass('active');

        let visibleCount = 0;
        const $cards = $('#ordersListContainer .order-item-card');

        if ($cards.length === 0) return;

        $cards.each(function() {
            const group = $(this).data('order-group');
            const isToReview = $(this).data('to-review') === true || $(this).data('to-review') === 'true';

            let show = false;
            if (filter === 'all') {
                show = true;
            } else if (filter === 'to_review') {
                show = isToReview;
            } else if (group === filter) {
                show = true;
            }

            if (show) {
                $(this).show();
                visibleCount++;
            } else {
                $(this).hide();
            }
        });

        if (visibleCount === 0) {
            let label = 'orders';
            if (filter === 'to_ship') label = 'orders waiting to be shipped';
            else if (filter === 'shipped') label = 'shipped orders in transit';
            else if (filter === 'delivered') label = 'delivered orders';
            else if (filter === 'to_review') label = 'delivered orders pending review';
            else if (filter === 'returns') label = 'returned orders';

            $('#noFilteredOrdersText').text('No ' + label + ' found.');
            $('#noFilteredOrdersMessage').show();
        } else {
            $('#noFilteredOrdersMessage').hide();
        }
    }

    $(function() {
        // Tab Switching logic with sub-filter support
        $('.nav-tab-btn').on('click', function(e) {
            e.preventDefault();
            e.stopPropagation();
            
            const target = $(this).data('target');
            if (!target) return;

            const filter = $(this).data('filter');

            // Toggle nav buttons in sidebar
            $('.dashboard-sidebar .nav-tab-btn').removeClass('active');
            $('.dashboard-sidebar .nav-tab-btn[data-target="' + target + '"]').addClass('active');

            // Scroll window to top of dashboard wrapper for natural app transition
            window.scrollTo({ top: 0, behavior: 'smooth' });

            // Toggle tab contents
            $('.tab-content').removeClass('active');
            $('#tab-' + target).addClass('active');

            // If an order filter was specified (e.g. from To Ship, Shipped, Delivered, To review, Returns)
            if (target === 'orders' && filter) {
                applyOrderFilter(filter);
            }
        });

        // Filter pills click handler inside Orders Tab
        $(document).on('click', '.order-filter-btn', function(e) {
            e.preventDefault();
            const filter = $(this).data('filter');
            applyOrderFilter(filter);
        });
    });
</script>
@endsection
