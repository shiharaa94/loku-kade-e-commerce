<?php
 
 namespace App\Http\Controllers;
 
 use App\Models\User;
 use App\Models\OrderHeader;
 use App\Models\ProductReview;
 use App\Mail\SendOtpMail;
 use Illuminate\Http\Request;
 use Illuminate\Support\Facades\Auth;
 use Illuminate\Support\Facades\Hash;
 use Illuminate\Support\Facades\Mail;
 use Illuminate\Support\Facades\Session;
 use Illuminate\Support\Facades\Http;
 use Illuminate\Support\Facades\Log;
 use Illuminate\Support\Str;
 
 class AuthController extends Controller
 {
     // --- Custom Login ---
     public function showLogin()
     {
         if (Auth::check()) {
             return redirect()->route('profile');
         }
         return view('pages.public.auth.login');
     }
 
     public function login(Request $request)
     {
         $credentials = $request->validate([
             'email' => 'required|email',
             'password' => 'required|string',
         ]);
 
         $remember = $request->has('remember');
 
         if (Auth::attempt($credentials, $remember)) {
             $request->session()->regenerate();
             return redirect()->intended(route('profile'))->with('success', 'Welcome back!');
         }
 
         return back()->withErrors([
             'email' => 'The provided credentials do not match our records.',
         ])->onlyInput('email');
     }
 
     // --- Custom Register ---
     public function showRegister()
     {
         if (Auth::check()) {
             return redirect()->route('profile');
         }
         return view('pages.public.auth.register');
     }
 
     public function register(Request $request)
     {
         $data = $request->validate([
             'first_name' => 'required|string|max:50',
             'last_name' => 'required|string|max:50',
             'email' => 'required|email|unique:users,email',
             'password' => 'required|string|min:6|confirmed',
         ]);
 
         $user = User::create([
             'first_name' => $data['first_name'],
             'last_name' => $data['last_name'],
             'email' => $data['email'],
             'username' => $data['email'],
             'password' => Hash::make($data['password']),
             'role_id' => 2, // Customer
             'status' => 1, // Active
         ]);
 
         Auth::login($user);
         return redirect()->route('profile')->with('success', 'Registration successful! Welcome to Loku Kade.');
     }
 
     // --- Custom Logout ---
     public function logout(Request $request)
     {
         Auth::logout();
         $request->session()->invalidate();
         $request->session()->regenerateToken();
         return redirect()->route('home')->with('success', 'Logged out successfully.');
     }
 
     // --- Forgot Password OTP Flow ---
     public function showForgotPassword()
     {
         return view('pages.public.auth.forgot_password');
     }
 
     public function sendOtp(Request $request)
     {
         $request->validate(['email' => 'required|email']);
         $user = User::where('email', $request->email)->first();
 
         if (!$user) {
             return back()->withErrors(['email' => 'No user registered with this email address.']);
         }
 
         $otp = rand(100000, 999999);
         $user->otp = $otp;
         $user->otp_expires_at = now()->addMinutes(15);
         $user->save();
 
         try {
             Mail::to($user->email)->send(new SendOtpMail($user, $otp));
         } catch (\Exception $e) {
             Log::error('Failed to send OTP reset email to ' . $user->email . ': ' . $e->getMessage());
             return back()->withErrors(['email' => 'Failed to send verification email. Please try again.']);
         }
 
         session(['reset_email' => $user->email]);
         return redirect()->route('password.verify')->with('success', 'A verification OTP has been sent to your email.');
     }
 
     public function showVerifyOtp()
     {
         if (!session('reset_email')) {
             return redirect()->route('password.request');
         }
         return view('pages.public.auth.verify_otp');
     }
 
     public function verifyOtp(Request $request)
     {
         $request->validate(['otp' => 'required|string|size:6']);
         $email = session('reset_email');
 
         if (!$email) {
             return redirect()->route('password.request');
         }
 
         $user = User::where('email', $email)
             ->where('otp', $request->otp)
             ->where('otp_expires_at', '>', now())
             ->first();
 
         if (!$user) {
             return back()->withErrors(['otp' => 'The OTP is invalid or has expired.']);
         }
 
         session(['otp_verified_email' => $email]);
         return redirect()->route('password.reset')->with('success', 'OTP verified successfully. You can now reset your password.');
     }
 
     public function showResetPassword()
     {
         if (!session('otp_verified_email')) {
             return redirect()->route('password.request');
         }
         return view('pages.public.auth.reset_password');
     }
 
     public function resetPassword(Request $request)
     {
         $request->validate([
             'password' => 'required|string|min:6|confirmed',
         ]);
 
         $email = session('otp_verified_email');
         if (!$email) {
             return redirect()->route('password.request');
         }
 
         $user = User::where('email', $email)->first();
         if (!$user) {
             return redirect()->route('password.request');
         }
 
         $user->password = Hash::make($request->password);
         $user->otp = null;
         $user->otp_expires_at = null;
         $user->save();
 
         // Clean session
         session()->forget(['reset_email', 'otp_verified_email']);
 
         Auth::login($user);
         return redirect()->route('profile')->with('success', 'Your password has been reset successfully.');
     }
 
     // --- Google OAuth 2.0 Custom Logic ---
     public function redirectToGoogle()
     {
         $clientId = env('GOOGLE_CLIENT_ID');
         $redirectUri = env('GOOGLE_REDIRECT_URI');
 
         if (empty($clientId) || $clientId === 'your-google-client-id') {
             return redirect()->route('login')->withErrors(['email' => 'Google Social Authentication is not configured yet.']);
         }
 
         $state = Str::random(40);
         session(['google_state' => $state]);
 
         $query = http_build_query([
             'client_id' => $clientId,
             'redirect_uri' => $redirectUri,
             'response_type' => 'code',
             'scope' => 'openid email profile',
             'state' => $state,
             'prompt' => 'select_account',
         ]);
 
         return redirect('https://accounts.google.com/o/oauth2/v2/auth?' . $query);
     }
 
     public function handleGoogleCallback(Request $request)
     {
         $state = $request->input('state');
         $sessionState = session('google_state');
 
         if (empty($state) || $state !== $sessionState) {
             return redirect()->route('login')->withErrors(['email' => 'Invalid Google state parameter. Please try again.']);
         }
 
         $code = $request->input('code');
         if (empty($code)) {
             return redirect()->route('login')->withErrors(['email' => 'Google authorization code not found.']);
         }
 
         $clientId = env('GOOGLE_CLIENT_ID');
         $clientSecret = env('GOOGLE_CLIENT_SECRET');
         $redirectUri = env('GOOGLE_REDIRECT_URI');
 
         // Exchange Code for Access Token
         $response = Http::asForm()->post('https://oauth2.googleapis.com/token', [
             'client_id' => $clientId,
             'client_secret' => $clientSecret,
             'redirect_uri' => $redirectUri,
             'code' => $code,
             'grant_type' => 'authorization_code',
         ]);
 
         if ($response->failed()) {
             Log::error('Google OAuth token exchange failed: ' . $response->body());
             return redirect()->route('login')->withErrors(['email' => 'Failed to obtain access token from Google.']);
         }
 
         $tokenData = $response->json();
         $accessToken = $tokenData['access_token'] ?? null;
 
         if (!$accessToken) {
             return redirect()->route('login')->withErrors(['email' => 'Access token not found in Google response.']);
         }
 
         // Retrieve User Profile details
         $userResponse = Http::withToken($accessToken)->get('https://www.googleapis.com/oauth2/v3/userinfo');
 
         if ($userResponse->failed()) {
             Log::error('Google Userinfo request failed: ' . $userResponse->body());
             return redirect()->route('login')->withErrors(['email' => 'Failed to retrieve user details from Google.']);
         }
 
         $googleUser = $userResponse->json();
         $email = $googleUser['email'] ?? null;
         $googleId = $googleUser['sub'] ?? null;
         $firstName = $googleUser['given_name'] ?? 'Google';
         $lastName = $googleUser['family_name'] ?? 'User';
 
         if (empty($email)) {
             return redirect()->route('login')->withErrors(['email' => 'Could not retrieve email from Google account.']);
         }
 
         // Check if user exists by email or google_id
         $user = User::where('email', $email)->orWhere('google_id', $googleId)->first();
 
         if ($user) {
             // Link Google ID if missing
             if (empty($user->google_id)) {
                 $user->update(['google_id' => $googleId]);
             }
             Auth::login($user, true);
         } else {
             // Register a new customer
             $user = User::create([
                 'first_name' => $firstName,
                 'last_name' => $lastName,
                 'email' => $email,
                 'username' => $email,
                 'google_id' => $googleId,
                 'password' => Hash::make(Str::random(16)),
                 'role_id' => 2, // Customer
                 'status' => 1, // Active
             ]);
             Auth::login($user, true);
         }
 
         return redirect()->route('profile')->with('success', 'Logged in successfully via Google.');
     }
 
     // --- Full Customer Dashboard Profile ---
     public function profile(Request $request)
     {
         $user = Auth::user();
 
         // Fetch customer's orders history with details and product info
         $orders = OrderHeader::where('customer_email', $user->email)
             ->with(['details.product'])
             ->orderBy('created_at', 'desc')
             ->get();
 
         // Fetch customer's reviews history (linked via order numbers placed by this email)
         $orderNumbers = $orders->pluck('order_number');
         $reviews = ProductReview::with('product')
             ->whereIn('order_number', $orderNumbers)
             ->orderBy('created_at', 'desc')
             ->get();
 
         // Custom handler for updating user profile info directly in dashboard
        if ($request->isMethod('post')) {
            $request->validate([
                'first_name' => 'required|string|max:50',
                'last_name'  => 'required|string|max:50',
                'address'    => 'nullable|string|max:500',
                'city'       => 'nullable|string|max:100',
                'pri_mobile' => 'nullable|string|max:20',
                'sec_mobile' => 'nullable|string|max:20',
                'password'   => 'nullable|string|min:6|confirmed',
            ]);

            $user->first_name = $request->first_name;
            $user->last_name  = $request->last_name;
            $user->address    = $request->address;
            $user->city       = $request->city;
            $user->pri_mobile = $request->pri_mobile;
            $user->sec_mobile = $request->sec_mobile;

            if ($request->filled('password')) {
                $user->password = Hash::make($request->password);
            }
            $user->save();

            return back()->with('success', 'Profile and Delivery Address updated successfully.');
        }
 
         return view('pages.public.auth.profile', compact('user', 'orders', 'reviews'));
     }
 }
