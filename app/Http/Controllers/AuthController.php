<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Str;
use App\Models\User;
use App\Models\ContactSetting;

class AuthController extends Controller
{
    private function getSettings()
    {
        $settings = ContactSetting::first();
        if (!$settings) {
            $settings = ContactSetting::create([
                'facebook_url' => 'https://www.facebook.com/unitedseniorsvellanad',
                'instagram_url' => 'https://instagram.com/unitedseniorsvellanad',
                'youtube_url' => 'https://www.youtube.com/@UnitedSeniorsVellanad',
                'club_email' => 'unitedseniorsvellanadans@gmail.com',
                'club_phone' => '094478 89502',
                'ground_location' => 'H345+JF, Vellanad, Keralam 695543',
                'ground_map_url' => 'https://www.google.com/maps/place/Viswanathan+Memorial+Panchayath+Stadium,+Vellanad/@8.5565815,77.0396807,15z/data=!4m10!1m2!2m1!1sground+Vellanad!3m6!1s0x3b05b700298dfee1:0xce52ac8e1571f9d!8m2!3d8.5565815!4d77.0587351!15sCg9ncm91bmQgVmVsbGFuYWRaESIPZ3JvdW5kIHZlbGxhbmFkkgEKcGxheWdyb3VuZJoBRENpOURRVWxSUVVOdlpFTm9kSGxqUmpsdlQycGFRMU5FVmxwT2EyUklZbnBzTlZsWWFHWk5WR1F5V1c1T2JrNUlZeEFC4AEA-gEECAAQOw!16s%2Fg%2F11wqkkrh2d?entry=ttu&g_ep=EgoyMDI2MDkyMy4wIKXMDSoASAFQAw%3D%3D',
            ]);
        }
        return $settings;
    }

    // Show the Email ID Entry Form
    public function showLoginForm()
    {
        // If already logged in, redirect to dashboard
        if (Auth::check() || Session::has('authenticated_user') || session()->has('user')) {
            return redirect()->route('dashboard');
        }

        // Generate a simple math captcha to prevent automated spam
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        Session::put('captcha_result', $num1 + $num2);
        $captcha_question = "$num1 + $num2";
        $settings = $this->getSettings();

        return view('auth.login', compact('captcha_question', 'settings'));
    }

    // Generate and Send OTP via Supabase Auth API
    public function sendOtp(Request $request)
    {
        $rules = [
            'email' => 'required|email',
        ];

        if ($request->has('captcha')) {
            $rules['captcha'] = 'required|integer';
        }

        $request->validate($rules, [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'captcha.required' => 'Captcha answer is required.',
        ]);

        // Verify captcha if present
        if ($request->has('captcha')) {
            $expected = Session::get('captcha_result');
            if ($request->captcha != $expected) {
                return redirect()->back()
                    ->withInput()
                    ->withErrors(['captcha' => 'The captcha code is incorrect. Please try again.']);
            }
        }

        $email = trim(strtolower($request->email));
        $supabaseUrl = rtrim(env('SUPABASE_URL', 'https://kynnfxdjqplnvucouwug.supabase.co'), '/');
        $supabaseKey = env('SUPABASE_KEY');

        try {
            // Supabase Auth API ലേക്ക് HTTPS പോർട്ട് 443 വഴി റിക്വസ്റ്റ് അയക്കുന്നു
            $response = Http::withHeaders([
                'apikey'        => $supabaseKey,
                'Authorization' => 'Bearer ' . $supabaseKey,
                'Content-Type'  => 'application/json',
            ])->post("{$supabaseUrl}/auth/v1/otp", [
                'email'       => $email,
                'create_user' => true, // യൂസർ മുൻപ് രജിസ്റ്റർ ചെയ്തിട്ടില്ലെങ്കിൽ തനിയെ അക്കൗണ്ട് ക്രിയേറ്റ് ചെയ്യും
            ]);

            if ($response->successful()) {
                // വെരിഫിക്കേഷൻ പേജിലേക്ക് ആവശ്യമായ ഇമെയിൽ സെഷനിൽ സൂക്ഷിക്കുന്നു
                session(['auth_email' => $email]);
                Session::put('login_email', $email);

                return redirect()->route('login.verify')->with('success', 'OTP ഇമെയിലിലേക്ക് അയച്ചിട്ടുണ്ട്.');
            }

            // Supabase API തരുന്ന കൃത്യമായ എറർ മെസ്സേജ് പിടിച്ചെടുക്കുന്നു
            $errorData = $response->json();
            $errorMessage = $errorData['msg'] ?? $errorData['error_description'] ?? 'OTP അയക്കാൻ സാധിച്ചില്ല.';

            return back()->withInput()->withErrors(['email' => $errorMessage]);

        } catch (\Exception $e) {
            Log::error('Supabase OTP Error: ' . $e->getMessage());
            return back()->withInput()->withErrors(['email' => 'സെർവറുമായി ബന്ധപ്പെടാൻ സാധിച്ചില്ല. ദയവായി അല്പം കഴിഞ്ഞ് ശ്രമിക്കുക.']);
        }
    }

