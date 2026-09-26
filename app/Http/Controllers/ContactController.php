<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactSetting;
use App\Models\ContactPerson;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;

class ContactController extends Controller
{
    private function checkAdmin()
    {
        return Session::get('is_admin') === true || Session::get('authenticated_user') === 'Admin';
    }

    private function getSettings()
    {
        $settings = ContactSetting::first();
        if (!$settings) {
            $settings = ContactSetting::create([
                'president_name' => 'Deepu Vellanad',
                'president_role' => 'Club President',
                'president_phone' => '+91 94470 12345',
                'president_email' => 'president@usv.com',
                'coordinator_name' => 'Sujith S.',
                'coordinator_role' => 'General Coordinator',
                'coordinator_phone' => '+91 94470 67890',
                'coordinator_email' => 'coordinator@usv.com',
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

    private function ensureUploadDirectory($path)
    {
        try {
            if (!File::exists($path)) {
                File::makeDirectory($path, 0777, true, true);
            }
            return true;
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::warning("Could not create upload directory [{$path}]: " . $e->getMessage());
            return false;
        }
    }

    // Public Contact Page
    public function index()
    {
        $settings = $this->getSettings();
        $persons = ContactPerson::where('is_active', true)
            ->orderBy('order', 'asc')
            ->orderBy('id', 'asc')
            ->get();
        $isAdmin = $this->checkAdmin();

        return view('contact.index', compact('settings', 'persons', 'isAdmin'));
    }

    // Admin Manage Page
    public function manage()
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Only Admin has permission to manage contact details.']);
        }

        $settings = $this->getSettings();
        $persons = ContactPerson::orderBy('order', 'asc')->orderBy('id', 'asc')->get();

        return view('contact.manage', compact('settings', 'persons'));
    }

    // Update Leadership & Social Media Links
    public function updateSettings(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Only Admin has permission to manage contact details.']);
        }

        $request->validate([
            'president_name' => 'required|string|max:255',
            'president_role' => 'nullable|string|max:255',
            'president_phone' => 'required|string|max:50',
            'president_email' => 'nullable|email|max:255',
            'president_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            'coordinator_name' => 'required|string|max:255',
            'coordinator_role' => 'nullable|string|max:255',
            'coordinator_phone' => 'required|string|max:50',
            'coordinator_email' => 'nullable|email|max:255',
            'coordinator_photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',

            'facebook_url' => 'nullable|string|max:255',
            'instagram_url' => 'nullable|string|max:255',
            'youtube_url' => 'nullable|string|max:255',
            'club_email' => 'nullable|string|max:255',
            'club_phone' => 'nullable|string|max:50',
            'ground_location' => 'nullable|string|max:255',
            'ground_map_url' => 'nullable|string',
        ]);

        $settings = $this->getSettings();
        $uploadDir = public_path('uploads/contacts');
        if (!File::isDirectory($uploadDir)) {
            File::makeDirectory($uploadDir, 0775, true, true);
        }

        // Handle President Photo
        if ($request->hasFile('president_photo')) {
            try {
                $file = $request->file('president_photo');
                if ($file && $file->isValid()) {
                    try {
                        $uploadedFile = Cloudinary::upload($file->getRealPath(), [
                            'folder' => 'usv_contacts',
                            'transformation' => [
                                'width' => 500,
                                'height' => 500,
                                'crop' => 'fill',
                                'gravity' => 'face',
                                'quality' => 'auto',
                                'fetch_format' => 'auto'
                            ]
                        ]);
                        $settings->president_photo = $uploadedFile->getSecurePath();
                    } catch (\Throwable $e) {
                        $this->ensureUploadDirectory($uploadDir);
                        if ($settings->president_photo && File::exists($uploadDir . '/' . $settings->president_photo)) {
                            @File::delete($uploadDir . '/' . $settings->president_photo);
                        }
                        $presPhotoName = 'pres_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move($uploadDir, $presPhotoName);
                        $settings->president_photo = $presPhotoName;
                    }
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("President photo upload failed: " . $e->getMessage());
            }
        }

        // Handle Coordinator Photo
        if ($request->hasFile('coordinator_photo')) {
            try {
                $file = $request->file('coordinator_photo');
                if ($file && $file->isValid()) {
                    try {
                        $uploadedFile = Cloudinary::upload($file->getRealPath(), [
                            'folder' => 'usv_contacts',
                            'transformation' => [
                                'width' => 500,
                                'height' => 500,
                                'crop' => 'fill',
                                'gravity' => 'face',
                                'quality' => 'auto',
                                'fetch_format' => 'auto'
                            ]
                        ]);
                        $settings->coordinator_photo = $uploadedFile->getSecurePath();
                    } catch (\Throwable $e) {
                        $this->ensureUploadDirectory($uploadDir);
                        if ($settings->coordinator_photo && File::exists($uploadDir . '/' . $settings->coordinator_photo)) {
                            @File::delete($uploadDir . '/' . $settings->coordinator_photo);
                        }
                        $coordPhotoName = 'coord_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                        $file->move($uploadDir, $coordPhotoName);
                        $settings->coordinator_photo = $coordPhotoName;
                    }
                }
            } catch (\Throwable $e) {
                \Illuminate\Support\Facades\Log::error("Coordinator photo upload failed: " . $e->getMessage());
            }
        }

        $settings->president_name = $request->president_name;
        $settings->president_role = $request->president_role ?? 'Club President';
        $settings->president_phone = $request->president_phone;
        $settings->president_email = $request->president_email;

        $settings->coordinator_name = $request->coordinator_name;
        $settings->coordinator_role = $request->coordinator_role ?? 'General Coordinator';
        $settings->coordinator_phone = $request->coordinator_phone;
        $settings->coordinator_email = $request->coordinator_email;

        $settings->facebook_url = $request->facebook_url;
        $settings->instagram_url = $request->instagram_url;
        $settings->youtube_url = $request->youtube_url;

        $settings->club_email = $request->club_email;
        $settings->club_phone = $request->club_phone;
        $settings->ground_location = $request->ground_location;
        $settings->ground_map_url = $request->ground_map_url;

        $settings->save();

        return redirect()->back()->with('success', 'Leadership details and social links updated successfully!');
    }

    // Add a new Committee Member / Contact Person
    public function storePerson(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Only Admin has permission to add contact persons.']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'nullable|integer|min:0',
        ]);

        $photoName = null;
        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            if ($file && $file->isValid()) {
                try {
                    $uploadedFile = Cloudinary::upload($file->getRealPath(), [
                        'folder' => 'usv_contacts',
                        'transformation' => [
                            'width' => 500,
                            'height' => 500,
                            'crop' => 'fill',
                            'gravity' => 'face',
                            'quality' => 'auto',
                            'fetch_format' => 'auto'
                        ]
                    ]);
                    $photoName = $uploadedFile->getSecurePath();
                } catch (\Throwable $e) {
                    $uploadDir = public_path('uploads/contacts');
                    if (!File::isDirectory($uploadDir)) {
                        File::makeDirectory($uploadDir, 0775, true, true);
                    }
                    $photoName = 'person_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadDir, $photoName);
                }
            }
        }

