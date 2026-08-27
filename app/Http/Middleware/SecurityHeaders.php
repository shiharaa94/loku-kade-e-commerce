<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class SecurityHeaders
{
    /**
     * Handle an incoming request and attach strong security headers for A+ Grade rating.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $response = $next($request);

        // 1. HTTP Strict Transport Security (HSTS)
        $response->headers->set('Strict-Transport-Security', 'max-age=31536000; includeSubDomains; preload');

        // 2. Clickjacking Protection
        $response->headers->set('X-Frame-Options', 'SAMEORIGIN');

        // 3. MIME Sniffing Prevention
        $response->headers->set('X-Content-Type-Options', 'nosniff');

        // 4. Referrer Policy
        $response->headers->set('Referrer-Policy', 'strict-origin-when-cross-origin');

        // 5. Permissions Policy
        $response->headers->set('Permissions-Policy', 'camera=(), microphone=(), geolocation=(), payment=(), usb=()');

        // 6. XSS Filter Protection for Legacy Browsers
        $response->headers->set('X-XSS-Protection', '1; mode=block');

        // 7. Content Security Policy (CSP)
        $csp = "default-src 'self' https: http: data: blob:; " .
               "script-src 'self' 'unsafe-inline' 'unsafe-eval' https://cdn.jsdelivr.net https://code.jquery.com; " .
               "style-src 'self' 'unsafe-inline' https://fonts.googleapis.com https://cdn.jsdelivr.net; " .
               "font-src 'self' https://fonts.gstatic.com https://cdn.jsdelivr.net data:; " .
               "img-src 'self' data: blob: https: http: https://*.youtube.com https://*.ytimg.com; " .
               "media-src 'self' https: http: data: blob: https://*.youtube.com; " .
               "frame-src 'self' https://www.youtube.com https://www.youtube-nocookie.com https://youtube.com; " .
               "connect-src 'self' https: http:; " .
               "frame-ancestors 'self'; " .
               "base-uri 'self'; " .
               "form-action 'self' https: http:;";
        
        $response->headers->set('Content-Security-Policy', $csp);

        return $response;
    }
}
