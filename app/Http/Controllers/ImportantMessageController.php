<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ImportantMessage;
use Illuminate\Support\Facades\Session;

class ImportantMessageController extends Controller
{
    private function checkAdmin()
    {
        return Session::get('is_admin') === true;
    }

    // Store a new important message
    public function store(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->back()->withErrors(['auth' => 'Only Admin has permission to add important messages.']);
        }

        $request->validate([
            'title' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
            'badge' => 'nullable|string|max:50',
        ]);

        ImportantMessage::create([
            'title' => $request->title,
            'message' => $request->message,
            'badge' => strtoupper($request->badge ?? 'ANNOUNCEMENT'),
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Important message added successfully!');
    }

    // Update an existing message
    public function update(Request $request, $id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->back()->withErrors(['auth' => 'Only Admin has permission to edit important messages.']);
        }

        $messageItem = ImportantMessage::findOrFail($id);

        $request->validate([
            'title' => 'nullable|string|max:255',
            'message' => 'required|string|max:2000',
            'badge' => 'nullable|string|max:50',
        ]);

        $messageItem->update([
            'title' => $request->title,
            'message' => $request->message,
            'badge' => strtoupper($request->badge ?? 'ANNOUNCEMENT'),
        ]);

        return redirect()->back()->with('success', 'Important message updated successfully!');
    }

    // Delete a message
    public function destroy($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->back()->withErrors(['auth' => 'Only Admin has permission to delete important messages.']);
        }

        $messageItem = ImportantMessage::findOrFail($id);
        $messageItem->delete();

        return redirect()->back()->with('success', 'Important message deleted successfully!');
    }
}
