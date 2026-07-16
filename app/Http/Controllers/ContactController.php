<?php

namespace App\Http\Controllers;

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

        try {
            $fromEmail = config('mail.from.address');
            $fromName = config('mail.from.name', 'Portfolio');

            if (!$fromEmail || $fromEmail === 'hello@example.com') {
                Log::warning('Contact form: MAIL_FROM_ADDRESS is not configured properly.');
                return response()->json([
                    'message' => 'Contact form is not configured. Please contact the administrator.',
                ], 500);
            }

            Mail::raw("Name: {$validated['name']}\nEmail: {$validated['email']}\n\nMessage:\n{$validated['message']}", function ($mail) use ($validated, $fromEmail, $fromName) {
                $mail->from($fromEmail, $fromName)
                    ->to(config('admin.mail_to'))
                    ->subject("Portfolio Contact: {$validated['name']}");
            });

            return response()->json(['message' => 'Message sent successfully!']);
        } catch (\Exception $e) {
            Log::error('Contact form mail failed: ' . $e->getMessage());
            return response()->json(['message' => 'Failed to send message. Please try again.'], 500);
        }
    }
}