    // Show the OTP Verification Form
    public function showVerifyForm()
    {
        $email = session('auth_email') ?? Session::get('login_email');
        if (!$email) {
            return redirect()->route('login')->withErrors(['email' => 'Please enter your email to request an OTP.']);
        }

        $debugOtp = Session::get('debug_mode_otp') ?? session('debug_otp');
        $settings = $this->getSettings();

        return view('auth.verify', compact('email', 'debugOtp', 'settings'));
    }

    // Verify OTP and Log In via Supabase Auth API & sync with Laravel User model
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|numeric',
        ]);

        $email = session('auth_email') ?? Session::get('login_email');

        if (!$email) {
            return redirect()->route('login')->withErrors(['email' => 'സെഷൻ കാലഹരണപ്പെട്ടു. ദയവായി വീണ്ടും ശ്രമിക്കുക.']);
        }

        $supabaseUrl = rtrim(env('SUPABASE_URL', 'https://kynnfxdjqplnvucouwug.supabase.co'), '/');
        $supabaseKey = env('SUPABASE_KEY');

        try {
            // ഉപയോക്താവ് നൽകിയ OTP Supabase വഴി പരിശോധിക്കുന്നു
            $response = Http::withHeaders([
                'apikey'        => $supabaseKey,
                'Authorization' => 'Bearer ' . $supabaseKey,
                'Content-Type'  => 'application/json',
            ])->post("{$supabaseUrl}/auth/v1/verify", [
                'type'  => 'email',
                'email' => $email,
                'token' => trim($request->otp),
            ]);

            if ($response->successful()) {
                $supabaseData = $response->json();
                $supabaseUser = $supabaseData['user'] ?? $supabaseData;
                $supabaseId   = $supabaseUser['id'] ?? null;
                $userEmail    = $supabaseUser['email'] ?? $email;

                $existingUser = User::where('email', $userEmail)->first();

                // 1. Laravel ലോക്കൽ Users ടേബിളിൽ യൂസറെ കണ്ടെത്തുക അല്ലെങ്കിൽ ഉണ്ടാക്കുക
                $user = User::updateOrCreate(
                    ['email' => $userEmail],
                    [
                        'supabase_id'       => $supabaseId,
                        'name'              => $existingUser->name ?? explode('@', $userEmail)[0],
                        'password'          => $existingUser->password ?? bcrypt(Str::random(24)),
                        'email_verified_at' => now(),
                    ]
                );

                // 2. Laravel ബിൽറ്റ്-ഇൻ Auth വഴി ഔദ്യോഗികമായി ലോഗിൻ ചെയ്യിക്കുക
                Auth::login($user, true); // true നൽകുന്നത് 'Remember Me' സെഷൻ നിലനിർത്താനാണ്

                // 3. സെഷൻ വിവരങ്ങൾ സൂക്ഷിക്കുക
                session([
                    'user'       => $supabaseUser,
                    'auth_token' => $supabaseData['access_token'] ?? null
                ]);
                Session::put('authenticated_user', $userEmail);

                // 4. താൽക്കാലികമായി വെച്ച സെഷൻ വിവരങ്ങൾ നീക്കം ചെയ്യുക
                session()->forget('auth_email');
                Session::forget('login_email');
                session()->regenerate(); // സെഷൻ ഫിക്സേഷൻ തടയാൻ

                // 5. അഡ്മിൻ അല്ലെങ്കിൽ സാധാരണ യൂസർ റോൾ അനുസരിച്ച് റീഡയറക്ട് ചെയ്യാം
                if (isset($user->role) && $user->role === 'admin') {
                    Session::put('is_admin', true);
                    return redirect()->intended('/admin/dashboard')->with('success', 'സ്വാഗതം അഡ്മിൻ!');
                }

                return redirect()->intended('/dashboard')->with('success', 'വിജയകരമായി ലോഗിൻ ചെയ്തു!');
            }

            return back()->withErrors(['otp' => 'നൽകിയ OTP തെറ്റാണ് അല്ലെങ്കിൽ കാലാവധി കഴിഞ്ഞു.']);

        } catch (\Exception $e) {
            Log::error('Supabase Verify Error: ' . $e->getMessage());
            return back()->withErrors(['otp' => 'വെരിഫിക്കേഷൻ പരാജയപ്പെട്ടു.']);
        }
    }

    // Show Admin Login Form
    public function showAdminLoginForm()
    {
        if (Auth::check() || Session::has('authenticated_user') || session()->has('user')) {
            return redirect()->route('dashboard');
        }

        // Simple math captcha
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        Session::put('admin_captcha_result', $num1 + $num2);
        $captcha_question = "$num1 + $num2";
        $settings = $this->getSettings();

        return view('auth.admin_login', compact('captcha_question', 'settings'));
    }

    // Process Admin Login
    public function adminLogin(Request $request)
    {
        $request->validate([
            'username' => 'required|string',
            'password' => 'required|string',
            'captcha' => 'required|integer',
        ], [
            'username.required' => 'Admin username is required.',
            'password.required' => 'Admin password is required.',
            'captcha.required' => 'Captcha answer is required.',
        ]);

        // Verify captcha
        $expected = Session::get('admin_captcha_result');
        if ($request->captcha != $expected) {
            return redirect()->back()
                ->withInput($request->except('password'))
                ->withErrors(['captcha' => 'The captcha code is incorrect. Please try again.']);
        }

        $username = trim($request->username);
        $password = $request->password;

        // Verify credentials: username 'Admin' (case-insensitive) and password 'USV@123'
        if (strcasecmp($username, 'Admin') === 0 && $password === 'USV@123') {
            Session::put('is_admin', true);
            Session::put('authenticated_user', 'Admin');

            return redirect()->route('dashboard')->with('success', 'Logged in as Administrator successfully! You have full management permissions.');
        }

        return redirect()->back()
            ->withInput($request->except('password'))
            ->withErrors(['auth' => 'Invalid Admin username or password.']);
    }

    // Show the Dashboard
    public function dashboard()
    {
        $email = Auth::user()->email ?? Session::get('authenticated_user') ?? session('user.email') ?? (is_array(session('user')) ? (session('user')['email'] ?? null) : null);
        if (!Auth::check() && !$email && !Session::has('authenticated_user') && !session()->has('user')) {
            return redirect()->route('login')->withErrors(['email' => 'Please sign in to access your dashboard.']);
        }

        $isAdmin = Session::get('is_admin') === true || (Auth::check() && Auth::user()->role === 'admin');

        return view('dashboard', compact('email', 'isAdmin'));
    }

    // Log Out
    public function logout()
    {
        Auth::logout();
        Session::forget(['authenticated_user', 'login_email', 'debug_mode_otp', 'is_admin', 'user', 'auth_email', 'auth_token']);
        session()->invalidate();
        session()->regenerateToken();
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
