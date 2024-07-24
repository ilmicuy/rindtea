<?php

namespace App\Http\Controllers;

use App\Models\Inbox;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class InboxController extends Controller
{
    public function index()
    {
        $inbox = Inbox::where('receiver_id', Auth::id())->orderBy('created_at', 'desc')->paginate(10);
        return view('pages.admin.inbox.index', compact('inbox'));
    }

    public function show($id)
    {
        $message = Inbox::findOrFail($id);

        if ($message->receiver_id != Auth::id()) {
            abort(403);
        }

        $message->update(['is_read' => true]);

        return view('pages.admin.inbox.show', compact('message'));
    }

    public function create()
    {
        $users = User::all();
        return view('pages.admin.inbox.create', [
            'users' => $users
        ]);
    }

    public function store(Request $request)
    {
        $request->validate([
            'receiver_id' => 'required|exists:users,id',
            'message' => 'required|string|max:5000',
        ]);

        Inbox::create([
            'sender_id' => Auth::id(),
            'receiver_id' => $request->receiver_id,
            'message' => $request->message,
            'is_read' => false,
        ]);

        return redirect()->route('inbox.index')->with('success', 'Message sent successfully!');
    }
}
