<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ContactSetting;
use App\Models\ContactPerson;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class ContactController extends Controller
{
    private function checkAdmin()
    {
        return Session::get('is_admin') === true;
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
                'facebook_url' => 'https://facebook.com',
                'instagram_url' => 'https://instagram.com',
                'youtube_url' => 'https://youtube.com',
            ]);
        }
        return $settings;
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
        ]);

        $settings = $this->getSettings();
        $uploadDir = public_path('uploads/contacts');

        if (!File::isDirectory($uploadDir)) {
            File::makeDirectory($uploadDir, 0755, true, true);
        }

        // Handle President Photo
        if ($request->hasFile('president_photo')) {
            if ($settings->president_photo && File::exists($uploadDir . '/' . $settings->president_photo)) {
                File::delete($uploadDir . '/' . $settings->president_photo);
            }
            $file = $request->file('president_photo');
            $presPhotoName = 'pres_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $presPhotoName);
            $settings->president_photo = $presPhotoName;
        }

        // Handle Coordinator Photo
        if ($request->hasFile('coordinator_photo')) {
            if ($settings->coordinator_photo && File::exists($uploadDir . '/' . $settings->coordinator_photo)) {
                File::delete($uploadDir . '/' . $settings->coordinator_photo);
            }
            $file = $request->file('coordinator_photo');
            $coordPhotoName = 'coord_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $coordPhotoName);
            $settings->coordinator_photo = $coordPhotoName;
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
            $uploadDir = public_path('uploads/contacts');
            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true, true);
            }
            $file = $request->file('photo');
            $photoName = 'person_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $photoName);
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
            $uploadDir = public_path('uploads/contacts');
            if ($person->photo && File::exists($uploadDir . '/' . $person->photo)) {
                File::delete($uploadDir . '/' . $person->photo);
            }
            $file = $request->file('photo');
            $photoName = 'person_' . time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $photoName);
            $person->photo = $photoName;
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
