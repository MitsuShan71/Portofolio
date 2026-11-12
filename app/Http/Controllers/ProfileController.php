<?php

namespace App\Http\Controllers;

use App\Models\PortfolioProfile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProfileController extends Controller
{
    public function edit()
    {
        $profile = PortfolioProfile::find(1) ?? new PortfolioProfile(['id' => 1]);

        return view('admin.profile.edit', compact('profile'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'full_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'class_name' => ['sometimes', 'nullable', 'string', 'max:255'],
            'competency' => ['sometimes', 'nullable', 'string', 'max:255'],
            'summary' => ['sometimes', 'nullable', 'string'],
            'bio' => ['sometimes', 'nullable', 'string'],
            'education' => ['sometimes', 'nullable', 'string'],
            'career_goal' => ['sometimes', 'nullable', 'string'],
            'email' => ['sometimes', 'nullable', 'email', 'max:255'],
            'github_url' => ['sometimes', 'nullable', 'url', 'max:255'],
            'instagram_url' => ['sometimes', 'nullable', 'url', 'max:255'],
            'profile_image' => ['sometimes', 'nullable', 'image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'resume_file' => ['sometimes', 'nullable', 'file', 'mimes:pdf', 'max:10240'],
        ]);

        $profile = PortfolioProfile::find(1) ?? new PortfolioProfile(['id' => 1]);
        $oldImage = $profile->profile_image;
        $oldResume = $profile->resume_file;

        if ($request->hasFile('profile_image')) {
            $newImage = $request->file('profile_image')->store('profiles', 'public');
            $validated['profile_image'] = $newImage;
        } else {
            unset($validated['profile_image']);
        }

        if ($request->hasFile('resume_file')) {
            $newResume = $request->file('resume_file')->store('resumes', 'public');
            $validated['resume_file'] = $newResume;
        } else {
            unset($validated['resume_file']);
        }

        $profile->fill($validated);
        $profile->id = 1;
        $profile->save();

        if (isset($newImage) && $oldImage) {
            Storage::disk('public')->delete($oldImage);
        }

        if (isset($newResume) && $oldResume) {
            Storage::disk('public')->delete($oldResume);
        }

        return redirect()->route('admin.profile.edit')->with('success', 'Profile updated successfully.');
    }
}
