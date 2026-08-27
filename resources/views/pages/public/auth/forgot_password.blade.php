@extends('layouts.frontend')
 
 @section('title', 'Forgot Password - Loku Kade')
 
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
         max-width: 400px;
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
         margin-bottom: 2rem;
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
         line-height: 1.5;
     }
     .form-group {
         margin-bottom: 1.5rem;
     }
     .form-label {
         display: block;
         font-size: 0.85rem;
         font-weight: 600;
         color: #374151;
         margin-bottom: 0.5rem;
     }
     .form-control {
         width: 100%;
         padding: 0.75rem 1rem;
         border: 1.5px solid #d1d5db;
         border-radius: 8px;
         font-size: 0.95rem;
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
         padding: 0.85rem;
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
                 <h1>Forgot Password</h1>
                 <p style="margin-bottom:0;">Enter your email to receive a One-Time Password (OTP) to reset your password.</p>
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
 
             <form action="{{ route('password.otp') }}" method="POST">
                 @csrf
                 <div class="form-group">
                     <label class="form-label" for="email">Email Address</label>
                     <input type="email" name="email" id="email" class="form-control" placeholder="yourname@example.com" value="{{ old('email') }}" required>
                 </div>
 
                 <button type="submit" class="auth-btn">
                     <i class="bi bi-envelope-fill"></i> Send OTP Code
                 </button>
             </form>
 
             <div class="auth-footer">
                 Remember your password? <a href="{{ route('login') }}">Back to Login</a>
             </div>
         </div>
     </div>
 </div>
 @endsection
