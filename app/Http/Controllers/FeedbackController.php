<?php

namespace App\Http\Controllers;

use App\Models\Feedback;
use Illuminate\Http\Request;

class FeedbackController extends Controller
{
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'message' => 'required|string|max:10000',
        ]);

        Feedback::create($validated);

        return back()->with('feedback_success', 'Terima kasih atas feedback Anda.');
    }

    public function index()
    {
        $feedback = Feedback::latest()->paginate(15);

        return view('admin.feedback.index', compact('feedback'));
    }

    public function show(Feedback $feedback)
    {
        return view('admin.feedback.show', compact('feedback'));
    }

    public function destroy(Feedback $feedback)
    {
        $feedback->delete();

        return redirect()->route('admin.feedback.index')
            ->with('success', 'Feedback deleted successfully.');
    }
}
