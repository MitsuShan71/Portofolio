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

        if (config('mail.default') === 'log' || (config('mail.default') === 'array' && ! app()->environment('testing'))) {
            Log::warning('Contact form: email transport is not configured for delivery.');

            return response()->json([
                'message' => 'Pesan tersimpan, tetapi email belum terkirim. Konfigurasi Gmail SMTP belum lengkap.',
            ], 503);
        }

        $fromEmail = config('mail.from.address');
        if (! $fromEmail || $fromEmail === 'hello@example.com') {
            Log::warning('Contact form: MAIL_FROM_ADDRESS is not configured properly.');

            return response()->json([
                'message' => 'Pesan tersimpan, tetapi email belum terkirim. Konfigurasi pengirim belum valid.',
            ], 503);
        }

        try {
            $fromName = config('mail.from.name', 'Portfolio');
            Mail::raw("Name: {$validated['name']}\nEmail: {$validated['email']}\n\nMessage:\n{$validated['message']}", function ($mail) use ($validated, $fromEmail, $fromName) {
                $mail->from($fromEmail, $fromName)
                    ->to(config('admin.mail_to'))
                    ->subject("Portfolio Contact: {$validated['name']}");
            });
        } catch (\Throwable $e) {
            Log::error('Contact form mail failed: '.$e->getMessage());

            return response()->json([
                'message' => 'Pesan tersimpan, tetapi email gagal dikirim. Periksa konfigurasi Gmail SMTP.',
            ], 503);
        }

        return response()->json(['message' => 'Message sent successfully!']);
    }
}
