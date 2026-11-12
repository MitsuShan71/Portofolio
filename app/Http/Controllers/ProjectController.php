<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class ProjectController extends Controller
{
    public function index()
    {
        $projects = Project::all();
        return view('admin.projects.index', compact('projects'));
    }

    public function create()
    {
        return view('admin.projects.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url|max:255',
            'problem_solved' => 'nullable|string',
            'objective' => 'nullable|string',
            'technologies' => 'nullable|string',
            'role' => 'nullable|string',
            'features' => 'nullable|string',
            'demo_link' => 'nullable|url|max:255',
            'github_link' => 'nullable|url|max:255',
            'process_documentation' => 'nullable|string',
            'user_feedback' => 'nullable|string',
            'details' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('projects', 'public');
        }

        Project::create($validated);

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project created successfully.');
    }

    public function show(Project $project)
    {
        return view('admin.projects.show', compact('project'));
    }

    public function edit(Project $project)
    {
        return view('admin.projects.edit', compact('project'));
    }

    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'link' => 'nullable|url|max:255',
            'problem_solved' => 'nullable|string',
            'objective' => 'nullable|string',
            'technologies' => 'nullable|string',
            'role' => 'nullable|string',
            'features' => 'nullable|string',
            'demo_link' => 'nullable|url|max:255',
            'github_link' => 'nullable|url|max:255',
            'process_documentation' => 'nullable|string',
            'user_feedback' => 'nullable|string',
            'details' => 'nullable|string',
            'image' => 'nullable|image|mimes:jpg,jpeg,png,webp|max:2048',
        ]);

        if ($request->hasFile('image')) {
            $newImage = $request->file('image')->store('projects', 'public');
            if ($newImage !== false) {
                $oldImage = $project->image;
                $validated['image'] = $newImage;
                $project->update($validated);
                if ($oldImage) {
                    Storage::disk('public')->delete($oldImage);
                }
            } else {
                $project->update($validated);
            }
        } else {
            $project->update($validated);
        }
        return redirect()->route('admin.projects.index')
            ->with('success', 'Project updated successfully.');
    }

    public function destroy(Project $project)
    {
        if ($project->image) {
            Storage::disk('public')->delete($project->image);
        }

        $project->delete();

        return redirect()->route('admin.projects.index')
            ->with('success', 'Project deleted successfully.');
    }
}
