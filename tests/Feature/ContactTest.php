<?php

namespace Tests\Feature;

use Tests\TestCase;
use App\Models\ContactSetting;
use App\Models\ContactPerson;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\File;

class ContactTest extends TestCase
{
    use RefreshDatabase;

    public function test_contact_nav_link_present_on_home_page()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
        $response->assertSee(route('contact'));
        $response->assertSee('CONTACT');
    }

    public function test_public_contact_page_loads_with_president_coordinator_and_ten_persons()
    {
        $response = $this->get('/contact');
        $response->assertStatus(200);

        // Check President & Coordinator
        $response->assertSee('Leadership');
        $response->assertSee('Deepu Vellanad');
        $response->assertSee('+91 94470 12345');
        $response->assertSee('Sujith S.');
        $response->assertSee('+91 94470 67890');

        // Check committee members count (10 seeded)
        $this->assertEquals(10, ContactPerson::where('is_active', true)->count());
        $response->assertSee('Rahul R. Nair');
        $response->assertSee('General Secretary');
        $response->assertSee('Anil Kumar M.');
        $response->assertSee('Vice President');
        $response->assertSee('Bipin B. S.');
        $response->assertSee('Team Captain');

        // Check social links
        $response->assertSee('Facebook');
        $response->assertSee('Instagram');
        $response->assertSee('YouTube');
    }

    public function test_guest_cannot_access_contact_manage_page()
    {
        $response = $this->get('/contact/manage');
        $response->assertRedirect(route('login.admin'));
        $response->assertSessionHasErrors('auth');
    }

    public function test_regular_player_cannot_access_contact_manage_page()
    {
        $response = $this->withSession([
            'authenticated_user' => 'player@example.com',
            'is_admin' => false,
        ])->get('/contact/manage');

        $response->assertRedirect(route('login.admin'));
        $response->assertSessionHasErrors('auth');
    }

    public function test_admin_can_access_contact_manage_page()
    {
        $response = $this->withSession([
            'authenticated_user' => 'Admin',
            'is_admin' => true,
        ])->get('/contact/manage');

        $response->assertStatus(200);
        $response->assertSee('Manage Contact Directory');
        $response->assertSee('Deepu Vellanad');
        $response->assertSee('Sujith S.');
    }

    public function test_admin_can_update_leadership_and_social_links()
    {
        $adminSession = [
            'authenticated_user' => 'Admin',
            'is_admin' => true,
        ];

        $response = $this->withSession($adminSession)
            ->post('/contact/settings', [
                'president_name' => 'Deepu Vellanad Updated',
                'president_role' => 'Executive Club President',
                'president_phone' => '+91 99999 11111',
                'president_email' => 'newpres@usv.com',
                'coordinator_name' => 'Sujith S. Updated',
                'coordinator_role' => 'Senior Coordinator',
                'coordinator_phone' => '+91 99999 22222',
                'coordinator_email' => 'newcoord@usv.com',
                'facebook_url' => 'https://facebook.com/unitedseniorsvellanad',
                'instagram_url' => 'https://instagram.com/unitedseniorsvellanad',
                'youtube_url' => 'https://youtube.com/@unitedseniorsvellanad',
            ]);

        $response->assertRedirect();
        $response->assertSessionHas('success');

        $settings = ContactSetting::first();
        $this->assertEquals('Deepu Vellanad Updated', $settings->president_name);
        $this->assertEquals('+91 99999 11111', $settings->president_phone);
        $this->assertEquals('Sujith S. Updated', $settings->coordinator_name);
        $this->assertEquals('+91 99999 22222', $settings->coordinator_phone);
        $this->assertEquals('https://facebook.com/unitedseniorsvellanad', $settings->facebook_url);
        $this->assertEquals('https://instagram.com/unitedseniorsvellanad', $settings->instagram_url);
        $this->assertEquals('https://youtube.com/@unitedseniorsvellanad', $settings->youtube_url);

        // Check public page
        $public = $this->get('/contact');
        $public->assertSee('Deepu Vellanad Updated');
        $public->assertSee('+91 99999 11111');
        $public->assertSee('Sujith S. Updated');
        $public->assertSee('+91 99999 22222');
        $public->assertSee('https://facebook.com/unitedseniorsvellanad');
    }

    public function test_admin_can_add_edit_and_delete_committee_person()
    {
        $adminSession = [
            'authenticated_user' => 'Admin',
            'is_admin' => true,
        ];

        // 1. Add Person
        $storeResponse = $this->withSession($adminSession)
            ->post('/contact/persons', [
                'name' => 'Kiran Raj',
                'designation' => 'Media Manager',
                'phone' => '+91 98470 55555',
                'order' => 11,
            ]);

        $storeResponse->assertRedirect();
        $storeResponse->assertSessionHas('success');

        $person = ContactPerson::where('name', 'Kiran Raj')->first();
        $this->assertNotNull($person);
        $this->assertEquals('Media Manager', $person->designation);
        $this->assertEquals('+91 98470 55555', $person->phone);

        // 2. Update Person
        $updateResponse = $this->withSession($adminSession)
            ->put('/contact/persons/' . $person->id, [
                'name' => 'Kiran Raj Updated',
                'designation' => 'Senior Media Manager',
                'phone' => '+91 98470 66666',
                'order' => 12,
            ]);

        $updateResponse->assertRedirect();
        $updateResponse->assertSessionHas('success');

        $person->refresh();
        $this->assertEquals('Kiran Raj Updated', $person->name);
        $this->assertEquals('Senior Media Manager', $person->designation);
        $this->assertEquals('+91 98470 66666', $person->phone);

        // 3. Delete Person
        $deleteResponse = $this->withSession($adminSession)
            ->delete('/contact/persons/' . $person->id);

        $deleteResponse->assertRedirect();
        $deleteResponse->assertSessionHas('success');
        $this->assertNull(ContactPerson::find($person->id));
    }

    public function test_dashboard_has_manage_contacts_tile_for_admin()
    {
        $response = $this->withSession([
            'authenticated_user' => 'Admin',
            'is_admin' => true,
        ])->get('/dashboard');

        $response->assertStatus(200);
        $response->assertSee('Manage Contacts');
        $response->assertSee(route('contact.manage'));
    }
}
