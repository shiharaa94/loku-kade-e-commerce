@extends('layouts.frontend')
 
 @section('title', 'Register - Loku Kade')
 
 @section('styles')
 <style>
     .auth-wrapper {
         padding: 120px 0 80px;
         background-color: #f9fafb;
         min-height: 80vh;
         display: flex;
         align-items: center;
     }
     .auth-card {
         max-width: 450px;
         width: 100%;
         margin: 0 auto;
         background: #ffffff;
         border: 1px solid #e5e7eb;
         border-radius: 12px;
         padding: 2.5rem;
         box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.05), 0 2px 4px -1px rgba(0, 0, 0, 0.03);
     }
     .auth-header {
         text-align: center;
         margin-bottom: 1.75rem;
     }
     .auth-header h1 {
         font-size: 1.8rem;
         font-weight: 700;
         color: #111827;
         margin-bottom: 0.5rem;
         font-family: 'Space Grotesk', sans-serif;
     }
     .auth-header p {
         color: #6b7280;
         font-size: 0.95rem;
     }
     .form-row {
         display: flex;
         gap: 12px;
     }
     .form-group {
         margin-bottom: 1.1rem;
         flex: 1;
     }
     .form-label {
         display: block;
         font-size: 0.85rem;
         font-weight: 600;
         color: #374151;
         margin-bottom: 0.4rem;
     }
     .form-control {
         width: 100%;
         padding: 0.7rem 0.9rem;
         border: 1.5px solid #d1d5db;
         border-radius: 8px;
         font-size: 0.92rem;
         color: #1f2937;
         transition: border-color 0.2s;
         box-sizing: border-box;
     }
     .form-control:focus {
         outline: none;
         border-color: #dc2626;
     }
     .auth-btn {
         width: 100%;
         padding: 0.8rem;
         background: linear-gradient(135deg, #dc2626 0%, #f97316 100%);
         color: #ffffff;
         border: none;
         border-radius: 8px;
         font-weight: 600;
         font-size: 0.95rem;
         cursor: pointer;
         transition: opacity 0.2s;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         gap: 8px;
     }
     .auth-btn:hover {
         opacity: 0.95;
     }
     .social-divider {
         display: flex;
         align-items: center;
         margin: 1.25rem 0;
         color: #9ca3af;
         font-size: 0.85rem;
     }
     .social-divider::before, .social-divider::after {
         content: '';
         flex: 1;
         height: 1px;
         background: #e5e7eb;
     }
     .social-divider span {
         padding: 0 10px;
     }
     .google-btn {
         width: 100%;
         padding: 0.75rem;
         background: #ffffff;
         color: #374151;
         border: 1.5px solid #d1d5db;
         border-radius: 8px;
         font-weight: 600;
         font-size: 0.9rem;
         cursor: pointer;
         display: inline-flex;
         align-items: center;
         justify-content: center;
         gap: 10px;
         transition: background-color 0.2s;
         text-decoration: none;
     }
     .google-btn:hover {
         background-color: #f9fafb;
     }
     .google-icon {
         width: 18px;
         height: 18px;
     }
     .auth-footer {
         text-align: center;
         margin-top: 1.5rem;
         font-size: 0.9rem;
         color: #6b7280;
     }
     .auth-footer a {
         color: #dc2626;
         text-decoration: none;
         font-weight: 600;
     }
     .auth-footer a:hover {
         text-decoration: underline;
     }
     .alert {
         padding: 0.75rem 1rem;
         border-radius: 8px;
         margin-bottom: 1.25rem;
         font-size: 0.88rem;
     }
     .alert-danger {
         background-color: #fef2f2;
         border: 1px solid #fee2e2;
         color: #991b1b;
     }
 </style>
 @endsection
 
 @section('content')
 <div class="auth-wrapper">
     <div class="container">
         <div class="auth-card">
             <div class="auth-header">
                 <h1>Create Account</h1>
                 <p style="margin-bottom:0;">Register for an online customer account</p>
             </div>
 
             @if ($errors->any())
                 <div class="alert alert-danger">
                     <ul class="mb-0" style="padding-left: 1.2rem; margin: 0;">
                         @foreach ($errors->all() as $error)
                             <li>{{ $error }}</li>
                         @endforeach
                     </ul>
                 </div>
             @endif
 
             <form action="{{ route('register') }}" method="POST">
                 @csrf
                 <div class="form-row">
                     <div class="form-group">
                         <label class="form-label" for="first_name">First Name</label>
                         <input type="text" name="first_name" id="first_name" class="form-control" placeholder="John" value="{{ old('first_name') }}" required>
                     </div>
                     <div class="form-group">
                         <label class="form-label" for="last_name">Last Name</label>
                         <input type="text" name="last_name" id="last_name" class="form-control" placeholder="Doe" value="{{ old('last_name') }}" required>
                     </div>
                 </div>
 
                 <div class="form-group">
                     <label class="form-label" for="email">Email Address</label>
                     <input type="email" name="email" id="email" class="form-control" placeholder="john.doe@example.com" value="{{ old('email') }}" required>
                 </div>
 
                 <div class="form-group">
                     <label class="form-label" for="password">Password</label>
                     <input type="password" name="password" id="password" class="form-control" placeholder="Min. 6 characters" required>
                 </div>
 
                 <div class="form-group">
                     <label class="form-label" for="password_confirmation">Confirm Password</label>
                     <input type="password" name="password_confirmation" id="password_confirmation" class="form-control" placeholder="Re-type password" required>
                 </div>
 
                 <button type="submit" class="auth-btn">
                     <i class="bi bi-person-plus-fill"></i> Create Account
                 </button>
             </form>
 
             <div class="social-divider">
                 <span>or</span>
             </div>
 
             <a href="{{ route('auth.google') }}" class="google-btn">
                 <svg class="google-icon" viewBox="0 0 24 24">
                     <path fill="#EA4335" d="M12.24 10.285V14.4h6.887c-.648 2.41-2.519 4.114-5.136 4.114A5.79 5.79 0 0 1 8.2 12.8a5.79 5.79 0 0 1 5.79-5.714c1.648 0 3.134.62 4.298 1.638l3.184-3.184C19.444 3.738 16.93 2.5 13.99 2.5a10.3 10.3 0 0 0-10.3 10.3 10.3 10.3 0 0 0 10.3 10.3c5.96 0 10.11-4.187 10.11-10.23a9.4 9.4 0 0 0-.16-1.785H12.24Z"/>
                 </svg>
                 Sign up with Google
             </a>
 
             <div class="auth-footer">
                 Already have an account? <a href="{{ route('login') }}">Sign In</a>
             </div>
         </div>
     </div>
 </div>
 @endsection
