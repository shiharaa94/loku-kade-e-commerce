@extends('layouts.frontend')

@section('title', 'Privacy Policy - Loku Kade')

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
        <h1>Privacy Policy</h1>
        <span class="last-updated">Last Updated: August 14, 2026</span>
        
        <p>At Loku Kade, we value and respect your privacy. This Privacy Policy details the types of information we collect when you visit our landing page, use our services, or communicate with us on WhatsApp, and how we handle and protect it.</p>
        
        <h2>1. Information We Collect</h2>
        <p>We collect personal information that you directly provide to us when placing an order or contacting us:</p>
        <ul>
          <li><strong>Identity Data</strong>: Full name and title.</li>
          <li><strong>Contact Data</strong>: Delivery address, billing address, phone number (Primary and Secondary), and WhatsApp account details.</li>
          <li><strong>Transaction Data</strong>: Details about the products you purchased, order dates, and total payment amounts.</li>
        </ul>
        
        <h2>2. How We Use Your Information</h2>
        <p>We use your personal data to facilitate our order fulfillment process, specifically to:</p>
        <ul>
          <li>Verify and confirm your orders via WhatsApp.</li>
          <li>Process, pack, and ship your ordered items.</li>
          <li>Share shipping coordinates and delivery details with our delivery partners (such as CityPak).</li>
          <li>Send transaction receipts, delivery status updates, and customer support communications.</li>
        </ul>

        <h2>3. Third-Party Sharing</h2>
        <p>We do not sell, trade, or rent your personal information to third parties. We only share necessary data with trusted logistics partners to complete the doorstep delivery of your order. These third-party logistics firms are obligated to secure your data and only use it for shipping purposes.</p>

        <h2>4. Data Storage & Security</h2>
        <p>We store transactional records securely within our administrative system (app.lokukade.lk). We implement appropriate technical safeguards and security procedures to prevent unauthorized access, alteration, or disclosure of your personal contact data.</p>

        <h2>5. Chat Data & Communication on WhatsApp</h2>
        <p>When you use our WhatsApp messaging option to place an order or ask a question, your communication is processed through WhatsApp's secure network. We store chat histories solely to assist with order follow-ups and client inquiries.</p>

        <h2>6. Cookies & Web Analytics</h2>
        <p>We may use cookies and basic analytics to track user interactions and landing page performance. This details standard web browsing patterns and helps us optimize our website loading times and product listings. You can disable cookies in your browser settings at any time.</p>

        <h2>7. Your Rights</h2>
        <p>You have the right to request access to the personal data we hold about you, or request corrections or deletion of your contact records. If you wish to update your details, please reach out to our team via WhatsApp at 070 60 50 500.</p>
      </div>
    </div>
  </main>
@endsection
