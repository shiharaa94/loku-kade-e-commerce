@extends('layouts.frontend')

@section('title', 'Terms & Conditions - Loku Kade')

@section('styles')
  <style>
    .legal-content {
      padding: 160px 0 100px;
    }
    .legal-card {
      background: var(--neutral-white);
      border: 1px solid var(--neutral-border);
      border-radius: var(--border-radius-lg);
      padding: 3rem;
      box-shadow: var(--shadow-md);
    }
    .legal-card h1 {
      font-size: 2.8rem;
      color: var(--primary-base);
      margin-bottom: 1.5rem;
      border-bottom: 2px solid var(--neutral-border);
      padding-bottom: 1rem;
    }
    .legal-card h2 {
      font-size: 1.5rem;
      color: var(--primary-base);
      margin-top: 2rem;
      margin-bottom: 1rem;
    }
    .legal-card p, .legal-card li {
      font-size: 1.05rem;
      color: var(--neutral-dark);
      line-height: 1.8;
      margin-bottom: 1.2rem;
    }
    .legal-card ul {
      margin-left: 1.5rem;
      margin-bottom: 1.5rem;
    }
    .legal-card .last-updated {
      font-size: 0.9rem;
      color: var(--neutral-muted);
      margin-bottom: 2rem;
      display: block;
    }
  </style>
@endsection

@section('content')
  <!-- --- LEGAL CONTENT SECTION --- -->
  <main class="legal-content">
    <div class="container">
      <div class="legal-card">
        <h1>Terms & Conditions</h1>
        <span class="last-updated">Last Updated: August 14, 2026</span>
        
        <p>Welcome to Loku Kade! These Terms & Conditions outline the rules and regulations for the use of Loku Kade's website and purchasing services.</p>
        
        <h2>1. Overview & Service Scope</h2>
        <p>Loku Kade operates as an online retail store in Sri Lanka, offering high-quality household accessories, kitchen items, and smart electronics. By accessing this website and purchasing products via our website or WhatsApp channel, you agree to comply with and be bound by these terms.</p>
        
        <h2>2. Ordering via WhatsApp</h2>
        <p>Our ordering process is facilitated through WhatsApp to ensure personal and direct service:</p>
        <ul>
          <li>Orders placed on WhatsApp are finalized once we confirm product availability and shipping details.</li>
          <li>You must provide accurate delivery details, including your full name, complete address (Jayanthipura, Polonnaruwa, etc.), and active contact numbers.</li>
          <li>We reserve the right to cancel or decline orders due to stock unavailability or delivery feasibility.</li>
        </ul>

        <h2>3. Pricing & Multi-Buy Discounts</h2>
        <p>All prices listed on our landing page and shop are in Sri Lankan Rupees (LKR):</p>
        <ul>
          <li>We display retail pricing alongside discount tiers.</li>
          <li>Promotion prices and retail savings percentages are calculated based on active database listings and are subject to change without notice.</li>
          <li>Multi-buy discounts are automatically applied to matching product quantities as displayed.</li>
        </ul>

        <h2>4. Free Delivery & Shipping</h2>
        <p>We provide 100% Free Delivery islandwide across Sri Lanka:</p>
        <ul>
          <li>Our standard delivery duration is 1 to 3 business days.</li>
          <li>Orders placed within Polonnaruwa and surrounding local areas are dispatched promptly and are usually delivered within 24 to 48 hours.</li>
          <li>Deliveries are managed through professional third-party logistics partners (such as CityPak). While we strive to meet standard delivery times, unexpected delays on their part are beyond our control.</li>
        </ul>

        <h2>5. Cash on Delivery (COD) & Inspection</h2>
        <p>To ensure your confidence and security, we support Cash on Delivery (COD):</p>
        <ul>
          <li>Payment must be made in full to the delivery rider upon arrival.</li>
          <li>We encourage customers to open and inspect the package condition before handing over the cash payment to the delivery rider.</li>
        </ul>

        <h2>6. Return & Exchange Policy</h2>
        <p>We offer a hassle-free 7-day exchange program for manufacturing defects or shipping damages:</p>
        <ul>
          <li>To request an exchange, you must contact our support desk on WhatsApp at 070 60 50 500 within 7 days of receiving the package, providing clear photos or videos of the defect.</li>
          <li>Exchanges are subject to verification and stock availability. We do not support returns or exchanges for change-of-mind reasons.</li>
        </ul>

        <h2>7. Limitation of Liability</h2>
        <p>Loku Kade shall not be held liable for any indirect, incidental, or consequential damages resulting from the use of, or inability to use, our products or services.</p>
      </div>
    </div>
  </main>
@endsection
