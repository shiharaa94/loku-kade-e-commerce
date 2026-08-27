<!-- --- PWA IN-APP INSTALL BANNER (OPERA, CHROME, SAMSUNG, EDGE) --- -->
<style>
  .pwa-install-banner {
    position: fixed;
    bottom: 74px;
    left: 12px;
    right: 12px;
    max-width: 440px;
    margin: 0 auto;
    background: #ffffff;
    border: 1.5px solid #fed7aa;
    border-radius: 16px;
    box-shadow: 0 10px 25px -5px rgba(220, 38, 38, 0.18), 0 8px 16px -6px rgba(0, 0, 0, 0.08);
    padding: 10px 12px;
    display: none;
    align-items: center;
    justify-content: space-between;
    gap: 8px;
    z-index: 1050;
    animation: pwaSlideUp 0.4s cubic-bezier(0.16, 1, 0.3, 1) forwards;
  }
  @media (min-width: 768px) {
    .pwa-install-banner {
      bottom: 24px;
      right: 24px;
      left: auto;
      margin: 0;
    }
  }
  @keyframes pwaSlideUp {
    from { opacity: 0; transform: translateY(30px); }
    to { opacity: 1; transform: translateY(0); }
  }
  .pwa-banner-content {
    display: flex;
    align-items: center;
    gap: 10px;
    min-width: 0;
    flex: 1;
  }
  .pwa-banner-icon {
    width: 42px;
    height: 42px;
    border-radius: 10px;
    object-fit: cover;
    box-shadow: 0 2px 8px rgba(0,0,0,0.1);
    flex: 0 0 42px;
  }
  .pwa-banner-text {
    min-width: 0;
  }
  .pwa-banner-title {
    font-size: 0.88rem;
    font-weight: 800;
    color: #111827;
    margin: 0;
    line-height: 1.2;
    display: flex;
    align-items: center;
    gap: 4px;
  }
  .pwa-banner-desc {
    font-size: 0.72rem;
    color: #6b7280;
    margin: 2px 0 0;
    line-height: 1.2;
    white-space: nowrap;
    overflow: hidden;
    text-overflow: ellipsis;
  }
  .pwa-banner-actions {
    display: flex;
    align-items: center;
    gap: 6px;
    flex: 0 0 auto;
  }
  .btn-pwa-install {
    background: linear-gradient(135deg, #ff1944 0%, #ff5238 100%);
    color: #ffffff !important;
    border: none;
    border-radius: 10px;
    font-size: 0.76rem;
    font-weight: 800;
    padding: 7px 12px;
    display: inline-flex;
    align-items: center;
    gap: 4px;
    cursor: pointer;
    box-shadow: 0 3px 10px rgba(255, 25, 68, 0.3);
    transition: transform 0.15s ease;
    white-space: nowrap;
  }
  .btn-pwa-install:hover {
    transform: scale(1.04);
  }
  .btn-pwa-close {
    background: transparent;
    border: none;
    color: #9ca3af;
    font-size: 1.25rem;
    padding: 0 4px;
    line-height: 1;
    cursor: pointer;
    transition: color 0.15s ease;
  }
  .btn-pwa-close:hover {
    color: #374151;
  }
</style>

<div id="pwaInstallBanner" class="pwa-install-banner">
  <div class="pwa-banner-content">
    <img src="{{ asset('assets/images/logo.jpg') }}" alt="Loku Kade App" class="pwa-banner-icon">
    <div class="pwa-banner-text">
      <div class="pwa-banner-title">
        Loku Kade App <span style="font-size: 0.68rem; color: #f59e0b;">★★★★★</span>
      </div>
      <p class="pwa-banner-desc">Fast & 100% Free Shopping App</p>
    </div>
  </div>
  <div class="pwa-banner-actions">
    <button type="button" class="btn-pwa-install" id="btnPwaInstall">
      <i class="bi bi-download"></i> Install
    </button>
    <button type="button" class="btn-pwa-close" id="btnPwaClose" aria-label="Dismiss">&times;</button>
  </div>
</div>

<script>
(function() {
  // Check if app is already running in standalone mode (already installed & opened as PWA)
  const isStandalone = window.matchMedia('(display-mode: standalone)').matches || 
                       window.navigator.standalone === true || 
                       document.referrer.includes('android-app://');

  if (isStandalone) {
    localStorage.setItem('pwa_installed', 'true');
    return; // Do not initialize install prompt
  }

  // Check if user previously marked as installed
  if (localStorage.getItem('pwa_installed') === 'true') {
    return;
  }

  // Check if dismissed recently (3 days cool-off)
  const dismissedUntil = localStorage.getItem('pwa_prompt_dismissed_until');
  if (dismissedUntil && Date.now() < parseInt(dismissedUntil)) {
    return;
  }

  let deferredPrompt = null;
  const banner = document.getElementById('pwaInstallBanner');
  const installBtn = document.getElementById('btnPwaInstall');
  const closeBtn = document.getElementById('btnPwaClose');

  // Listen for the beforeinstallprompt event (Opera, Chrome, Edge, Samsung Internet)
  window.addEventListener('beforeinstallprompt', (e) => {
    // Prevent default mini-infobar if desired to control timing
    e.preventDefault();
    deferredPrompt = e;

    // Show custom in-app banner after brief delay
    setTimeout(() => {
      if (banner && localStorage.getItem('pwa_installed') !== 'true') {
        banner.style.display = 'flex';
      }
    }, 2000);
  });

  // Handle Install Button Click
  if (installBtn) {
    installBtn.addEventListener('click', async () => {
      if (!deferredPrompt) {
        // Fallback for browsers that support install via menu or manual guide
        alert('To install, tap your browser menu (⋮) and select "Add to Home Screen" or "Install App".');
        return;
      }

      // Show native browser install prompt
      deferredPrompt.prompt();

      const { outcome } = await deferredPrompt.userChoice;
      if (outcome === 'accepted') {
        localStorage.setItem('pwa_installed', 'true');
        if (banner) banner.style.display = 'none';
      }
      deferredPrompt = null;
    });
  }

  // Handle Close / Dismiss Button Click
  if (closeBtn) {
    closeBtn.addEventListener('click', () => {
      if (banner) banner.style.display = 'none';
      // Dismiss for 3 days so user isn't annoyed
      localStorage.setItem('pwa_prompt_dismissed_until', Date.now() + (3 * 24 * 60 * 60 * 1000));
    });
  }

  // Detect when app is successfully installed
  window.addEventListener('appinstalled', () => {
    localStorage.setItem('pwa_installed', 'true');
    if (banner) banner.style.display = 'none';
    deferredPrompt = null;
  });
})();
</script>
