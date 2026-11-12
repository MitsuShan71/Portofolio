<?php

namespace App\Http\Controllers;

use App\Models\Experience;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Validation\Rule;

class ExperienceController extends Controller
{
    private const CATEGORIES = ['plk', 'organization', 'competition'];

    public function index()
    {
        $experiences = Experience::orderByDesc('start_date')->orderByDesc('id')->get();

        return view('admin.experiences.index', compact('experiences'));
    }

    public function create()
    {
        return view('admin.experiences.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->rules());

        if ($request->hasFile('documentation')) {
            $validated['documentation'] = $request->file('documentation')->store('experiences', 'public');
        }

        Experience::create($validated);

        return redirect()->route('admin.experiences.index')->with('success', 'Experience created successfully.');
    }

    public function edit(Experience $experience)
    {
        return view('admin.experiences.edit', compact('experience'));
    }

    public function update(Request $request, Experience $experience)
    {
        $validated = $request->validate($this->rules());
        $previousDocumentation = $experience->documentation;

        if ($request->hasFile('documentation')) {
            $validated['documentation'] = $request->file('documentation')->store('experiences', 'public');
        }

        $experience->update($validated);

        if ($request->hasFile('documentation') && $previousDocumentation) {
            Storage::disk('public')->delete($previousDocumentation);
        }

        return redirect()->route('admin.experiences.index')->with('success', 'Experience updated successfully.');
    }

    public function destroy(Experience $experience)
    {
        if ($experience->documentation) {
            Storage::disk('public')->delete($experience->documentation);
        }

        $experience->delete();

        return redirect()->route('admin.experiences.index')->with('success', 'Experience deleted successfully.');
    }

    private function rules(): array
    {
        return [
            'category' => ['required', Rule::in(self::CATEGORIES)],
            'title' => ['required', 'string', 'max:255'],
            'organization' => ['required', 'string', 'max:255'],
            'role' => ['nullable', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'start_date' => ['required', 'date'],
            'end_date' => ['nullable', 'date', 'after_or_equal:start_date'],
            'documentation' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,pdf', 'max:10240'],
        ];
    }
}
