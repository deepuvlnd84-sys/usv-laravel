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
}
