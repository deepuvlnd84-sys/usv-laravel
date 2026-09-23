<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Player;
use App\Models\UsvPlayers;
use App\Models\UsvMember;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\File;

class PlayerController extends Controller
{
    private function checkAdmin()
    {
        return Session::get('is_admin') === true;
    }

    // Display the members list from usv_members table
    public function index()
    {
        $members = UsvMember::orderBy('sl_no', 'asc')->get();
        $isAdmin = $this->checkAdmin();
        $isAuthenticated = Session::has('authenticated_user');
        $totalMembers = $members->count();

        // Prepare JSON-friendly member list for live dropdown search
        $searchMembers = $members->map(function ($m) {
            return [
                'sl_no' => $m->sl_no,
                'member_id' => $m->member_id,
                'name' => $m->name,
                'call_name' => $m->call_name ?? '',
                'profile_url' => route('members.profile', $m->sl_no),
            ];
        });

        // Alias for compatibility
        $players = $members;
        $totalPlayers = $totalMembers;

        return view('players.index', compact(
            'members',
            'players',
            'searchMembers',
            'isAdmin',
            'isAuthenticated',
            'totalMembers',
            'totalPlayers'
        ));
    }

    // View Member Profile Page
    public function profile($sl_no)
    {
        $member = UsvMember::where('sl_no', $sl_no)->firstOrFail();
        $isAdmin = $this->checkAdmin();
        $isAuthenticated = Session::has('authenticated_user');
        $totalMembers = UsvMember::count();

        return view('players.profile', compact(
            'member',
            'isAdmin',
            'isAuthenticated',
            'totalMembers'
        ));
    }

    // Live search endpoint to display matching members from usv_members with profile links
    public function search(Request $request)
    {
        $query = trim($request->input('query', ''));

        $members = UsvMember::when($query !== '', function ($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%')
              ->orWhere('member_id', 'like', '%' . $query . '%')
              ->orWhere('call_name', 'like', '%' . $query . '%')
              ->orWhere('sl_no', 'like', '%' . $query . '%');
        })
        ->orderBy('sl_no', 'asc')
        ->limit(15)
        ->get(['sl_no', 'member_id', 'name', 'call_name'])
        ->map(function ($m) {
            return [
                'sl_no' => $m->sl_no,
                'member_id' => $m->member_id,
                'name' => $m->name,
                'call_name' => $m->call_name ?? '',
                'profile_url' => route('members.profile', $m->sl_no),
            ];
        });

        return response()->json($members);
    }

    // Legacy create route - redirects to index page
    public function create()
    {
        return redirect()->route('members');
    }

    // Save a new member to usv_members table (Admin only)
    public function store(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('members')->withErrors(['admin' => 'Only Admin has permission to add members.']);
        }

        $request->validate([
            'member_id' => 'required|integer',
            'name' => 'required|string|max:150',
            'call_name' => 'nullable|string|max:100',
            'sl_no' => 'nullable|integer',
        ], [
            'member_id.required' => 'Member ID is required.',
            'member_id.integer' => 'Member ID must be a valid number.',
            'name.required' => 'Member name is required.',
            'name.max' => 'Member name may not exceed 150 characters.',
        ]);

        // Determine SL NO
        if ($request->filled('sl_no')) {
            $slNo = (int) $request->sl_no;
            if (UsvMember::where('sl_no', $slNo)->exists()) {
                return redirect()->back()->withInput()->withErrors(['sl_no' => "Serial Number #{$slNo} already exists in usv_members."]);
            }
        } else {
            $maxSl = UsvMember::max('sl_no');
            $slNo = ($maxSl !== null) ? ((int) $maxSl + 1) : 1;
        }

        // Check if Member ID is duplicate
        if (UsvMember::where('member_id', $request->member_id)->exists()) {
            return redirect()->back()->withInput()->withErrors(['member_id' => "Member ID {$request->member_id} is already registered."]);
        }

        UsvMember::create([
            'sl_no' => $slNo,
            'member_id' => (int) $request->member_id,
            'name' => trim($request->name),
            'call_name' => $request->filled('call_name') ? trim($request->call_name) : null,
        ]);

        return redirect()->route('members')->with('success', "Member '{$request->name}' (ID: {$request->member_id}) added to usv_members successfully!");
    }

    // Update existing member in usv_members table (Admin only)
    public function update(Request $request, $id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('members')->withErrors(['admin' => 'Only Admin has permission to edit members.']);
        }

        $member = UsvMember::where('sl_no', $id)->firstOrFail();

        $request->validate([
            'member_id' => 'required|integer',
            'name' => 'required|string|max:150',
            'call_name' => 'nullable|string|max:100',
        ], [
            'member_id.required' => 'Member ID is required.',
            'member_id.integer' => 'Member ID must be a valid number.',
            'name.required' => 'Member name is required.',
        ]);

        // Check duplicate member_id on other members
        $exists = UsvMember::where('member_id', $request->member_id)
            ->where('sl_no', '!=', $member->sl_no)
            ->exists();

        if ($exists) {
            return redirect()->back()->withInput()->withErrors(['member_id' => "Member ID {$request->member_id} is already used by another member."]);
        }

        $member->update([
            'member_id' => (int) $request->member_id,
            'name' => trim($request->name),
            'call_name' => $request->filled('call_name') ? trim($request->call_name) : null,
        ]);

        return redirect()->back()->with('success', "Member '{$member->name}' updated in usv_members successfully!");
    }

    // Delete a member from usv_members (Admin only)
    public function destroy($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('members')->withErrors(['admin' => 'Only Admin has permission to delete members.']);
        }

        $member = UsvMember::where('sl_no', $id)->firstOrFail();
        $name = $member->name;
        $member->delete();

        return redirect()->route('members')->with('success', "Member '{$name}' deleted from usv_members successfully!");
    }
}
