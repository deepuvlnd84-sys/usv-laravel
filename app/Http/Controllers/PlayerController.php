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

        // Alias for compatibility
        $players = $members;
        $totalPlayers = $totalMembers;

        return view('players.index', compact(
            'members',
            'players',
            'isAdmin',
            'isAuthenticated',
            'totalMembers',
            'totalPlayers'
        ));
    }

    // Live search endpoint to display matching members from usv_members
    public function search(Request $request)
    {
        $query = trim($request->input('query', ''));

        $members = UsvMember::when($query !== '', function ($q) use ($query) {
            $q->where('name', 'like', '%' . $query . '%')
              ->orWhere('member_id', 'like', '%' . $query . '%')
              ->orWhere('call_name', 'like', '%' . $query . '%');
        })
        ->orderBy('sl_no', 'asc')
        ->get(['sl_no', 'member_id', 'name', 'call_name']);

        return response()->json($members);
    }

    // Legacy create route - redirects to index page
    public function create()
    {
        return redirect()->route('players.index');
    }

    // Save a new player with optional photo (Admin only)
    public function store(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('players.index')->withErrors(['admin' => 'Only Admin has permission to add players.']);
        }

        $request->validate([
            'name' => 'required|string|max:255',
            'jersey_number' => 'required|integer|min:0|max:999',
            'position' => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required' => 'Player name is required.',
            'jersey_number.required' => 'Jersey number is required.',
            'jersey_number.integer' => 'Jersey number must be a valid number.',
            'position.required' => 'Position or role is required.',
            'photo.image' => 'The file must be an image (JPEG, PNG, JPG, or WEBP).',
            'photo.max' => 'The image size may not exceed 2MB.',
        ]);

        $photoName = null;

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $uploadDir = public_path('uploads/players');

            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true, true);
            }

            $photoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $photoName);
        }

        Player::create([
            'name' => $request->name,
            'jersey_number' => $request->jersey_number,
            'position' => $request->position,
            'photo' => $photoName,
        ]);

        return redirect()->route('players.index')->with('success', "Player '{$request->name}' added successfully!");
    }

    // Update existing player details & photo (Admin only)
    public function update(Request $request, $id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('players.index')->withErrors(['admin' => 'Only Admin has permission to manage players.']);
        }

        $player = Player::findOrFail($id);

        $request->validate([
            'name' => 'required|string|max:255',
            'jersey_number' => 'required|integer|min:0|max:999',
            'position' => 'required|string|max:100',
            'photo' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ], [
            'name.required' => 'Player name is required.',
            'jersey_number.required' => 'Jersey number is required.',
            'jersey_number.integer' => 'Jersey number must be a valid number.',
            'position.required' => 'Position or role is required.',
            'photo.image' => 'The file must be an image (JPEG, PNG, JPG, or WEBP).',
            'photo.max' => 'The image size may not exceed 2MB.',
        ]);

        if ($request->hasFile('photo')) {
            $file = $request->file('photo');
            $uploadDir = public_path('uploads/players');

            if (!File::isDirectory($uploadDir)) {
                File::makeDirectory($uploadDir, 0755, true, true);
            }

            // Remove old photo if exists
            if ($player->photo && File::exists($uploadDir . '/' . $player->photo)) {
                File::delete($uploadDir . '/' . $player->photo);
            }

            $photoName = time() . '_' . uniqid() . '.' . $file->getClientOriginalExtension();
            $file->move($uploadDir, $photoName);
            $player->photo = $photoName;
        }

        $player->name = $request->name;
        $player->jersey_number = $request->jersey_number;
        $player->position = $request->position;
        $player->save();

        return redirect()->route('players.index')->with('success', "Player '{$player->name}' updated successfully!");
    }

    // Delete a player (Admin only)
    public function destroy($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('players.index')->withErrors(['admin' => 'Only Admin has permission to delete players.']);
        }

        $player = Player::findOrFail($id);
        $name = $player->name;

        // Remove photo from disk if present
        if ($player->photo) {
            $photoPath = public_path('uploads/players/' . $player->photo);
            if (File::exists($photoPath)) {
                File::delete($photoPath);
            }
        }

        $player->delete();

        return redirect()->route('players.index')->with('success', "Player '{$name}' deleted successfully!");
    }
}
