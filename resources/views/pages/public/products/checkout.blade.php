@extends('layouts.frontend')

@section('title', 'Secure Checkout | Loku Kade')

@section('styles')
    <link href="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/css/select2.min.css" rel="stylesheet" />
    <link href="https://cdn.jsdelivr.net/npm/select2-bootstrap-5-theme@1.3.0/dist/select2-bootstrap-5-theme.min.css" rel="stylesheet" />
    
    <style>
        :root {
            --bg-base: #f9fafb;
            --neutral-card: #ffffff;
            --text-dark: #111827;
            --text-secondary: #4b5563;
            --accent: #dc2626;
            --accent-gradient: linear-gradient(135deg, #dc2626 0%, #f97316 100%);
            --radius-md: 12px;
            --radius-lg: 16px;
            --transition-smooth: all 0.25s cubic-bezier(0.4, 0, 0.2, 1);
        }

        body {
            background-color: var(--bg-base);
            font-family: 'Outfit', sans-serif;
            color: var(--text-dark);
        }

        .checkout-page-wrapper {
            margin-top: 155px;
            padding-bottom: 5rem;
        }

        .checkout-header {
            text-align: center;
            margin-bottom: 2.5rem;
            padding: 2rem 1.5rem;
            background: linear-gradient(135deg, #fffbeb 0%, #fff5f5 100%);
            border: 1px solid #fee2e2;
            border-radius: var(--radius-lg);
        }

        .checkout-header h1 {
            font-family: 'Space Grotesk', sans-serif;
            font-size: 2.2rem;
            font-weight: 700;
            margin-bottom: 0.5rem;
            background: var(--accent-gradient);
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
        }

        .checkout-card {
            background: var(--neutral-card);
            border: 1px solid #e5e7eb;
            border-radius: var(--radius-md);
            padding: 2rem;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05);
        }

        .checkout-card h3 {
            font-family: 'Space Grotesk', sans-serif;
            font-weight: 700;
            font-size: 1.25rem;
            color: var(--text-dark);
            border-bottom: 2px solid #f3f4f6;
            padding-bottom: 0.75rem;
            margin-bottom: 1.5rem;
        }

        /* --- Checkout Items list --- */
        .checkout-item {
            display: flex;
            gap: 1rem;
            padding-bottom: 1rem;
            margin-bottom: 1rem;
            border-bottom: 1px solid #f3f4f6;
        }

        .checkout-item-img {
            width: 64px;
            height: 64px;
            object-fit: cover;
            border-radius: 8px;
            background: #f9fafb;
            border: 1px solid #e5e7eb;
        }

        .checkout-item-details {
            flex-grow: 1;
        }

        .checkout-item-name {
            font-size: 0.92rem;
            font-weight: 700;
            color: var(--text-dark);
            margin-bottom: 0.25rem;
            line-height: 1.3;
        }

        .checkout-item-meta {
            font-size: 0.85rem;
            color: var(--text-secondary);
        }

        /* --- Checkout Inputs --- */
        .form-label {
            font-weight: 600;
            font-size: 0.85rem;
            color: var(--text-secondary);
            margin-bottom: 0.4rem;
        }

        .form-control {
            border-radius: 8px;
            padding: 10px 14px;
            font-size: 0.92rem;
            border: 1.5px solid #e5e7eb;
            transition: var(--transition-smooth);
        }

        .form-control:focus {
            border-color: var(--accent);
            box-shadow: 0 0 0 3px rgba(220, 38, 38, 0.08);
        }

        .btn-submit-order {
            background: var(--accent-gradient);
            border: none;
            color: #ffffff;
            font-weight: 700;
            font-size: 1rem;
            padding: 14px;
            border-radius: 10px;
            width: 100%;
            transition: opacity 0.2s ease;
        }

        .btn-submit-order:hover {
            opacity: 0.95;
            color: #ffffff;
        }

        .btn-remove-checkout-item i {
            transition: color 0.2s ease;
        }

        .btn-remove-checkout-item:hover i {
            color: #dc2626 !important;
        }
    </style>
@endsection

@section('content')
<div class="checkout-page-wrapper">
    <div class="container">
        
        <!-- Header -->
        <div class="checkout-header">
            <h1>Confirm Your COD Order</h1>
            <p>Please enter your delivery details to complete your order. Shipping is 100% Free island-wide.</p>
        </div>

        <div id="checkoutContent" style="display: none;">
            <div class="row g-4">
                
                <!-- Left Column: Delivery Form -->
                <div class="col-12 col-md-7">
                    <div class="checkout-card">
                        <h3><i class="bi bi-geo-alt-fill text-danger me-2"></i> 1. Delivery &amp; Customer Details</h3>
                        <form id="checkoutSubmitForm" enctype="multipart/form-data">
                            @csrf
                            <input type="hidden" name="shipping_type" value="Courier">
                            
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Full Name (ඔබේ නම) *</label>
                                    <input type="text" name="customer_name" class="form-control" placeholder="Enter your full name" required autocomplete="name" value="{{ old('customer_name', $user ? ($user->first_name . ' ' . $user->last_name) : '') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Email Address (ඊමේල් ලිපිනය - Optional)</label>
                                    <input type="email" name="customer_email" class="form-control" placeholder="e.g. customer@example.com" autocomplete="email" value="{{ old('customer_email', $user ? $user->email : '') }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Delivery Address (භාණ්ඩ එවිය යුතු ලිපිනය) *</label>
                                    <textarea name="customer_address" class="form-control" rows="3" placeholder="House number, Street name, Village or Town" required>{{ old('customer_address', $savedAddress) }}</textarea>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label">City (නගරය) *</label>
                                    <select class="form-select form-control" id="customer_city" name="customer_city" required>
                                        <option value="" selected disabled>Select City...</option>
                                    </select>
                                </div>
                                <div class="col-12 col-sm-6">
                                    <label class="form-label">Primary Mobile (දුරකථන අංකය) *</label>
                                    <input type="tel" name="customer_pri_mobile" class="form-control" placeholder="e.g. 0706050500" required autocomplete="tel" value="{{ old('customer_pri_mobile', $savedPriMobile) }}">
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Secondary Mobile Number (අතිරේක අංකය - Optional)</label>
                                    <input type="tel" name="customer_sec_mobile" class="form-control" placeholder="e.g. 0774872081" value="{{ old('customer_sec_mobile', $savedSecMobile) }}">
                                </div>

                                @auth
                                <div class="col-12 mt-2">
                                    <div class="form-check p-2 px-3 rounded-3" style="background: #f8fafc; border: 1.5px solid #e2e8f0;">
                                        <input class="form-check-input ms-0 me-2" type="checkbox" name="save_address" value="1" id="saveAddressCheck" checked style="accent-color: #dc2626; cursor: pointer; width: 18px; height: 18px;">
                                        <label class="form-check-label fw-bold text-dark" for="saveAddressCheck" style="font-size: 0.84rem; cursor: pointer; user-select: none;">
                                            <i class="bi bi-bookmark-check-fill text-danger me-1"></i> Save this address to my account for future orders
                                        </label>
                                    </div>
                                </div>
                                @endauth
                            </div>
                        </form>
                    </div>

                    <!-- Payment Method Section -->
                    <div class="checkout-card mt-3">
                        <h3><i class="bi bi-credit-card-fill text-danger me-2"></i> 2. Payment Method</h3>

                        <!-- Radio Buttons -->
                        <div class="d-flex gap-3 flex-wrap mt-1 mb-3">
                            <!-- COD Option -->
                            <label id="lbl-cod" class="payment-method-card selected" style="flex:1; min-width:140px; cursor:pointer; border:2px solid #dc2626; border-radius:12px; padding:14px 18px; display:flex; align-items:center; gap:12px; background:#fff7ed; transition:all 0.2s;">
                                <input type="radio" name="payment_type" value="COD" id="pay_cod" checked style="accent-color:#dc2626; width:18px; height:18px;">
                                <div>
                                    <div style="font-weight:700; font-size:0.95rem; color:#111827;">Cash on Delivery</div>
                                    <div style="font-size:0.78rem; color:#6b7280;">Pay when you receive</div>
                                </div>
                            </label>

                            <!-- Bank Transfer Option -->
                            <label id="lbl-bank" class="payment-method-card" style="flex:1; min-width:140px; cursor:pointer; border:2px solid #e5e7eb; border-radius:12px; padding:14px 18px; display:flex; align-items:center; gap:12px; background:#ffffff; transition:all 0.2s;">
                                <input type="radio" name="payment_type" value="Online Transfer" id="pay_bank" style="accent-color:#dc2626; width:18px; height:18px;">
                                <div>
                                    <div style="font-weight:700; font-size:0.95rem; color:#111827;">Bank Transfer</div>
                                    <div style="font-size:0.78rem; color:#6b7280;">Online payment via bank</div>
                                </div>
                            </label>
                        </div>

                        <!-- Bank Transfer Details Panel (hidden by default) -->
                        <div id="bankTransferPanel" style="display:none;">
                            <!-- Bank Account Info Card -->
                            @if($bankAccounts->count() > 0)
                            <div style="background:#f0fdf4; border:1.5px solid #86efac; border-radius:12px; padding:16px; margin-bottom:16px;">
                                <div style="font-weight:700; font-size:0.9rem; color:#166534; margin-bottom:10px;"><i class="bi bi-bank me-2"></i>Our Bank Account Details</div>
                                <table style="width:100%; border-collapse:collapse; font-size:0.88rem;">
                                    <thead>
                                        <tr style="background:rgba(134,239,172,0.25);">
                                            <th style="padding:8px 10px; text-align:left; color:#166534; font-weight:700; border-bottom:1px solid #bbf7d0;">Account Holder</th>
                                            <th style="padding:8px 10px; text-align:left; color:#166534; font-weight:700; border-bottom:1px solid #bbf7d0;">Account Number</th>
                                            <th style="padding:8px 10px; text-align:left; color:#166534; font-weight:700; border-bottom:1px solid #bbf7d0;">Bank</th>
                                            <th style="padding:8px 10px; text-align:left; color:#166534; font-weight:700; border-bottom:1px solid #bbf7d0;">Branch</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach($bankAccounts as $ba)
                                        <tr>
                                            <td style="padding:8px 10px; color:#1e293b; font-weight:600; border-bottom:1px solid #dcfce7;">{{ $ba->account_holder }}</td>
                                            <td style="padding:8px 10px; color:#166534; font-weight:700; font-family:monospace; border-bottom:1px solid #dcfce7;">{{ $ba->account_number }}</td>
                                            <td style="padding:8px 10px; color:#1e293b; border-bottom:1px solid #dcfce7;">{{ $ba->bank }}</td>
                                            <td style="padding:8px 10px; color:#1e293b; border-bottom:1px solid #dcfce7;">{{ $ba->branch }}</td>
                                        </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                            @endif

                            <!-- Receipt Number & Image -->
                            <div class="row g-3">
                                <div class="col-12">
                                    <label class="form-label">Transaction / Reference Number *</label>
                                    <input type="text" name="receipt_number" form="checkoutSubmitForm" id="receipt_number" class="form-control" placeholder="e.g. TXN123456789">
                                    <small class="text-muted">Enter the transaction reference number from your bank</small>
                                </div>
                                <div class="col-12">
                                    <label class="form-label">Attach Receipt Image *</label>
                                    <input type="file" name="receipt_image" form="checkoutSubmitForm" id="receipt_image" class="form-control" accept="image/*">
                                    <small class="text-muted">Upload a screenshot or photo of your bank transfer receipt (JPG, PNG, max 4MB)</small>
                                </div>
                                <!-- Receipt image preview -->
                                <div class="col-12" id="receiptPreviewWrap" style="display:none;">
                                    <img id="receiptPreview" src="" alt="Receipt Preview" style="max-width:100%; max-height:200px; border-radius:8px; border:1px solid #e5e7eb; object-fit:contain;">
                                </div>
                            </div>
                        </div>

                        <!-- Submit Button -->
                        <div class="mt-4">
                            <button type="submit" form="checkoutSubmitForm" id="btnSubmitCheckout" class="btn-submit-order">
                                <i class="bi bi-bag-check-fill me-2"></i> <span id="btnSubmitText">Confirm Cash on Delivery Order</span>
                            </button>
                        </div>
                    </div>
                </div>

                <!-- Right Column: Order Items Summary -->
                <div class="col-12 col-md-5">
                    <div class="checkout-card">
                        <h3><i class="bi bi-cart3 text-danger me-2"></i> 2. Order Summary</h3>
                        
                        <!-- Dynamic items list -->
                        <div id="checkoutItemsListContainer"></div>

                        <!-- Calculation box -->
                        <div class="p-3 bg-light rounded mt-3 border">
                            <div class="d-flex justify-content-between mb-2 small text-muted">
                                <span>Subtotal:</span>
                                <span id="checkoutSubtotal">Rs. 0.00</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small text-muted">
                                <span>Shipping:</span>
                                <span class="text-success fw-bold">Free (Courier)</span>
                            </div>
                            <div class="d-flex justify-content-between mb-2 small text-muted d-none" id="checkoutDiscountRow">
                                <span>Multi-Buy Discount:</span>
                                <span id="checkoutDiscountAmount" class="text-success fw-bold">-Rs. 0.00</span>
                            </div>
                            <hr class="my-2">
                            <div class="d-flex justify-content-between align-items-center">
                                <span class="fw-bold">Total Amount to Pay:</span>
                                <strong class="text-danger fs-5" id="checkoutGrandTotal">Rs. 0.00</strong>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>

        <!-- Empty State -->
        <div id="checkoutEmptyState" class="text-center py-5" style="display: none;">
            <div class="checkout-card max-width-600 mx-auto py-5">
                <i class="bi bi-cart-x text-muted mb-3" style="font-size: 4rem;"></i>
                <h2 class="fw-bold text-dark fs-3 mb-2">Your Shopping Cart is Empty</h2>
                <p class="text-secondary mb-4">Please add products to your cart before proceeding to checkout.</p>
                <a href="{{ route('products.shop') }}" class="btn btn-danger py-2 px-4 fw-bold" style="background: var(--accent-gradient); border: none; border-radius: 8px; text-decoration: none; color: #fff;">
                    <i class="bi bi-bag-fill me-1"></i> Go Shopping Now
                </a>
            </div>
        </div>

    </div>
</div>
@endsection

@section('scripts')
    <!-- Select2 JS Library -->
    <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script>

    @php
        $courierShipping = $shippings->firstWhere('type', 'Courier');
        $courierCharge = $courierShipping ? $courierShipping->amount : 350.00;
    @endphp

    <script>
        $(function() {
            const courierCharge = parseFloat("{{ $courierCharge }}");
            
            // --- Fetch Sri Lankan Cities dynamically via Select2 ---
            $.ajax({
                url: "{{ route('utilities.fetchCities') }}",
                method: 'GET',
                success: function(response) {
                    if (response && response.results) {
                        let options = '<option value="" selected disabled>Select City...</option>';
                        response.results.forEach(city => {
                            let cityName = city.text.split(' (')[0];
                            options += `<option value="${cityName}">${cityName}</option>`;
                        });
                        $('#customer_city').html(options);
                        
                        $('#customer_city').select2({
                            theme: 'bootstrap-5',
                            width: '100%',
                            placeholder: 'Select City',
                            tags: true,
                            dropdownParent: $('#customer_city').parent() 
                        });

                        // Pre-select user's saved city if available
                        const lastCity = "{{ $savedCity }}";
                        if (lastCity) {
                            if ($('#customer_city').find("option[value='" + lastCity + "']").length === 0) {
                                let newOption = new Option(lastCity, lastCity, true, true);
                                $('#customer_city').append(newOption).trigger('change');
                            } else {
                                $('#customer_city').val(lastCity).trigger('change');
                            }
                        }
                    }
                }
            });
            
            // Check cart items
            function getLocalCart() {
                try {
                    return JSON.parse(localStorage.getItem('lokukade_cart')) || [];
                } catch(e) {
                    return [];
                }
            }

            function renderCheckoutSummary() {
                const cart = getLocalCart();

                if (cart.length === 0) {
                    $('#checkoutContent').hide();
                    $('#checkoutEmptyState').show();
                    return;
                }

                $('#checkoutEmptyState').hide();
                $('#checkoutContent').show();

                // Render summary items
                const itemsContainer = $('#checkoutItemsListContainer');
                itemsContainer.empty();
                
                let subtotal = 0;
                let totalQty = 0;

                cart.forEach(item => {
                    subtotal += item.selling_price * item.quantity;
                    totalQty += item.quantity;

                    const imageHtml = item.image 
                        ? `<img src="${item.image}" alt="${item.product_name}" class="checkout-item-img">`
                        : `<div class="checkout-item-img d-flex align-items-center justify-content-center bg-light text-secondary"><i class="bi bi-image"></i></div>`;

                    const itemHtml = `
                        <div class="checkout-item" data-id="${item.product_id}">
                            ${imageHtml}
                            <div class="checkout-item-details">
                                <h4 class="checkout-item-name">${item.product_name}</h4>
                                <div class="checkout-item-meta">
                                    Qty: <strong>${item.quantity}</strong> &times; Rs. ${item.selling_price.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}
                                </div>
                            </div>
                            <div class="d-flex flex-column align-items-end justify-content-between" style="min-width: 100px;">
                                <button type="button" class="btn-remove-checkout-item border-0 bg-transparent text-muted p-1" onclick="window.removeCheckoutItem(${item.product_id})" title="Remove Item" style="cursor: pointer;">
                                    <i class="bi bi-trash fs-5 text-secondary"></i>
                                </button>
                                <div class="fw-bold text-dark small mt-1">
                                    Rs. ${(item.selling_price * item.quantity).toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2})}
                                </div>
                            </div>
                        </div>
                    `;
                    itemsContainer.append(itemHtml);
                });

                // Calculate calculations
                $('#checkoutSubtotal').text('Rs. ' + subtotal.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));

                let discount = 0;
                if (totalQty > 1) {
                    discount = courierCharge * (totalQty - 1);
                    $('#checkoutDiscountRow').removeClass('d-none');
                    $('#checkoutDiscountAmount').text('-Rs. ' + discount.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
                } else {
                    $('#checkoutDiscountRow').addClass('d-none');
                }

                const grandTotal = Math.max(0, subtotal - discount);
                $('#checkoutGrandTotal').text('Rs. ' + grandTotal.toLocaleString(undefined, {minimumFractionDigits: 2, maximumFractionDigits: 2}));
            }

            // Define global remove handler
            window.removeCheckoutItem = function(productId) {
                let cart = getLocalCart();
                cart = cart.filter(item => item.product_id !== productId);
                
                if (window.saveCart) {
                    window.saveCart(cart);
                } else {
                    localStorage.setItem('lokukade_cart', JSON.stringify(cart));
                }
                
                renderCheckoutSummary();
            };

            // Initial render
            renderCheckoutSummary();

            // --- Payment Method Radio Toggle ---
            $('input[name="payment_type"]').on('change', function() {
                const isBankTransfer = $(this).val() === 'Online Transfer';

                // Toggle panel visibility
                if (isBankTransfer) {
                    $('#bankTransferPanel').slideDown(250);
                    $('#lbl-bank').css({ border: '2px solid #dc2626', background: '#fff7ed' });
                    $('#lbl-cod').css({ border: '2px solid #e5e7eb', background: '#ffffff' });
                    $('#btnSubmitText').text('Confirm Bank Transfer Order');
                } else {
                    $('#bankTransferPanel').slideUp(250);
                    $('#lbl-cod').css({ border: '2px solid #dc2626', background: '#fff7ed' });
                    $('#lbl-bank').css({ border: '2px solid #e5e7eb', background: '#ffffff' });
                    $('#btnSubmitText').text('Confirm Cash on Delivery Order');
                }
            });

            // --- Receipt Image Preview ---
            $('#receipt_image').on('change', function() {
                const file = this.files[0];
                if (file) {
                    const reader = new FileReader();
                    reader.onload = function(e) {
                        $('#receiptPreview').attr('src', e.target.result);
                        $('#receiptPreviewWrap').show();
                    };
                    reader.readAsDataURL(file);
                } else {
                    $('#receiptPreviewWrap').hide();
                }
            });

            // Submit order
            $('#checkoutSubmitForm').on('submit', async function(e) {
                e.preventDefault();

                const submitBtn = $('#btnSubmitCheckout');
                const paymentType = $('input[name="payment_type"]:checked').val();

                // Validate bank transfer fields manually
                if (paymentType === 'Online Transfer') {
                    const receiptNum = $('#receipt_number').val().trim();
                    const receiptFile = $('#receipt_image')[0].files[0];

                    if (!receiptNum) {
                        Swal.fire({ title: 'Missing Receipt Number', text: 'Please enter the transaction reference number.', icon: 'warning', confirmButtonColor: '#e12a1a', background: '#fffcf9' });
                        return;
                    }
                    if (!receiptFile) {
                        Swal.fire({ title: 'Missing Receipt Image', text: 'Please attach your bank transfer receipt image.', icon: 'warning', confirmButtonColor: '#e12a1a', background: '#fffcf9' });
                        return;
                    }
                }

                submitBtn.prop('disabled', true).html(`<span class="spinner-border spinner-border-sm me-2" role="status" aria-hidden="true"></span> Processing Order...`);

                // Use FormData for multipart/form-data (file upload support)
                const formData = new FormData();
                formData.append('_token', $('input[name="_token"]').val());
                formData.append('customer_name', this.customer_name.value);
                formData.append('customer_email', this.customer_email.value);
                formData.append('customer_address', this.customer_address.value);
                formData.append('customer_city', this.customer_city.value);
                formData.append('customer_pri_mobile', this.customer_pri_mobile.value);
                formData.append('customer_sec_mobile', this.customer_sec_mobile.value);
                formData.append('shipping_type', 'Courier');
                formData.append('payment_type', paymentType);

                if (paymentType === 'Online Transfer') {
                    formData.append('receipt_number', $('#receipt_number').val());
                    const receiptFile = $('#receipt_image')[0].files[0];
                    if (receiptFile) {
                        formData.append('receipt_image', receiptFile);
                    }
                }

                // Append cart items
                const cartItems = getLocalCart();
                cartItems.forEach(function(item, index) {
                    formData.append(`items[${index}][product_id]`, item.product_id);
                    formData.append(`items[${index}][quantity]`, item.quantity);
                    formData.append(`items[${index}][selling_price]`, item.selling_price);
                    if (item.stock_id) formData.append(`items[${index}][stock_id]`, item.stock_id);
                });

                try {
                    const response = await $.ajax({
                        url: '{{ route("orders.store") }}',
                        method: 'POST',
                        data: formData,
                        processData: false,
                        contentType: false,
                    });

                    if (response.status === 200) {
                        localStorage.removeItem('lokukade_cart');

                        // Update nav header badge
                        if (typeof window.getCart === 'function') {
                            localStorage.setItem('lokukade_cart', '[]');
                        }

                        const isBankMsg = paymentType === 'Online Transfer'
                            ? '<br><small style="color:#166534;">Your receipt has been received. We will verify and confirm shortly.</small>'
                            : '';

                        Swal.fire({
                            title: 'Order Placed!',
                            html: `Your Order Number is:<br><strong style="font-size: 1.25rem; color: #dc2626;">${response.order_number}</strong><br><br>Thank you for shopping with Loku Kade!${isBankMsg}`,
                            icon: 'success',
                            confirmButtonText: 'Great!',
                            confirmButtonColor: '#e12a1a',
                            background: '#fffcf9',
                            color: '#111827'
                        }).then(() => {
                            // Redirect conditionally based on login status
                            @auth
                                window.location.href = '{{ route("profile") }}?success_order=' + response.order_number;
                            @else
                                window.location.href = '{{ route("products.shop") }}?success_order=' + response.order_number;
                            @endauth
                        });
                    } else {
                        Swal.fire({
                            title: 'Order Failed',
                            text: response.message || 'Unknown error',
                            icon: 'error',
                            confirmButtonText: 'Try Again',
                            confirmButtonColor: '#374151',
                            background: '#fffcf9',
                            color: '#111827'
                        });
                        submitBtn.prop('disabled', false).html(`<i class="bi bi-bag-check-fill me-2"></i> <span id="btnSubmitText">${paymentType === 'Online Transfer' ? 'Confirm Bank Transfer Order' : 'Confirm Cash on Delivery Order'}</span>`);
                    }
                } catch (err) {
                    console.error(err);
                    Swal.fire({
                        title: 'An Error Occurred',
                        text: err.responseJSON?.message || 'Server error, please check details or try again later.',
                        icon: 'error',
                        confirmButtonText: 'OK',
                        confirmButtonColor: '#374151',
                        background: '#fffcf9',
                        color: '#111827'
                    });
                    submitBtn.prop('disabled', false).html(`<i class="bi bi-bag-check-fill me-2"></i> <span id="btnSubmitText">${paymentType === 'Online Transfer' ? 'Confirm Bank Transfer Order' : 'Confirm Cash on Delivery Order'}</span>`);
                }
            });
        });
    </script>
@endsection
