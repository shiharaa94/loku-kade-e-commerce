<?php

use App\Http\Controllers\OrderController;
use App\Http\Controllers\ProductController;
use App\Http\Controllers\AuthController;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

// --- Public Pages ---
Route::get('/', function () {
    return view('index');
})->name('home');

Route::get('/privacy', function () {
    return view('privacy');
})->name('public.privacy');

Route::get('/terms', function () {
    return view('terms');
})->name('public.terms');

// --- Shop & Product Details ---
Route::get('/shop', [ProductController::class, 'shop'])->name('products.shop');
Route::get('/shop/product/{id}', [ProductController::class, 'publicProductDetails'])->name('products.publicDetails');
Route::post('/shop/product/{id}/review', [ProductController::class, 'storeReview'])->name('products.storeReview');
Route::get('/checkout', [ProductController::class, 'checkout'])->name('products.checkout');

// --- Dynamic Sitemap XML ---
Route::get('/sitemap.xml', [ProductController::class, 'dynamicSitemap'])->name('public.sitemap');

// --- Public API Endpoints ---
Route::get('/api/featured-products', [ProductController::class, 'publicFeaturedProducts']);
Route::get('/api/track-order', [OrderController::class, 'publicTrackOrder']);
Route::get('/fetch-cities', [OrderController::class, 'fetchCities'])->name('utilities.fetchCities');

// --- Secure On-Site Checkout Order Placement ---
Route::post('/orders/store', [OrderController::class, 'store'])->name('orders.store');

// --- Order Tracking & Secure Reviews ---
Route::get('/orders/track/{token}', [OrderController::class, 'showTrackingPage'])->name('orders.track');
Route::get('/orders/review/{token}', [OrderController::class, 'showReviewPage'])->name('orders.review');
Route::post('/orders/review/{token}/submit', [OrderController::class, 'submitOrderReviews'])->name('orders.submitReviews');

// --- Order Status Simulation / Testing Route ---
Route::get('/test/orders/{order_number}/deliver', [OrderController::class, 'simulateDelivery'])->name('orders.simulateDelivery');



// --- Flash Deals & Trending Products Pages ---
Route::get('/flash-deals', [ProductController::class, 'flashDeals'])->name('products.flashDeals');
Route::get('/trending', [ProductController::class, 'trending'])->name('products.trending');



// --- Custom Customer Authentication ---
Route::get('/login', [AuthController::class, 'showLogin'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::get('/register', [AuthController::class, 'showRegister'])->name('register');
Route::post('/register', [AuthController::class, 'register']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// --- Forgot Password OTP Flow ---
Route::get('/forgot-password', [AuthController::class, 'showForgotPassword'])->name('password.request');
Route::post('/forgot-password', [AuthController::class, 'sendOtp'])->name('password.otp');
Route::get('/verify-otp', [AuthController::class, 'showVerifyOtp'])->name('password.verify');
Route::post('/verify-otp', [AuthController::class, 'verifyOtp']);
Route::get('/reset-password', [AuthController::class, 'showResetPassword'])->name('password.reset');
Route::post('/reset-password', [AuthController::class, 'resetPassword']);

// --- Google OAuth Routes ---
Route::get('/auth/google', [AuthController::class, 'redirectToGoogle'])->name('auth.google');
Route::get('/auth/google/callback', [AuthController::class, 'handleGoogleCallback']);

// --- Customer Profile / Dashboard ---
Route::match(['get', 'post'], '/profile', [AuthController::class, 'profile'])->name('profile')->middleware('auth');
