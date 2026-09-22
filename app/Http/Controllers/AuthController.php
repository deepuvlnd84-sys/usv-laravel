<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Session;
use App\Mail\SendOtpMail;

class AuthController extends Controller
{
    // Show the Email ID Entry Form
    public function showLoginForm()
    {
        // If already logged in, redirect to dashboard
        if (Session::has('authenticated_user')) {
            return redirect()->route('dashboard');
        }

        // Generate a simple math captcha to prevent automated spam
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        Session::put('captcha_result', $num1 + $num2);
        $captcha_question = "$num1 + $num2";

        return view('auth.login', compact('captcha_question'));
    }

    // Generate and Send OTP
    public function sendOtp(Request $request)
    {
        $request->validate([
            'email' => 'required|email',
            'captcha' => 'required|integer',
        ], [
            'email.required' => 'Email address is required.',
            'email.email' => 'Please enter a valid email address.',
            'captcha.required' => 'Captcha answer is required.',
        ]);

        // Verify captcha
        $expected = Session::get('captcha_result');
        if ($request->captcha != $expected) {
            return redirect()->back()
                ->withInput()
                ->withErrors(['captcha' => 'The captcha code is incorrect. Please try again.']);
        }

        // Generate 6-digit OTP
        $otp = rand(100000, 999999);
        $email = $request->email;

        // Store email and OTP in session
        Session::put('login_email', $email);
        Session::put('login_otp', $otp);
        Session::forget('debug_mode_otp');

        try {
            // Send the OTP mail using our existing SendOtpMail
            Mail::to($email)->send(new SendOtpMail($otp));

            // Redirect to the verification form
            return redirect()->route('login.verify')
                ->with('success', "OTP has been sent to {$email}! Please check your email inbox.");
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("OTP delivery failed for {$email}: " . $e->getMessage());

            if (config('app.debug')) {
                Session::put('debug_mode_otp', $otp);
                return redirect()->route('login.verify')
                    ->with('warning', "Email could not be delivered to {$email} ({$e->getMessage()}).")
                    ->with('debug_otp', $otp);
            }

            return redirect()->route('login.verify')
                ->withErrors(['email' => 'Failed to send OTP email. Please try again or contact administrator.']);
        }
    }

    // Show the OTP Verification Form
    public function showVerifyForm()
    {
        $email = Session::get('login_email');
        if (!$email) {
            return redirect()->route('login')->withErrors(['email' => 'Please enter your email to request an OTP.']);
        }

        $debugOtp = (config('app.debug') && Session::has('debug_mode_otp')) ? Session::get('debug_mode_otp') : session('debug_otp');

        return view('auth.verify', compact('email', 'debugOtp'));
    }

    // Verify OTP and Log In
    public function verifyOtp(Request $request)
    {
        $request->validate([
            'otp' => 'required|integer',
        ], [
            'otp.required' => 'OTP is required.',
        ]);

        $email = Session::get('login_email');
        $expectedOtp = Session::get('login_otp');

        if (!$email || !$expectedOtp) {
            return redirect()->route('login')->withErrors(['email' => 'Session expired. Please request a new OTP.']);
        }

        if ($request->otp != $expectedOtp) {
            return redirect()->back()
                ->withErrors(['otp' => 'The entered OTP code is incorrect. Please check your mail.']);
        }

        // Clear session OTP keys
        Session::forget('login_otp');
        Session::forget('debug_mode_otp');

        // Keep authenticated state indicator
        Session::put('authenticated_user', $email);

        return redirect()->route('dashboard')->with('success', 'Logged in successfully!');
    }

    // Show Admin Login Form
    public function showAdminLoginForm()
    {
        if (Session::has('authenticated_user')) {
            return redirect()->route('dashboard');
        }

        // Simple math captcha
        $num1 = rand(1, 9);
        $num2 = rand(1, 9);
        Session::put('admin_captcha_result', $num1 + $num2);
        $captcha_question = "$num1 + $num2";

        return view('auth.admin_login', compact('captcha_question'));
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
        $email = Session::get('authenticated_user');
        if (!$email) {
            return redirect()->route('login')->withErrors(['email' => 'Please sign in to access your dashboard.']);
        }

        $isAdmin = Session::get('is_admin') === true;

        return view('dashboard', compact('email', 'isAdmin'));
    }

    // Log Out
    public function logout()
    {
        Session::forget(['authenticated_user', 'login_email', 'debug_mode_otp', 'is_admin']);
        return redirect()->route('login')->with('success', 'Logged out successfully!');
    }
}