        $nextOrder = $request->filled('order')
            ? (int)$request->order
            : (ContactPerson::max('order') ?? 0) + 1;

        ContactPerson::create([
            'name' => $request->name,
            'designation' => $request->designation,
            'phone' => $request->phone,
            'photo' => $photoName,
            'order' => $nextOrder,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', "Member '{$request->name}' added successfully!");
    }

    // Update an existing Committee Member / Contact Person
    public function updatePerson(Request $request, $id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Only Admin has permission to edit contact persons.']);
        }

        $person = ContactPerson::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'designation' => 'required|string|max:255',
            'phone' => 'required|string|max:50',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
            'order' => 'nullable|integer|min:0',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            if ($file && $file->isValid()) {
                try {
                    $uploadedFile = Cloudinary::upload($file->getRealPath(), [
                        'folder' => 'usv_contacts',
                        'transformation' => [
                            'width' => 500,
                            'height' => 500,
                            'crop' => 'fill',
                            'gravity' => 'face',
                            'quality' => 'auto',
                            'fetch_format' => 'auto'
                        ]
                    ]);
                    $person->photo = $uploadedFile->getSecurePath();
                } catch (\Throwable $e) {
                    $uploadDir = public_path('uploads/contacts');
                    if (!File::isDirectory($uploadDir)) {
                        File::makeDirectory($uploadDir, 0775, true, true);
                    }
                    if ($person->photo && File::exists($uploadDir . '/' . $person->photo)) {
                        @File::delete($uploadDir . '/' . $person->photo);
                    }
                    $photoName = 'person_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
                    $file->move($uploadDir, $photoName);
                    $person->photo = $photoName;
                }
            }
        }

        $person->name = $request->name;
        $person->designation = $request->designation;
        $person->phone = $request->phone;
        if ($request->filled('order')) {
            $person->order = (int)$request->order;
        }
        $person->save();

        return redirect()->back()->with('success', "Member '{$person->name}' updated successfully!");
    }

    // Delete a Committee Member
    public function destroyPerson($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Only Admin has permission to delete contact persons.']);
        }

        $person = ContactPerson::findOrFail($id);
        $name = $person->name;

        if ($person->photo) {
            $photoPath = public_path('uploads/contacts/' . $person->photo);
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }
        }

        $person->delete();

        return redirect()->back()->with('success', "Member '{$name}' deleted successfully!");
    }
}
