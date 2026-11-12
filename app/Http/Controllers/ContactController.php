<?php

namespace App\Http\Controllers;

use App\Models\Message;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'message' => 'required|string',
        ]);

        Message::create($validated);

        try {
            $fromEmail = config('mail.from.address');
            $fromName = config('mail.from.name', 'Portfolio');

            if (! $fromEmail || $fromEmail === 'hello@example.com') {
                Log::warning('Contact form: MAIL_FROM_ADDRESS is not configured properly.');
            } else {
                Mail::raw("Name: {$validated['name']}\nEmail: {$validated['email']}\n\nMessage:\n{$validated['message']}", function ($mail) use ($validated, $fromEmail, $fromName) {
                    $mail->from($fromEmail, $fromName)
                        ->to(config('admin.mail_to'))
                        ->subject("Portfolio Contact: {$validated['name']}");
                });
            }
        } catch (\Throwable $e) {
            Log::error('Contact form mail failed: '.$e->getMessage());
        }

        return response()->json(['message' => 'Message sent successfully!']);
    }
}
