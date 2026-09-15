/**
 * Loku Kade Landing Page - Interactive Logic
 */

// Global product image error handler — must be defined BEFORE DOMContentLoaded
// so onerror attributes in static HTML can call it immediately on page load.
window.handleImageError = function(img) {
  const parent = img.parentNode;
  if (parent) {
    parent.innerHTML = `
      <div class="product-placeholder">
        <i class="bi bi-box-seam"></i>
        <span>Loku Kade</span>
      </div>
    `;
  }
};

document.addEventListener('DOMContentLoaded', () => {
  // --- 1. HEADER SCROLL EFFECT ---
  const header = document.querySelector('header');
  const scrollThreshold = 50;

  const handleScroll = () => {
    if (window.scrollY > scrollThreshold) {
      header.classList.add('scrolled');
    } else {
      header.classList.remove('scrolled');
    }
  };

  window.addEventListener('scroll', handleScroll);
  handleScroll(); // Initial check on load


  // --- 2. MOBILE NAVIGATION DRAWER ---
  const menuBtn = document.getElementById('menuBtn');
  const navDrawer = document.getElementById('navDrawer');
  const menuIcon = menuBtn?.querySelector('i');

  if (menuBtn && navDrawer) {
    menuBtn.addEventListener('click', () => {
      navDrawer.classList.toggle('open');
      
      // Toggle menu icon between list and x-circle
      if (navDrawer.classList.contains('open')) {
        menuIcon.className = 'bi bi-x-lg';
      } else {
        menuIcon.className = 'bi bi-list';
      }
    });

    // Close menu when clicking link
    navDrawer.querySelectorAll('a').forEach(link => {
      link.addEventListener('click', () => {
        navDrawer.classList.remove('open');
        menuIcon.className = 'bi bi-list';
      });
    });
  }


  // --- 3. SCROLL REVEAL ANIMATIONS ---
  const revealElements = document.querySelectorAll('.reveal');

  const revealOnScroll = () => {
    const triggerBottom = (window.innerHeight / 10) * 8.5; // Trigger at 85% depth

    revealElements.forEach(el => {
      const elTop = el.getBoundingClientRect().top;
      if (elTop < triggerBottom) {
        el.classList.add('active');
      }
    });
  };

  // Add scroll listener and run once initially
  window.addEventListener('scroll', revealOnScroll);
  revealOnScroll();


  // --- 4. TESTIMONIAL SLIDER ---
  const track = document.getElementById('testimonialTrack');
  const slides = Array.from(track?.children || []);
  const btnPrev = document.getElementById('sliderPrev');
  const btnNext = document.getElementById('sliderNext');
  const dotsContainer = document.getElementById('sliderDots');
  
  if (track && slides.length > 0) {
    let currentIndex = 0;
    const totalSlides = slides.length;

    // Create Navigation Dots
    slides.forEach((_, index) => {
      const dot = document.createElement('span');
      dot.className = `slider-dot ${index === 0 ? 'active' : ''}`;
      dot.setAttribute('data-slide-to', index);
      dotsContainer.appendChild(dot);
      
      dot.addEventListener('click', () => {
        goToSlide(index);
      });
    });

    const dots = Array.from(dotsContainer.children);

    const updateControlsAndDots = () => {
      dots.forEach((dot, idx) => {
        if (idx === currentIndex) {
          dot.classList.add('active');
        } else {
          dot.classList.remove('active');
        }
      });
    };

    const goToSlide = (index) => {
      if (index < 0) index = totalSlides - 1;
      if (index >= totalSlides) index = 0;
      
      currentIndex = index;
      track.style.transform = `translateX(-${currentIndex * 100}%)`;
      updateControlsAndDots();
    };

    btnPrev?.addEventListener('click', () => {
      goToSlide(currentIndex - 1);
    });

    btnNext?.addEventListener('click', () => {
      goToSlide(currentIndex + 1);
    });

    // Auto play every 6 seconds
    let autoPlayInterval = setInterval(() => {
      goToSlide(currentIndex + 1);
    }, 6000);

    // Pause autoplay on hover
    const container = document.querySelector('.slider-container');
    container?.addEventListener('mouseenter', () => {
      clearInterval(autoPlayInterval);
    });

    container?.addEventListener('mouseleave', () => {
      autoPlayInterval = setInterval(() => {
        goToSlide(currentIndex + 1);
      }, 6000);
    });
  }


  // --- 5. FAQ ACCORDION ---
  const faqItems = document.querySelectorAll('.faq-item');

  faqItems.forEach(item => {
    const headerEl = item.querySelector('.faq-header');
    const bodyEl = item.querySelector('.faq-body');

    headerEl?.addEventListener('click', () => {
      const isActive = item.classList.contains('active');

      // Close all other active items
      faqItems.forEach(otherItem => {
        if (otherItem !== item && otherItem.classList.contains('active')) {
          otherItem.classList.remove('active');
          const otherBody = otherItem.querySelector('.faq-body');
          if (otherBody) otherBody.style.maxHeight = '0';
        }
      });

      // Toggle current item
      if (isActive) {
        item.classList.remove('active');
        if (bodyEl) bodyEl.style.maxHeight = '0';
      } else {
        item.classList.add('active');
        if (bodyEl) {
          // Dynamic height scrollHeight calculation
          bodyEl.style.maxHeight = bodyEl.scrollHeight + 'px';
        }
      }
    });
  });

  // --- 6. DYNAMIC PRODUCTS LOADING ---
  const productsGrid = document.getElementById('productsGrid');
  const baseUrl = ''; // base URL of Laravel app

  const loadFeaturedProducts = async () => {
    if (!productsGrid) return;

    try {
      const response = await fetch(`${baseUrl}/api/featured-products`);
      if (!response.ok) {
        throw new Error('Failed to fetch featured products');
      }

      const products = await response.json();
      if (!Array.isArray(products) || products.length === 0) {
        throw new Error('No products returned');
      }

      // Clear static products
      productsGrid.innerHTML = '';

      products.forEach((product) => {
        // Find first image
        const imgUrl = product.main_image_url || (product.images && product.images[0]);
        
        // Handle discount percentage and prices
        let discountBadge = '';
        if (product.has_discount && product.discount_percentage > 0) {
          discountBadge = `<span class="badge-discount">-${product.discount_percentage}%</span>`;
        }

        const priceSale = `Rs. ${parseFloat(product.discounted_price || product.price).toLocaleString()}`;
        const priceOriginal = product.has_discount && product.price 
          ? `<span class="price-retail">Rs. ${parseFloat(product.price).toLocaleString()}</span>` 
          : '';

        // Form WhatsApp URL
        const whatsappText = encodeURIComponent(`Hi, I'm interested in buying the product: ${product.product_name} (ID: ${product.id})`);
        const whatsappUrl = `https://wa.me/94706050500?text=${whatsappText}`;

        // Form Product URL
        const productUrl = product.public_url || `/shop/product/${product.id}`;

        // Create product card
        const card = document.createElement('article');
        card.className = 'product-item reveal active';
        card.id = `dynamic-product-${product.id}`;
        card.style.cursor = 'pointer';
        card.addEventListener('click', (e) => {
          if (!e.target.closest('a, button')) {
            window.location.href = productUrl;
          }
        });

        // Dynamic Image or Placeholder
        let imageHtml = '';
        if (imgUrl && imgUrl.trim() !== '') {
          imageHtml = `<img src="${imgUrl}" alt="${product.product_name}" onerror="handleImageError(this)">`;
        } else {
          imageHtml = `
            <div class="product-placeholder">
              <i class="bi bi-box-seam"></i>
              <span>Loku Kade</span>
            </div>
          `;
        }
        
        // Generate stars HTML
        let ratingHtml = '';
        const avg = parseFloat(product.avg_rating || 0);
        const count = parseInt(product.reviews_count || 0);
        const sold = parseInt(product.sales_volume || 0);
        let soldRowHtml = '';
        if (sold > 0) {
          soldRowHtml = `<div class="sold-row" style="margin-bottom: 2px;"><span class="fw-bold" style="background: #f3f4f6; padding: 1px 5px; border-radius: 4px; font-size: 0.68rem; color:#374151;">${sold} sold</span></div>`;
        }
        if (count > 0) {
          const fullStars = Math.floor(avg);
          const hasHalfStar = avg % 1 >= 0.5;
          const emptyStars = 5 - fullStars - (hasHalfStar ? 1 : 0);
          
          let starsMarkup = '';
          for (let i = 0; i < fullStars; i++) {
            starsMarkup += '<i class="bi bi-star-fill" style="font-size: 0.65rem; color:#f59e0b; margin-right: 1px;"></i>';
          }
          if (hasHalfStar) {
            starsMarkup += '<i class="bi bi-star-half" style="font-size: 0.65rem; color:#f59e0b; margin-right: 1px;"></i>';
          }
          for (let i = 0; i < emptyStars; i++) {
            starsMarkup += '<i class="bi bi-star" style="font-size: 0.65rem; color:#d1d5db; margin-right: 1px;"></i>';
          }
          ratingHtml = `
            ${soldRowHtml}
            <div class="product-rating" style="font-size: 0.72rem; color: #6b7280; display: flex; align-items: center; gap: 4px; line-height: 1;">
              <span class="fw-bold" style="color:#111827;">${avg}</span>
              <span style="display: inline-flex; align-items: center;">${starsMarkup}</span>
              <span>(${count})</span>
            </div>
          `;
        } else {
          ratingHtml = `
            ${soldRowHtml}
            <div class="product-rating" style="font-size: 0.72rem; color: #9ca3af; display: flex; align-items: center; gap: 4px; line-height: 1;">
              <span style="display: inline-flex; align-items: center;">
                <i class="bi bi-star" style="font-size: 0.65rem; color:#d1d5db; margin-right: 1px;"></i>
                <i class="bi bi-star" style="font-size: 0.65rem; color:#d1d5db; margin-right: 1px;"></i>
                <i class="bi bi-star" style="font-size: 0.65rem; color:#d1d5db; margin-right: 1px;"></i>
                <i class="bi bi-star" style="font-size: 0.65rem; color:#d1d5db; margin-right: 1px;"></i>
                <i class="bi bi-star" style="font-size: 0.65rem; color:#d1d5db; margin-right: 1px;"></i>
              </span>
              <span>(0)</span>
            </div>
          `;
        }
        const inStock = (parseInt(product.total_quantity || 0) > 0);
        
        let statusBadgeHtml = '';
        if (inStock) {
          statusBadgeHtml = `
            <span class="stock-badge-green" style="font-size: 0.72rem; padding: 2px 6px; font-weight: 600; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
              <i class="bi bi-check-circle-fill" style="color: #10b981; font-size: 0.65rem;"></i> In Stock
            </span>
          `;
        } else {
          statusBadgeHtml = `
            <span class="stock-badge-red" style="font-size: 0.72rem; padding: 2px 6px; font-weight: 600; border-radius: 4px; display: inline-flex; align-items: center; gap: 4px;">
              <i class="bi bi-x-circle-fill" style="color: #ef4444; font-size: 0.65rem;"></i> Out of Stock
            </span>
          `;
        }

        let cartBtnHtml = '';
        if (inStock) {
          cartBtnHtml = `
            <button type="button" class="circle-action-btn" 
                    style="width: 32px; height: 32px; border-radius: 50%; border: none; background: #374151; color: #fff; display: inline-flex; align-items: center; justify-content: center; cursor: pointer; padding: 0 !important; line-height: 1 !important;"
                    onclick="window.addToCart({
                      product_id: ${product.id},
                      stock_id: ${product.best_stock_id || 'null'},
                      product_name: '${product.product_name.replace(/'/g, "\\'")}',
                      selling_price: ${parseFloat(product.discounted_price || product.price || 0)},
                      quantity: 1,
                      image: '${imgUrl || ''}',
                      max_qty: ${parseInt(product.total_quantity || 999)}
                    })"
                    data-tooltip="Add to Cart">
              <i class="bi bi-cart-plus-fill"></i>
            </button>
          `;
        }

        card.innerHTML = `
          <a href="${productUrl}" class="product-media text-decoration-none d-block">
            ${discountBadge}
            ${imageHtml}
          </a>
          <div class="product-details">
            <span class="product-category">Featured</span>
            <h3 class="product-title">
              <a href="${productUrl}" class="text-decoration-none text-dark d-block" style="color: inherit;">
                ${product.product_name}
              </a>
            </h3>
            <div class="price-container">
              <span class="price-sale">${priceSale}</span>
              ${priceOriginal}
            </div>
            ${ratingHtml}
            <div class="product-card-footer" style="display: flex; justify-content: space-between; align-items: center; margin-top: auto; padding-top: 12px; border-top: 1px solid #f3f4f6;">
              <div class="product-status-badge">
                ${statusBadgeHtml}
              </div>
              <div style="display: flex; gap: 6px; align-items: center;">
                ${cartBtnHtml}
                <a href="${whatsappUrl}" target="_blank" class="circle-action-btn" 
                   style="width: 32px; height: 32px; border-radius: 50%; background-color: #25d366; color: #fff; display: inline-flex; align-items: center; justify-content: center; text-decoration: none; cursor: pointer;"
                   data-tooltip="WhatsApp Order">
                  <i class="bi bi-whatsapp" style="font-size: 1rem;"></i>
                </a>
              </div>
            </div>
          </div>
        `;

        productsGrid.appendChild(card);
      });
      
    } catch (error) {
      console.warn('Dynamic products load failed, showing products redirect banner:', error);
      productsGrid.innerHTML = `
        <div class="api-fail-banner text-center" style="grid-column: 1 / -1; background: var(--neutral-white); border: 1px solid var(--neutral-border); border-radius: var(--border-radius-lg); padding: 3.5rem 2rem; box-shadow: var(--shadow-md); text-align: center; display: flex; flex-direction: column; align-items: center; justify-content: center; gap: 1rem; width: 100%;">
          <i class="bi bi-shop-window" style="font-size: 3.5rem; color: var(--primary-glow); display: block;"></i>
          <h3 style="font-family: var(--font-display); font-size: 1.8rem; font-weight: 700; color: var(--primary-base); margin: 0.5rem 0 0;">Browse Our Full Store</h3>
          <p style="color: var(--neutral-muted); font-size: 1rem; max-width: 520px; line-height: 1.7; margin: 0 auto 1rem;">
            We are currently updating our featured products list. Head over to our main online store to view 100+ premium household items and smart accessories!
          </p>
          <a href="/shop" class="btn btn-primary" style="display: inline-flex; align-items: center; gap: 0.6rem; padding: 0.85rem 2.2rem; font-weight: 600;">
            <i class="bi bi-grid-3x3-gap-fill"></i> View All Products
          </a>
        </div>
      `;
    }
  };

  // --- 7. ORDER TRACKING LOGIC ---
  const orderTrackForm = document.getElementById('orderTrackForm');
  const trackQueryInput = document.getElementById('trackQueryInput');
  const trackResultContainer = document.getElementById('trackResultContainer');
  const trackSubmitBtn = document.getElementById('trackSubmitBtn');

  if (orderTrackForm && trackQueryInput && trackResultContainer) {
    orderTrackForm.addEventListener('submit', async (e) => {
      e.preventDefault();
      
      const query = trackQueryInput.value.trim();
      if (!query) return;

      // Show Loading State
      trackSubmitBtn.disabled = true;
      const originalBtnText = trackSubmitBtn.innerHTML;
      trackSubmitBtn.innerHTML = `<i class="bi bi-arrow-repeat spin"></i> Searching...`;
      trackResultContainer.style.display = 'block';
      trackResultContainer.innerHTML = `
        <div class="text-center py-4">
          <div class="spinner-border text-danger" role="status" style="width: 2.5rem; height: 2.5rem; border-width: 0.25em; border-right-color: transparent; border-radius: 50%; display: inline-block; animation: spin 1s linear infinite;"></div>
          <p class="mt-2 text-muted" style="font-size: 0.95rem;">Checking order database...</p>
        </div>
      `;

      try {
        const response = await fetch(`${baseUrl}/api/track-order?query=${encodeURIComponent(query)}`);
        const data = await response.json();

        if (response.status === 200 && data.orders && data.orders.length > 0) {
          let html = '';
          
          data.orders.forEach((order, index) => {
            const isLatest = index === 0;
            
            // Determine stepper status progress
            const courierStatus = (order.courier_status || '').toLowerCase().trim();
            
            let step1Class = 'completed';
            let step2Class = '';
            let step3Class = '';
            let progressWidth = '0%';
            let showTimeline = true;
            let badgeClass = 'pending';

            if (courierStatus === 'pending') {
              step1Class = 'active';
              progressWidth = '0%';
              badgeClass = 'pending';
            } else if (courierStatus === 'processing') {
              step1Class = 'completed';
              step2Class = 'active';
              progressWidth = '25%';
              badgeClass = 'processing';
            } else if (courierStatus === 'dispatched' || courierStatus === 'shipped') {
              step1Class = 'completed';
              step2Class = 'active completed';
              progressWidth = '50%';
              badgeClass = 'dispatched';
            } else if (courierStatus === 'out for delivery' || courierStatus === 'out_for_delivery') {
              step1Class = 'completed';
              step2Class = 'completed';
              step3Class = 'active';
              progressWidth = '75%';
              badgeClass = 'out-for-delivery';
            } else if (courierStatus === 'not delivered' || courierStatus === 'not_delivered') {
              step1Class = 'completed';
              step2Class = 'completed';
              step3Class = 'active';
              progressWidth = '90%';
              badgeClass = 'not-delivered';
            } else if (
              courierStatus === 'delivered' || 
              courierStatus === 'completed' || 
              courierStatus === 'return collected' || 
              courierStatus === 'return_collected'
            ) {
              step1Class = 'completed';
              step2Class = 'completed';
              step3Class = 'active completed';
              progressWidth = '100%';
              badgeClass = 'delivered';
            } else if (
              courierStatus === 'returned' || 
              courierStatus === 'canceled' || 
              courierStatus === 'cancelled'
            ) {
              showTimeline = false;
              badgeClass = (courierStatus === 'returned') ? 'returned' : 'canceled';
            } else {
              // Custom fallback status
              step1Class = 'completed';
              step2Class = 'active';
              progressWidth = '25%';
              badgeClass = 'pending';
            }

            // Masked name or placeholder
            const custName = order.customer_name || 'Customer';
            const trackingNo = order.tracking_number || 'Not Dispatched Yet';

            // Items breakdown
            let itemsHtml = '';
            if (order.items && order.items.length > 0) {
              order.items.forEach(item => {
                itemsHtml += `
                  <div class="track-product-row">
                    <span>${item.product_name} <strong>x${item.quantity}</strong></span>
                    <strong>Rs. ${(parseFloat(item.amount || (item.selling_price * item.quantity))).toLocaleString()}</strong>
                  </div>
                `;
              });
            } else {
              itemsHtml = `<div class="text-muted text-center py-2">Product details unavailable</div>`;
            }

            html += `
              <div class="track-order-item">
                <div class="track-item-header" style="cursor: pointer; user-select: none; display: flex; justify-content: space-between; align-items: center;" onclick="toggleOrderCollapse('${order.order_number}')">
                  <span class="track-order-no">Order ${order.order_number}</span>
                  <div style="display: flex; align-items: center; gap: 0.8rem;">
                    <span class="track-status-badge ${badgeClass}">${order.courier_status}</span>
                    <i class="bi ${isLatest ? 'bi-chevron-up' : 'bi-chevron-down'}" id="trackOrderIcon-${order.order_number}" style="font-size: 1.2rem; color: var(--neutral-muted);"></i>
                  </div>
                </div>

                <div class="track-order-body" id="trackOrderBody-${order.order_number}" style="${isLatest ? 'margin-top: 1.5rem; border-top: 1px dashed var(--neutral-border); padding-top: 1.5rem;' : 'display: none; margin-top: 1.5rem; border-top: 1px dashed var(--neutral-border); padding-top: 1.5rem;'}">
                  ${!order.is_shipping_available ? `
                    <div class="alert alert-warning text-center mb-4 py-2" style="background-color: #fffbeb; border: 1px solid #fde68a; color: #92400e; border-radius: 8px; font-weight: 600; font-size: 0.9rem;">
                      <i class="bi bi-info-circle-fill me-1"></i> Tracking unavailable for delivery method: <strong>${order.shipping_type || 'In-Store Pickup'}</strong>. Live tracking is only for Courier & Dropship orders.
                    </div>
                  ` : (order.live_tracking && order.live_tracking.timeline && order.live_tracking.timeline.length > 0) ? `
                    <div style="background: #fafbfc; border: 1px solid #e2e8f0; border-radius: 12px; padding: 10px 14px; margin-bottom: 1.25rem; display: flex; justify-content: space-between; align-items: center; flex-wrap: wrap; gap: 8px;">
                      <div>
                        <strong style="color: #111827; font-size: 0.88rem;">${order.live_tracking.provider_name}</strong>
                        <div style="font-size: 0.76rem; color: #64748b;">Tracking ID: <strong>${order.live_tracking.tracking_number}</strong></div>
                      </div>
                      ${order.live_tracking.direct_url ? `
                        <a href="${order.live_tracking.direct_url}" target="_blank" style="font-size: 0.75rem; font-weight: 700; background: #fff; border: 1px solid #cbd5e1; padding: 4px 8px; border-radius: 6px; color: #0f172a; text-decoration: none;">
                          <i class="bi bi-box-arrow-up-right"></i> Official Portal
                        </a>
                      ` : ''}
                    </div>

                    <div style="margin-bottom: 1.25rem; max-height: 220px; overflow-y: auto; padding-right: 4px;">
                      ${order.live_tracking.timeline.slice(0, 5).map((evt, idx) => `
                        <div style="display: flex; gap: 10px; margin-bottom: 8px; font-size: 0.8rem; background: ${idx === 0 ? '#f0fdf4' : '#f8fafc'}; border: 1px solid ${idx === 0 ? '#dcfce7' : '#f1f5f9'}; border-radius: 8px; padding: 8px 10px;">
                          <i class="bi bi-geo-alt-fill text-success" style="font-size: 0.9rem; flex: 0 0 auto;"></i>
                          <div style="flex: 1; min-width: 0;">
                            <div style="font-weight: 700; color: ${idx === 0 ? '#15803d' : '#1e293b'};">${evt.status}</div>
                            <div style="font-size: 0.72rem; color: #64748b;">${evt.human_time} ${evt.location ? '• ' + evt.location : ''}</div>
                          </div>
                        </div>
                      `).join('')}
                    </div>
                  ` : (showTimeline ? `
                    <div class="track-stepper">
                      <div class="track-step-progress-bar">
                        <div class="track-step-progress" style="width: ${progressWidth};"></div>
                      </div>
                      <div class="track-step ${step1Class}">
                        <div class="track-step-dot"><i class="bi bi-file-earmark-check"></i></div>
                        <span class="track-step-label">Order Received</span>
                      </div>
                      <div class="track-step ${step2Class}">
                        <div class="track-step-dot"><i class="bi bi-truck"></i></div>
                        <span class="track-step-label">Dispatched</span>
                      </div>
                      <div class="track-step ${step3Class}">
                        <div class="track-step-dot"><i class="bi bi-house-check"></i></div>
                        <span class="track-step-label">Delivered</span>
                      </div>
                    </div>
                  ` : `
                    <div class="alert alert-danger text-center mb-4 py-2" style="background-color: #fef2f2; border: 1px solid #fecaca; color: #dc2626; border-radius: 8px; font-weight: 600; font-size: 0.95rem;">
                      <i class="bi bi-exclamation-triangle-fill me-1"></i> Order is marked as: ${order.courier_status}
                    </div>
                  `)}

                  <div class="track-item-details">
                    <div class="track-detail-col">
                      <span>Customer Name</span>
                      <strong>${custName}</strong>
                    </div>
                    <div class="track-detail-col">
                      <span>Delivery Location</span>
                      <strong>${order.customer_city || '-'}</strong>
                    </div>
                    <div class="track-detail-col">
                      <span>Tracking ID</span>
                      <strong>${trackingNo}</strong>
                    </div>
                    <div class="track-detail-col">
                      <span>Total Amount</span>
                      <strong style="color: var(--accent-success);">Rs. ${parseFloat(order.total_amount).toLocaleString()}</strong>
                    </div>
                  </div>

                  <div class="track-products-list">
                    <div class="track-products-title">Items Ordered</div>
                    ${itemsHtml}
                  </div>
                </div>
              </div>
            `;
          });

          // Add global collapse toggle function inside window context
          window.toggleOrderCollapse = (orderNo) => {
            const body = document.getElementById(`trackOrderBody-${orderNo}`);
            const icon = document.getElementById(`trackOrderIcon-${orderNo}`);
            if (body && icon) {
              const isCollapsed = body.style.display === 'none';
              if (isCollapsed) {
                body.style.display = 'block';
                icon.className = 'bi bi-chevron-up';
              } else {
                body.style.display = 'none';
                icon.className = 'bi bi-chevron-down';
              }
            }
          };

          trackResultContainer.innerHTML = html;
        } else {
          throw new Error(data.message || 'No orders found.');
        }
      } catch (error) {
        trackResultContainer.innerHTML = `
          <div class="track-error-box">
            <i class="bi bi-exclamation-circle-fill d-block fs-3 mb-2"></i>
            Order not found. Please verify the mobile number or Order ID (e.g. ORD-X-XXXX) and try again.
          </div>
        `;
      } finally {
        trackSubmitBtn.disabled = false;
        trackSubmitBtn.innerHTML = originalBtnText;
      }
    });
  }

  loadFeaturedProducts();
});
