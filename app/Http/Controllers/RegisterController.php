<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\RegisterDetail;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class RegisterController extends Controller
{
    /**
     * Check if currently authenticated user is Admin
     */
    private function checkAdmin()
    {
        return Session::get('is_admin') === true;
    }

    /**
     * Show the public Registration Form
     */
    public function create()
    {
        return view('register.create');
    }

    /**
     * Store new registration from public form
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            // Section 1: Basic Details
            'name' => 'required|string|max:150',
            'mobile_no' => 'required|string|max:30',
            'address' => 'nullable|string|max:500',
            'age' => 'nullable|integer|min:5|max:100',
            'dob' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'education_qualification' => 'nullable|string|max:150',
            'job' => 'nullable|string|max:150',
            'remarks' => 'nullable|string|max:1000',

            // Section 2: Player Details
            'playing_role' => 'required|string|in:Batsman,Bowler,Allrounder,Wicket Keeper Batsman',
            'batting_style' => 'nullable|string|max:50',
            'bowling_arm' => 'nullable|string|max:50',
            'bowling_pace' => 'nullable|string|max:50',
            'wicket_keeping_style' => 'nullable|string|max:100',
            'batting_position' => 'nullable|string|max:50',
            'jersey_number' => 'nullable|string|max:10',
            'previous_clubs' => 'nullable|string|max:255',
            'cricket_experience' => 'nullable|string|max:255',
        ], [
            'name.required' => 'Please enter your full name.',
            'mobile_no.required' => 'Mobile number is required for registration.',
            'playing_role.required' => 'Please select your playing role.',
            'playing_role.in' => 'Selected playing role is invalid.',
            'photo.image' => 'The uploaded file must be an image.',
            'photo.max' => 'Photo size should not exceed 5MB.',
        ]);

        $photoName = null;
        if ($request->hasFile('photo')) {
            $destinationPath = public_path('uploads/registrations');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            $file = $request->file('photo');
            $photoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $photoName);
        }

        try {
            $record = RegisterDetail::create([
                'photo' => $photoName,
                'name' => trim($validated['name']),
                'mobile_no' => trim($validated['mobile_no']),
                'address' => $request->filled('address') ? trim($validated['address']) : null,
                'age' => $request->filled('age') ? (int) $validated['age'] : null,
                'dob' => $request->filled('dob') ? $validated['dob'] : null,
                'blood_group' => $request->filled('blood_group') ? $validated['blood_group'] : null,
                'education_qualification' => $request->filled('education_qualification') ? trim($validated['education_qualification']) : null,
                'job' => $request->filled('job') ? trim($validated['job']) : null,
                'remarks' => $request->filled('remarks') ? trim($validated['remarks']) : null,
                
                'playing_role' => $validated['playing_role'],
                'batting_style' => $request->filled('batting_style') ? $validated['batting_style'] : null,
                'bowling_arm' => $request->filled('bowling_arm') ? $validated['bowling_arm'] : null,
                'bowling_pace' => $request->filled('bowling_pace') ? $validated['bowling_pace'] : null,
                'wicket_keeping_style' => $request->filled('wicket_keeping_style') ? trim($validated['wicket_keeping_style']) : null,
                'batting_position' => $request->filled('batting_position') ? $validated['batting_position'] : null,
                'jersey_number' => $request->filled('jersey_number') ? trim($validated['jersey_number']) : null,
                'previous_clubs' => $request->filled('previous_clubs') ? trim($validated['previous_clubs']) : null,
                'cricket_experience' => $request->filled('cricket_experience') ? trim($validated['cricket_experience']) : null,
                'is_locked' => false,
            ]);

            return redirect()->route('register.create')->with([
                'success' => "Registration successful! Welcome to United Seniors Vellanad, {$record->name}.",
                'registered_id' => $record->id,
                'registered_name' => $record->name,
                'registered_role' => $record->playing_role,
            ]);
        } catch (\Throwable $e) {
            \Illuminate\Support\Facades\Log::error("Registration error: " . $e->getMessage());
            return redirect()->back()->withInput()->withErrors([
                'db' => "Database connection issue: Unable to save registration at this moment. Please try again shortly or contact the administrator."
            ]);
        }
    }

    /**
     * Admin view: List all registrations, filter, search, manage
     */
    public function adminIndex(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Admin sign-in required to manage registration records.']);
        }

        $query = RegisterDetail::query();

        // Search filter
        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('mobile_no', 'like', "%{$search}%")
                  ->orWhere('education_qualification', 'like', "%{$search}%")
                  ->orWhere('job', 'like', "%{$search}%")
                  ->orWhere('blood_group', 'like', "%{$search}%")
                  ->orWhere('jersey_number', 'like', "%{$search}%");
            });
        }

        // Role filter
        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('playing_role', $request->role);
        }

        // Lock status filter
        if ($request->filled('status')) {
            if ($request->status === 'locked') {
                $query->where('is_locked', true);
            } elseif ($request->status === 'unlocked') {
                $query->where('is_locked', false);
            }
        }

        $registrations = $query->latest()->get();

        // Summary counts
        $totalCount = RegisterDetail::count();
        $batsmanCount = RegisterDetail::where('playing_role', 'Batsman')->count();
        $bowlerCount = RegisterDetail::where('playing_role', 'Bowler')->count();
        $allrounderCount = RegisterDetail::where('playing_role', 'Allrounder')->count();
        $wkCount = RegisterDetail::where('playing_role', 'Wicket Keeper Batsman')->count();
        $lockedCount = RegisterDetail::where('is_locked', true)->count();
        $unlockedCount = RegisterDetail::where('is_locked', false)->count();

        return view('admin.registrations.index', compact(
            'registrations',
            'totalCount',
            'batsmanCount',
            'bowlerCount',
            'allrounderCount',
            'wkCount',
            'lockedCount',
            'unlockedCount'
        ));
    }

    /**
     * Admin: Add a new registration manually
     */
    public function adminStore(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Admin sign-in required.']);
        }

        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'name' => 'required|string|max:150',
            'mobile_no' => 'required|string|max:30',
            'address' => 'nullable|string|max:500',
            'age' => 'nullable|integer|min:5|max:100',
            'dob' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'education_qualification' => 'nullable|string|max:150',
            'job' => 'nullable|string|max:150',
            'remarks' => 'nullable|string|max:1000',
            'playing_role' => 'required|string|in:Batsman,Bowler,Allrounder,Wicket Keeper Batsman',
            'batting_style' => 'nullable|string|max:50',
            'bowling_arm' => 'nullable|string|max:50',
            'bowling_pace' => 'nullable|string|max:50',
            'wicket_keeping_style' => 'nullable|string|max:100',
            'batting_position' => 'nullable|string|max:50',
            'jersey_number' => 'nullable|string|max:10',
            'previous_clubs' => 'nullable|string|max:255',
            'cricket_experience' => 'nullable|string|max:255',
            'is_locked' => 'nullable|boolean',
        ]);

        $photoName = null;
        if ($request->hasFile('photo')) {
            $destinationPath = public_path('uploads/registrations');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }
            $file = $request->file('photo');
            $photoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $photoName);
        }

        RegisterDetail::create([
            'photo' => $photoName,
            'name' => trim($validated['name']),
            'mobile_no' => trim($validated['mobile_no']),
            'address' => $request->filled('address') ? trim($validated['address']) : null,
            'age' => $request->filled('age') ? (int) $validated['age'] : null,
            'dob' => $request->filled('dob') ? $validated['dob'] : null,
            'blood_group' => $request->filled('blood_group') ? $validated['blood_group'] : null,
            'education_qualification' => $request->filled('education_qualification') ? trim($validated['education_qualification']) : null,
            'job' => $request->filled('job') ? trim($validated['job']) : null,
            'remarks' => $request->filled('remarks') ? trim($validated['remarks']) : null,
            'playing_role' => $validated['playing_role'],
            'batting_style' => $request->filled('batting_style') ? $validated['batting_style'] : null,
            'bowling_arm' => $request->filled('bowling_arm') ? $validated['bowling_arm'] : null,
            'bowling_pace' => $request->filled('bowling_pace') ? $validated['bowling_pace'] : null,
            'wicket_keeping_style' => $request->filled('wicket_keeping_style') ? trim($validated['wicket_keeping_style']) : null,
            'batting_position' => $request->filled('batting_position') ? $validated['batting_position'] : null,
            'jersey_number' => $request->filled('jersey_number') ? trim($validated['jersey_number']) : null,
            'previous_clubs' => $request->filled('previous_clubs') ? trim($validated['previous_clubs']) : null,
            'cricket_experience' => $request->filled('cricket_experience') ? trim($validated['cricket_experience']) : null,
            'is_locked' => $request->boolean('is_locked'),
        ]);

        return redirect()->route('admin.register.index')->with('success', "Player '{$validated['name']}' added successfully!");
    }

    /**
     * Admin: Update registration details
     */
    public function adminUpdate(Request $request, $id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Admin sign-in required.']);
        }

        $record = RegisterDetail::findOrFail($id);

        // Check if locked
        if ($record->is_locked && !$request->has('force_unlock')) {
            return redirect()->back()->withErrors(['locked' => "Record for '{$record->name}' is locked. Please unlock first to make edits."]);
        }

        $validated = $request->validate([
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp,gif|max:5120',
            'name' => 'required|string|max:150',
            'mobile_no' => 'required|string|max:30',
            'address' => 'nullable|string|max:500',
            'age' => 'nullable|integer|min:5|max:100',
            'dob' => 'nullable|date',
            'blood_group' => 'nullable|string|max:10',
            'education_qualification' => 'nullable|string|max:150',
            'job' => 'nullable|string|max:150',
            'remarks' => 'nullable|string|max:1000',
            'playing_role' => 'required|string|in:Batsman,Bowler,Allrounder,Wicket Keeper Batsman',
            'batting_style' => 'nullable|string|max:50',
            'bowling_arm' => 'nullable|string|max:50',
            'bowling_pace' => 'nullable|string|max:50',
            'wicket_keeping_style' => 'nullable|string|max:100',
            'batting_position' => 'nullable|string|max:50',
            'jersey_number' => 'nullable|string|max:10',
            'previous_clubs' => 'nullable|string|max:255',
            'cricket_experience' => 'nullable|string|max:255',
            'is_locked' => 'nullable|boolean',
        ]);

        if ($request->hasFile('photo')) {
            $destinationPath = public_path('uploads/registrations');
            if (!File::isDirectory($destinationPath)) {
                File::makeDirectory($destinationPath, 0755, true, true);
            }

            // Remove previous photo if exists
            if ($record->photo && File::exists(public_path('uploads/registrations/' . $record->photo))) {
                File::delete(public_path('uploads/registrations/' . $record->photo));
            }

            $file = $request->file('photo');
            $photoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($destinationPath, $photoName);
            $record->photo = $photoName;
        }

        $record->name = trim($validated['name']);
        $record->mobile_no = trim($validated['mobile_no']);
        $record->address = $request->filled('address') ? trim($validated['address']) : null;
        $record->age = $request->filled('age') ? (int) $validated['age'] : null;
        $record->dob = $request->filled('dob') ? $validated['dob'] : null;
        $record->blood_group = $request->filled('blood_group') ? $validated['blood_group'] : null;
        $record->education_qualification = $request->filled('education_qualification') ? trim($validated['education_qualification']) : null;
        $record->job = $request->filled('job') ? trim($validated['job']) : null;
        $record->remarks = $request->filled('remarks') ? trim($validated['remarks']) : null;
        $record->playing_role = $validated['playing_role'];
        $record->batting_style = $request->filled('batting_style') ? $validated['batting_style'] : null;
        $record->bowling_arm = $request->filled('bowling_arm') ? $validated['bowling_arm'] : null;
        $record->bowling_pace = $request->filled('bowling_pace') ? $validated['bowling_pace'] : null;
        $record->wicket_keeping_style = $request->filled('wicket_keeping_style') ? trim($validated['wicket_keeping_style']) : null;
        $record->batting_position = $request->filled('batting_position') ? $validated['batting_position'] : null;
        $record->jersey_number = $request->filled('jersey_number') ? trim($validated['jersey_number']) : null;
        $record->previous_clubs = $request->filled('previous_clubs') ? trim($validated['previous_clubs']) : null;
        $record->cricket_experience = $request->filled('cricket_experience') ? trim($validated['cricket_experience']) : null;
        if ($request->has('is_locked')) {
            $record->is_locked = $request->boolean('is_locked');
        }

        $record->save();

        return redirect()->back()->with('success', "Registration details for '{$record->name}' updated successfully!");
    }

    /**
     * Admin: Toggle Lock status for a registration
     */
    public function toggleLock($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Admin sign-in required.']);
        }

        $record = RegisterDetail::findOrFail($id);
        $record->is_locked = !$record->is_locked;
        $record->save();

        $statusText = $record->is_locked ? 'Locked 🔒' : 'Unlocked 🔓';
        return redirect()->back()->with('success', "Registration details for '{$record->name}' are now {$statusText}.");
    }

    /**
     * Admin: Delete registration record
     */
    public function destroy($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Admin sign-in required.']);
        }

        $record = RegisterDetail::findOrFail($id);
        $name = $record->name;

        // Delete photo file if present
        if ($record->photo && File::exists(public_path('uploads/registrations/' . $record->photo))) {
            File::delete(public_path('uploads/registrations/' . $record->photo));
        }

        $record->delete();

        return redirect()->route('admin.register.index')->with('success', "Registration record for '{$name}' deleted successfully.");
    }

    /**
     * Admin: Print / Export registered details in Excel format (.xls)
     */
    public function exportExcel(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Admin sign-in required to export data.']);
        }

        $query = RegisterDetail::query();

        if ($request->filled('search')) {
            $search = trim($request->search);
            $query->where(function ($q) use ($search) {
                $q->where('name', 'like', "%{$search}%")
                  ->orWhere('mobile_no', 'like', "%{$search}%")
                  ->orWhere('education_qualification', 'like', "%{$search}%")
                  ->orWhere('job', 'like', "%{$search}%")
                  ->orWhere('blood_group', 'like', "%{$search}%")
                  ->orWhere('jersey_number', 'like', "%{$search}%");
            });
        }

        if ($request->filled('role') && $request->role !== 'all') {
            $query->where('playing_role', $request->role);
        }

        if ($request->filled('status')) {
            if ($request->status === 'locked') {
                $query->where('is_locked', true);
            } elseif ($request->status === 'unlocked') {
                $query->where('is_locked', false);
            }
        }

        $records = $query->orderBy('id', 'asc')->get();

        $filename = 'USV_Registered_Players_' . date('Y_m_d_His') . '.xls';

        // Build Excel HTML/XML table that Microsoft Excel opens cleanly with full styling and columns
        $html = '<html xmlns:o="urn:schemas-microsoft-com:office:office" xmlns:x="urn:schemas-microsoft-com:office:excel" xmlns="http://www.w3.org/TR/REC-html40">';
        $html .= '<head><meta http-equiv="Content-Type" content="text/html; charset=utf-8">';
        $html .= '<!--[if gte mso 9]><xml><x:ExcelWorkbook><x:ExcelWorksheets><x:ExcelWorksheet><x:Name>Registered Players</x:Name><x:WorksheetOptions><x:DisplayGridlines/></x:WorksheetOptions></x:ExcelWorksheet></x:ExcelWorksheets></x:ExcelWorkbook></xml><![endif]-->';
        $html .= '<style>';
        $html .= 'table { border-collapse: collapse; width: 100%; font-family: Calibri, Arial, sans-serif; font-size: 11pt; }';
        $html .= 'th { background-color: #0b4d26; color: #ffffff; font-weight: bold; border: 1px solid #063c1e; padding: 10px; text-align: left; }';
        $html .= 'td { border: 1px solid #dcdcdc; padding: 8px; vertical-align: middle; }';
        $html .= '.title-header { background-color: #e60000; color: #ffffff; font-size: 16pt; font-weight: bold; text-align: center; height: 45px; }';
        $html .= '.sub-header { background-color: #f4f4f4; color: #333333; font-size: 10pt; text-align: center; }';
        $html .= '.status-locked { color: #b91c1c; font-weight: bold; }';
        $html .= '.status-unlocked { color: #15803d; font-weight: bold; }';
        $html .= '</style>';
        $html .= '</head><body>';
        $html .= '<table>';

        // Title row
        $html .= '<tr><td colspan="17" class="title-header">UNITED SENIORS VELLANAD (USV) - REGISTERED PLAYERS LIST</td></tr>';
        $html .= '<tr><td colspan="17" class="sub-header">Exported on: ' . date('d-M-Y H:i:s') . ' | Total Records: ' . $records->count() . '</td></tr>';
        $html .= '<tr><td colspan="17" style="height:10px;"></td></tr>';

        // Table headers
        $html .= '<tr>';
        $html .= '<th>SL</th>';
        $html .= '<th>Player Name</th>';
        $html .= '<th>Mobile No</th>';
        $html .= '<th>Age</th>';
        $html .= '<th>Date of Birth</th>';
        $html .= '<th>Blood Group</th>';
        $html .= '<th>Address</th>';
        $html .= '<th>Education Qualification</th>';
        $html .= '<th>Job / Profession</th>';
        $html .= '<th>Playing Role</th>';
        $html .= '<th>Batting Style</th>';
        $html .= '<th>Bowling Arm</th>';
        $html .= '<th>Bowling Pace</th>';
        $html .= '<th>Batting Position</th>';
        $html .= '<th>Jersey No</th>';
        $html .= '<th>Lock Status</th>';
        $html .= '<th>Remarks / Notes</th>';
        $html .= '</tr>';

        // Data rows
        $sl = 1;
        foreach ($records as $item) {
            $dobFormatted = $item->dob ? $item->dob->format('d/m/Y') : '-';
            $lockText = $item->is_locked ? 'LOCKED' : 'UNLOCKED';
            $lockClass = $item->is_locked ? 'status-locked' : 'status-unlocked';

            $html .= '<tr>';
            $html .= '<td>' . $sl++ . '</td>';
            $html .= '<td><b>' . htmlspecialchars($item->name) . '</b></td>';
            $html .= '<td style="mso-number-format:\'@\';">' . htmlspecialchars($item->mobile_no) . '</td>';
            $html .= '<td>' . ($item->age ?? '-') . '</td>';
            $html .= '<td>' . $dobFormatted . '</td>';
            $html .= '<td>' . htmlspecialchars($item->blood_group ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($item->address ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($item->education_qualification ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($item->job ?? '-') . '</td>';
            $html .= '<td><b>' . htmlspecialchars($item->playing_role) . '</b></td>';
            $html .= '<td>' . htmlspecialchars($item->batting_style ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($item->bowling_arm ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($item->bowling_pace ?? '-') . '</td>';
            $html .= '<td>' . htmlspecialchars($item->batting_position ?? '-') . '</td>';
            $html .= '<td style="mso-number-format:\'@\';">' . htmlspecialchars($item->jersey_number ?? '-') . '</td>';
            $html .= '<td class="' . $lockClass . '">' . $lockText . '</td>';
            $html .= '<td>' . htmlspecialchars($item->remarks ?? '-') . '</td>';
            $html .= '</tr>';
        }

        $html .= '</table></body></html>';

        return response($html, 200, [
            'Content-Type' => 'application/vnd.ms-excel; charset=utf-8',
            'Content-Disposition' => "attachment; filename=\"{$filename}\"",
            'Pragma' => 'no-cache',
            'Expires' => '0',
        ]);
    }
}
