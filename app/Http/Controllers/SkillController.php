<?php

namespace App\Http\Controllers;

use App\Models\Skill;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class SkillController extends Controller
{
    public function index()
    {
        $skills = Skill::orderBy('sort_order')->orderBy('id')->get();

        return view('admin.skills.index', compact('skills'));
    }

    public function create()
    {
        return view('admin.skills.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:hard,soft',
            'percentage' => 'required|integer|between:0,100',
            'icon' => 'nullable|string|max:255',
            'icon_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        unset($validated['icon_image']);
        if ($request->hasFile('icon_image')) {
            $validated['icon'] = $request->file('icon_image')->store('skills', 'public');
        }
        $validated['sort_order'] ??= 0;

        Skill::create($validated);

        return redirect()->route('admin.skills.index')->with('success', 'Skill created successfully.');
    }

    public function edit(Skill $skill)
    {
        return view('admin.skills.edit', compact('skill'));
    }

    public function update(Request $request, Skill $skill)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'category' => 'required|in:hard,soft',
            'percentage' => 'required|integer|between:0,100',
            'icon' => 'nullable|string|max:255',
            'icon_image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
            'sort_order' => 'nullable|integer|min:0',
        ]);

        unset($validated['icon_image']);
        if ($request->hasFile('icon_image')) {
            if ($skill->icon && str_starts_with($skill->icon, 'skills/')) {
                Storage::disk('public')->delete($skill->icon);
            }
            $validated['icon'] = $request->file('icon_image')->store('skills', 'public');
        }
        $validated['sort_order'] ??= 0;
        $skill->update($validated);

        return redirect()->route('admin.skills.index')->with('success', 'Skill updated successfully.');
    }

    public function destroy(Skill $skill)
    {
        if ($skill->icon && str_starts_with($skill->icon, 'skills/')) {
            Storage::disk('public')->delete($skill->icon);
        }
        $skill->delete();

        return redirect()->route('admin.skills.index')->with('success', 'Skill deleted successfully.');
    }
}
