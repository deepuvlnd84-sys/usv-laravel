<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use App\Models\ScrollingMessage;
use Illuminate\Support\Facades\Session;

class ScrollingMessageController extends Controller
{
    private function checkAdmin()
    {
        return Session::get('is_admin') === true;
    }

    // Show the management page
    public function edit()
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Only Admin has permission to manage scrolling notifications.']);
        }

        $messages = ScrollingMessage::latest()->get();
        return view('scrolling_messages.edit', compact('messages'));
    }

    // Save a new message
    public function store(Request $request)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Only Admin has permission to manage scrolling notifications.']);
        }

        $request->validate([
            'message' => 'required|string|max:1000',
        ]);

        ScrollingMessage::create([
            'message' => $request->message,
            'is_active' => true,
        ]);

        return redirect()->back()->with('success', 'Scrolling message added successfully!');
    }

    // Toggle active/inactive status
    public function toggle($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Only Admin has permission to manage scrolling notifications.']);
        }

        $message = ScrollingMessage::findOrFail($id);
        $message->is_active = !$message->is_active;
        $message->save();

        $status = $message->is_active ? 'activated' : 'deactivated';
        return redirect()->back()->with('success', "Message {$status} successfully!");
    }

    // Delete a message
    public function destroy($id)
    {
        if (!$this->checkAdmin()) {
            return redirect()->route('login.admin')->withErrors(['auth' => 'Only Admin has permission to manage scrolling notifications.']);
        }

        $message = ScrollingMessage::findOrFail($id);
        $message->delete();

        return redirect()->back()->with('success', 'Scrolling message deleted successfully!');
    }
}
