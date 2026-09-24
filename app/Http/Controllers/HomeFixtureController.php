<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\HomeFixture;
use App\Models\FixtureSetting;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class HomeFixtureController extends Controller
{
    private function checkAdmin()
    {
        return Session::get('is_admin') === true;
    }

    // Store a new fixture
    public function store(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->back()->withErrors(['auth' => 'Only Admin has permission to add fixtures.']);
        }

        $request->validate([
            'match_no' => 'required|string|max:100',
            'stage' => 'required|string|max:150',
            'team1' => 'required|string|max:255',
            'team1_short' => 'nullable|string|max:10',
            'team1_score' => 'nullable|string|max:50',
            'team2' => 'required|string|max:255',
            'team2_short' => 'nullable|string|max:10',
            'team2_score' => 'nullable|string|max:50',
            'match_date' => 'required|string|max:100',
            'match_time' => 'required|string|max:100',
            'venue' => 'nullable|string|max:255',
            'status' => 'required|string|in:Upcoming,Ongoing,Completed',
            'result' => 'nullable|string|max:255',
        ]);

        HomeFixture::create([
            'match_no' => $request->match_no,
            'stage' => $request->stage,
            'team1' => $request->team1,
            'team1_short' => $request->team1_short ?? strtoupper(substr($request->team1, 0, 3)),
            'team1_score' => $request->team1_score,
            'team2' => $request->team2,
            'team2_short' => $request->team2_short ?? strtoupper(substr($request->team2, 0, 3)),
            'team2_score' => $request->team2_score,
            'match_date' => $request->match_date,
            'match_time' => $request->match_time,
            'venue' => $request->venue ?? 'Vellanad Stadium',
            'status' => $request->status,
            'result' => $request->result,
            'order_position' => HomeFixture::max('order_position') + 1,
        ]);

        return redirect()->back()->with('success', 'Fixture match added successfully!');
    }

    // Update an existing fixture match
    public function update(Request $request, $id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->back()->withErrors(['auth' => 'Only Admin has permission to edit fixtures.']);
        }

        $fixture = HomeFixture::findOrFail($id);

        $request->validate([
            'match_no' => 'required|string|max:100',
            'stage' => 'required|string|max:150',
            'team1' => 'required|string|max:255',
            'team1_short' => 'nullable|string|max:10',
            'team1_score' => 'nullable|string|max:50',
            'team2' => 'required|string|max:255',
            'team2_short' => 'nullable|string|max:10',
            'team2_score' => 'nullable|string|max:50',
            'match_date' => 'required|string|max:100',
            'match_time' => 'required|string|max:100',
            'venue' => 'nullable|string|max:255',
            'status' => 'required|string|in:Upcoming,Ongoing,Completed',
            'result' => 'nullable|string|max:255',
        ]);

        $fixture->update([
            'match_no' => $request->match_no,
            'stage' => $request->stage,
            'team1' => $request->team1,
            'team1_short' => $request->team1_short ?? strtoupper(substr($request->team1, 0, 3)),
            'team1_score' => $request->team1_score,
            'team2' => $request->team2,
            'team2_short' => $request->team2_short ?? strtoupper(substr($request->team2, 0, 3)),
            'team2_score' => $request->team2_score,
            'match_date' => $request->match_date,
            'match_time' => $request->match_time,
            'venue' => $request->venue ?? 'Vellanad Stadium',
            'status' => $request->status,
            'result' => $request->result,
        ]);

        return redirect()->back()->with('success', "Fixture '{$fixture->match_no}' updated successfully!");
    }

    // Delete a fixture
    public function destroy($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->back()->withErrors(['auth' => 'Only Admin has permission to delete fixtures.']);
        }

        $fixture = HomeFixture::findOrFail($id);
        $fixture->delete();

        return redirect()->back()->with('success', 'Fixture deleted successfully!');
    }

    // Upload/update FULL FIXTURES PDF
    public function uploadPdf(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->back()->withErrors(['auth' => 'Only Admin has permission to upload fixtures PDF.']);
        }

        $request->validate([
            'pdf_file' => 'required|mimes:pdf|max:10240', // Max 10MB PDF
        ], [
            'pdf_file.required' => 'Please select a valid PDF file to upload.',
            'pdf_file.mimes' => 'Only PDF files are allowed.',
            'pdf_file.max' => 'PDF file size must not exceed 10MB.',
        ]);

        $destinationPath = public_path('uploads/fixtures');
        if (!File::exists($destinationPath)) {
            File::makeDirectory($destinationPath, 0755, true, true);
        }

        $file = $request->file('pdf_file');
        $fileName = 'full_fixtures_' . time() . '.' . $file->getClientOriginalExtension();
        $file->move($destinationPath, $fileName);

        $setting = FixtureSetting::first();
        if (!$setting) {
            $setting = new FixtureSetting();
        }

        // Delete old PDF if exists
        if ($setting->pdf_filename && File::exists(public_path('uploads/fixtures/' . $setting->pdf_filename))) {
            File::delete(public_path('uploads/fixtures/' . $setting->pdf_filename));
        }

        $setting->pdf_filename = $fileName;
        $setting->save();

        return redirect()->back()->with('success', 'FULL FIXTURES PDF uploaded and updated successfully!');
    }
}
