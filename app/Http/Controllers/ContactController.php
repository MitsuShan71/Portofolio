<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class ContactController extends Controller
{
    public function send(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            Mail::raw("Name: {$request->name}\nEmail: {$request->email}\n\nMessage:\n{$request->message}", function ($mail) use ($request) {
                $mail->to(config('mail.from.address'))
                    ->subject("Portfolio Contact: {$request->subject}");
            });

            return response()->json(['message' => 'Message sent successfully!']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Failed to send message. Please try again.'], 500);
        }
    }
}
