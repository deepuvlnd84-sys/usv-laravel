<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ClubAbout;
use Illuminate\Support\Facades\Session;

class AboutController extends Controller
{
    private function checkAdmin()
    {
        return Session::get('is_admin') === true;
    }

    private function getClubAbout()
    {
        $about = ClubAbout::first();
        if (!$about) {
            $about = ClubAbout::create([
                'title' => 'UNITED SENIORS VELLANAD',
                'tagline' => 'Passion, Brotherhood & Cricket Spirit',
                'description' => "United Seniors Vellanad (USV) is a premier cricket club rooted in the scenic heartlands of Vellanad, Thiruvananthapuram. Built on the bedrock of genuine sportsmanship, athletic dedication, and lifelong camaraderie, USV unites seasoned cricketers and enthusiastic players across generations under a common banner of passion for the gentleman's game.\n\nSince our inception, United Seniors Vellanad has actively competed in regional tournaments, club fixtures, and invitational championships. Beyond runs and wickets, our club represents an enduring brotherhood that celebrates community bonding, healthy active lifestyles, and mentorship for young budding cricketers.\n\nWhether on the pitch chasing victory or off the pitch organizing local sports initiatives, USV continues to carry forward the timeless spirit and joy of cricket in Vellanad.",
                'mission' => 'To promote cricket and sporting excellence in Vellanad, nurturing athletic talent, teamwork, and healthy living across all age groups while upholding the highest ideals of fair play and sportsmanship.',
                'vision' => 'To be a distinguished and inspiring community sports organization renowned for cricket achievement, youth development, and enduring brotherhood.',
                'established_year' => '2018',
                'home_ground' => 'Vellanad Ground, Thiruvananthapuram, Kerala',
                'contact_email' => 'deepuvlnd84@gmail.com',
                'contact_phone' => '+91 94470 00000',
            ]);
        }
        return $about;
    }

    // Public About Page
    public function index()
    {
        $about = $this->getClubAbout();
        $isAdmin = $this->checkAdmin();

        return view('about.index', compact('about', 'isAdmin'));
    }

    // Admin Edit Page
    public function edit()
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Only Admin has permission to edit club details.']);
        }

        $about = $this->getClubAbout();

        return view('about.edit', compact('about'));
    }

    // Process Update (Admin only)
    public function update(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Only Admin has permission to edit club details.']);
        }

        $request->validate([
            'title' => 'required|string|max:255',
            'tagline' => 'nullable|string|max:255',
            'description' => 'required|string',
            'mission' => 'nullable|string',
            'vision' => 'nullable|string',
            'established_year' => 'nullable|string|max:50',
            'home_ground' => 'nullable|string|max:255',
            'contact_email' => 'nullable|email|max:255',
            'contact_phone' => 'nullable|string|max:50',
        ]);

        $about = $this->getClubAbout();

        $about->update([
            'title' => $request->title,
            'tagline' => $request->tagline,
            'description' => $request->description,
            'mission' => $request->mission,
            'vision' => $request->vision,
            'established_year' => $request->established_year,
            'home_ground' => $request->home_ground,
            'contact_email' => $request->contact_email,
            'contact_phone' => $request->contact_phone,
        ]);

        return redirect()->route('about.edit')->with('success', 'Club details and description updated successfully!');
    }
}
