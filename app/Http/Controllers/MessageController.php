<?php

namespace App\Http\Controllers;

use App\Models\Message;

class MessageController extends Controller
{
    public function index()
    {
        $messages = Message::latest()->paginate(15);

        return view('admin.messages.index', compact('messages'));
    }

    public function show(Message $message)
    {
        return view('admin.messages.show', compact('message'));
    }

    public function destroy(Message $message)
    {
        $message->delete();

        return redirect()->route('admin.messages.index')
            ->with('success', 'Message deleted successfully.');
    }
}
