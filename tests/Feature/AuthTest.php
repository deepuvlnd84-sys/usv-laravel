<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Http;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AuthTest extends TestCase
{
    use RefreshDatabase;

    public function test_login_page_loads_successfully()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Sign In');
        $response->assertSee('Captcha Validation');
    }

    public function test_send_otp_with_correct_captcha_redirects_to_verify()
    {
        Http::fake([
            '*/auth/v1/otp' => Http::response([], 200),
        ]);

        $this->withSession(['captcha_result' => 10]);

        $response = $this->post('/login/send-otp', [
            'email' => 'deepuvlnd@gmail.com',
            'captcha' => 10,
        ]);

        $response->assertRedirect(route('login.verify'));
        $this->assertEquals('deepuvlnd@gmail.com', session('auth_email'));
    }

    public function test_verify_page_displays_otp_in_debug_mode()
    {
        $otp = 654321;
        $response = $this->withSession([
            'auth_email' => 'deepuvlnd@gmail.com',
            'login_email' => 'deepuvlnd@gmail.com',
            'login_otp' => $otp,
            'debug_mode_otp' => $otp,
        ])->get('/login/verify');

        $response->assertStatus(200);
        $response->assertSee((string)$otp);
        $response->assertSee('Development Mode OTP');
        $response->assertSee('Auto-fill This Code');
    }

    public function test_successful_otp_verification_authenticates_user()
    {
        Http::fake([
            '*/auth/v1/verify' => Http::response([
                'user' => [
                    'id' => 'user-uuid-123',
                    'email' => 'deepuvlnd@gmail.com',
                ],
            ], 200),
        ]);

        $otp = 987654;
        $response = $this->withSession([
            'auth_email' => 'deepuvlnd@gmail.com',
        ])->post('/login/verify', [
            'otp' => $otp,
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertEquals('deepuvlnd@gmail.com', session('authenticated_user'));
        $this->assertNotNull(session('user'));
    }

    public function test_incorrect_otp_fails()
    {
        Http::fake([
            '*/auth/v1/verify' => Http::response([
                'msg' => 'Invalid token',
            ], 400),
        ]);

        $otp = 987654;
        $response = $this->withSession([
            'auth_email' => 'deepuvlnd@gmail.com',
        ])->post('/login/verify', [
            'otp' => 111111,
        ]);

        $response->assertSessionHasErrors('otp');
        $this->assertNull(session('authenticated_user'));
    }

    public function test_send_otp_falls_back_to_mail_when_supabase_fails()
    {
        Http::fake([
            '*/auth/v1/otp' => Http::response([
                'message' => 'Invalid API key',
            ], 401),
        ]);

        $this->withSession(['captcha_result' => 12]);

        $response = $this->post('/login/send-otp', [
            'email' => 'player@example.com',
            'captcha' => 12,
        ]);

        $response->assertRedirect(route('login.verify'));
        $this->assertEquals('player@example.com', session('auth_email'));
        $this->assertNotNull(session('login_otp'));
    }

    public function test_fallback_otp_verification_succeeds()
    {
        $otp = '123456';
        $response = $this->withSession([
            'auth_email' => 'player@example.com',
            'login_email' => 'player@example.com',
            'login_otp' => $otp,
        ])->post('/login/verify', [
            'otp' => $otp,
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertEquals('player@example.com', session('authenticated_user'));
    }

    public function test_eight_digit_otp_verification_succeeds()
    {
        Http::fake([
            '*/auth/v1/verify' => Http::response([
                'user' => [
                    'id' => 'user-uuid-888',
                    'email' => 'player8@example.com',
                ],
            ], 200),
        ]);

        $eightDigitOtp = '12345678';
        $response = $this->withSession([
            'auth_email' => 'player8@example.com',
        ])->post('/login/verify', [
            'otp' => $eightDigitOtp,
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertEquals('player8@example.com', session('authenticated_user'));
    }
}
