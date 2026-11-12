<?php

namespace App\Http\Controllers;

use App\Models\Certificate;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class CertificateController extends Controller
{
    public function index()
    {
        $certificates = Certificate::orderByDesc('date')->orderBy('title')->get();

        return view('admin.certificates.index', compact('certificates'));
    }

    public function create()
    {
        return view('admin.certificates.create');
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'date' => ['nullable', 'date'],
            'documentation' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,pdf', 'max:10240'],
        ]);

        if ($request->hasFile('documentation')) {
            $validated['documentation'] = $request->file('documentation')->store('certificates', 'public');
        }

        Certificate::create($validated);

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate created successfully.');
    }

    public function show(Certificate $certificate)
    {
        return view('admin.certificates.show', compact('certificate'));
    }

    public function edit(Certificate $certificate)
    {
        return view('admin.certificates.edit', compact('certificate'));
    }

    public function update(Request $request, Certificate $certificate)
    {
        $validated = $request->validate([
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'date' => ['nullable', 'date'],
            'documentation' => ['nullable', 'file', 'mimes:jpg,jpeg,png,gif,webp,pdf', 'max:10240'],
        ]);

        if ($request->hasFile('documentation')) {
            $newPath = $request->file('documentation')->store('certificates', 'public');
            if ($certificate->documentation) {
                Storage::disk('public')->delete($certificate->documentation);
            }
            $validated['documentation'] = $newPath;
        }

        $certificate->update($validated);

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate updated successfully.');
    }

    public function destroy(Certificate $certificate)
    {
        if ($certificate->documentation) {
            Storage::disk('public')->delete($certificate->documentation);
        }

        $certificate->delete();

        return redirect()->route('admin.certificates.index')->with('success', 'Certificate deleted successfully.');
    }
}
