<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ClubAbout;
use Illuminate\Foundation\Testing\RefreshDatabase;

class AboutClubTest extends TestCase
{
    use RefreshDatabase;

    public function test_home_page_displays_about_buttons()
    {
        $response = $this->get('/');
        $response->assertStatus(200);

        // Verify ABOUT button in navigation
        $response->assertSee(route('about'));
        $response->assertSee('ABOUT');

        // Verify ABOUT US button in hero section
        $response->assertSee('ABOUT US');
    }

    public function test_public_about_page_loads_with_club_details()
    {
        $about = ClubAbout::first();
        $about->update([
            'title' => 'UNITED SENIORS VELLANAD',
            'tagline' => 'Passion, Brotherhood & Cricket Spirit',
            'description' => 'A premier cricket club in Vellanad fostering brotherhood and athletic excellence.',
            'mission' => 'To promote cricket and sporting excellence in Vellanad.',
            'vision' => 'To be a distinguished and inspiring community sports organization.',
            'established_year' => '2018',
            'home_ground' => 'Vellanad Ground, Thiruvananthapuram',
            'contact_email' => 'deepuvlnd84@gmail.com',
            'contact_phone' => '+91 94470 00000',
        ]);

        $response = $this->get('/about');
        $response->assertStatus(200);
        $response->assertSee('UNITED SENIORS VELLANAD');
        $response->assertSee('Passion, Brotherhood & Cricket Spirit');
        $response->assertSee('A premier cricket club in Vellanad fostering brotherhood and athletic excellence.');
        $response->assertSee('To promote cricket and sporting excellence in Vellanad.');
        $response->assertSee('Vellanad Ground, Thiruvananthapuram');
    }

    public function test_guest_cannot_access_about_edit_page()
    {
        $response = $this->get('/about/edit');
        $response->assertRedirect(route('login.admin'));
        $response->assertSessionHasErrors('auth');
    }

    public function test_regular_player_cannot_access_about_edit_page()
    {
        $response = $this->withSession([
            'authenticated_user' => 'player@example.com',
            'is_admin' => false,
        ])->get('/about/edit');

        $response->assertRedirect(route('login.admin'));
        $response->assertSessionHasErrors('auth');
    }

    public function test_admin_can_access_about_edit_page()
    {
        $response = $this->withSession([
            'authenticated_user' => 'Admin',
            'is_admin' => true,
        ])->get('/about/edit');

        $response->assertStatus(200);
        $response->assertSee('Edit Club Description & Info');
    }

    public function test_admin_can_update_club_description_and_details()
    {
        $about = ClubAbout::first();
        $about->update([
            'title' => 'UNITED SENIORS VELLANAD',
            'description' => 'Original description',
        ]);

        $updateResponse = $this->withSession([
            'authenticated_user' => 'Admin',
            'is_admin' => true,
        ])->put('/about', [
            'title' => 'UNITED SENIORS VELLANAD CRICKET CLUB',
            'tagline' => 'Pride of Vellanad Cricket',
            'description' => 'This is the freshly updated description written by the admin with exciting details about our victories and history.',
            'mission' => 'Our updated mission statement.',
            'vision' => 'Our updated vision statement.',
            'established_year' => '2016',
            'home_ground' => 'New Vellanad Stadium',
            'contact_email' => 'admin@usv.com',
            'contact_phone' => '+91 99999 88888',
        ]);

        $updateResponse->assertRedirect(route('about.edit'));
        $updateResponse->assertSessionHas('success');

        // Check database
        $about = ClubAbout::first();
        $this->assertEquals('UNITED SENIORS VELLANAD CRICKET CLUB', $about->title);
        $this->assertEquals('Pride of Vellanad Cricket', $about->tagline);
        $this->assertEquals('This is the freshly updated description written by the admin with exciting details about our victories and history.', $about->description);

        // Check public about page
        $publicResponse = $this->get('/about');
        $publicResponse->assertStatus(200);
        $publicResponse->assertSee('UNITED SENIORS VELLANAD CRICKET CLUB');
        $publicResponse->assertSee('Pride of Vellanad Cricket');
        $publicResponse->assertSee('This is the freshly updated description written by the admin with exciting details about our victories and history.');
        $publicResponse->assertSee('New Vellanad Stadium');
    }

    public function test_admin_dashboard_displays_about_club_tile()
    {
        $response = $this->withSession([
            'authenticated_user' => 'Admin',
            'is_admin' => true,
        ])->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('About Club');
        $response->assertSee(route('about.edit'));
    }
}
