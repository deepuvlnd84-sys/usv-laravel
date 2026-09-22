<?php

namespace Tests\Feature;

use Tests\TestCase;
use Illuminate\Support\Facades\Session;

class AuthTest extends TestCase
{
    public function test_login_page_loads_successfully()
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
        $response->assertSee('Sign In');
        $response->assertSee('Captcha Validation');
    }

    public function test_send_otp_with_correct_captcha_redirects_to_verify()
    {
        // Simulate session captcha
        $this->withSession(['captcha_result' => 10]);

        $response = $this->post('/login/send-otp', [
            'email' => 'deepuvlnd@gmail.com',
            'captcha' => 10,
        ]);

        $response->assertRedirect(route('login.verify'));
        $this->assertEquals('deepuvlnd@gmail.com', session('login_email'));
        $this->assertNotEmpty(session('login_otp'));
    }

    public function test_verify_page_displays_otp_in_debug_mode()
    {
        $otp = 654321;
        $response = $this->withSession([
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
        $otp = 987654;
        $response = $this->withSession([
            'login_email' => 'deepuvlnd@gmail.com',
            'login_otp' => $otp,
        ])->post('/login/verify', [
            'otp' => $otp,
        ]);

        $response->assertRedirect(route('dashboard'));
        $this->assertEquals('deepuvlnd@gmail.com', session('authenticated_user'));
        $this->assertNull(session('login_otp'));
    }

    public function test_incorrect_otp_fails()
    {
        $otp = 987654;
        $response = $this->withSession([
            'login_email' => 'deepuvlnd@gmail.com',
            'login_otp' => $otp,
        ])->post('/login/verify', [
            'otp' => 111111,
        ]);

        $response->assertSessionHasErrors('otp');
        $this->assertNull(session('authenticated_user'));
    }
}
