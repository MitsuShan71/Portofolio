@extends('layouts.admin')

@section('title', $project->title . ' - Project Details')

@section('styles')
    .container { max-width: 640px; margin: 0 auto; padding: 2rem; }
    .back { display: inline-flex; align-items: center; gap: 0.5rem; color: var(--color-text); text-decoration: none; margin-bottom: 1.5rem; transition: color 0.2s; }
    .back:hover { color: var(--color-title); }
    .card { background: var(--color-container); border-radius: 1rem; overflow: hidden; }
    .card img { width: 100%; height: 280px; object-fit: cover; display: block; }
    .card-body { padding: 2rem; }
    .card-body h1 { color: var(--color-title); font-size: 1.5rem; margin-bottom: 1rem; }
    .field { line-height: 1.7; margin-bottom: 1.5rem; white-space: pre-wrap; overflow-wrap: anywhere; }
    .field-label { display: block; color: var(--color-title); font-weight: 600; margin-bottom: 0.25rem; }
    .link { display: inline-flex; align-items: center; gap: 0.5rem; background: var(--color-first); color: var(--color-title); padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600; margin: 0 0.5rem 0.5rem 0; }
    .link:hover { opacity: 0.9; }
    .no-image { height: 200px; display: flex; align-items: center; justify-content: center; background: #1a1c26; color: #666; }
@endsection

@section('content')
    <div class="container">
        <a href="{{ route('admin.projects.index') }}" class="back"><i class="ri-arrow-left-line"></i> Back to Projects</a>
        <div class="card">
            @if ($project->image)
                <img src="{{ Storage::url($project->image) }}" alt="{{ $project->title }}">
            @else
                <div class="no-image"><i class="ri-image-line" style="font-size: 3rem;"></i></div>
            @endif
            <div class="card-body">
                <h1>{{ $project->title }}</h1>
                @foreach ([
                    'description' => 'Short Description', 'problem_solved' => 'Problem Solved',
                    'objective' => 'Project Objective', 'technologies' => 'Technologies Used',
                    'role' => 'Role', 'features' => 'Project Features', 'demo_link' => 'Demo Link',
                    'github_link' => 'GitHub Source Link', 'process_documentation' => 'Process Documentation',
                    'user_feedback' => 'User Feedback', 'details' => 'Details', 'link' => 'Link (legacy)',
                ] as $field => $label)
                    @if ($project->{$field})
                        <div class="field"><span class="field-label">{{ $label }}</span>{{ $project->{$field} }}</div>
                    @endif
                @endforeach
                @if ($project->demo_link)
                    <a href="{{ $project->demo_link }}" target="_blank" rel="noopener noreferrer" class="link"><i class="ri-external-link-line"></i> Open Demo</a>
                @endif
                @if ($project->github_link)
                    <a href="{{ $project->github_link }}" target="_blank" rel="noopener noreferrer" class="link"><i class="ri-github-line"></i> View Source</a>
                @endif
                @if ($project->link)
                    <a href="{{ $project->link }}" target="_blank" rel="noopener noreferrer" class="link"><i class="ri-external-link-line"></i> Visit Project</a>
                @endif
            </div>
        </div>
    </div>
@endsection
