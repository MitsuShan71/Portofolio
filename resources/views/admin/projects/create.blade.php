@extends('layouts.admin')

@section('title', 'Create Project')

@section('styles')
    .container { max-width: 640px; margin: 0 auto; padding: 2rem; }
    h1 { color: var(--color-title); margin-bottom: 1.5rem; }
    .form-group { margin-bottom: 1.5rem; }
    label { display: block; margin-bottom: 0.5rem; color: var(--color-title); font-weight: 500; }
    input, textarea {
        width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; background: #3a3d4a;
        color: var(--color-title); border: none; outline: none; font-family: inherit; font-size: 0.938rem;
    }
    textarea { resize: vertical; min-height: 100px; }
    input[type="file"] { background: transparent; padding-left: 0; }
    input[type="file"]::file-selector-button { padding: 0.5rem 1rem; border-radius: 0.5rem; background: var(--color-first); color: var(--color-title); border: none; cursor: pointer; font-weight: 600; }
    .btn { display: inline-flex; align-items: center; gap: 0.5rem; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600; border: none; cursor: pointer; font-size: 0.938rem; }
    .btn-primary { background: var(--color-first); color: var(--color-title); }
    .btn-secondary { background: #3a3d4a; color: var(--color-title); }
    .flex { display: flex; gap: 1rem; }
    .error { color: #dc3545; font-size: 0.813rem; margin-top: 0.25rem; }
@endsection

@section('content')
    <div class="container">
        <h1>Create Project</h1>
        <form action="{{ route('admin.projects.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required>
                @error('title') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="description">Short Description</label>
                <textarea name="description" id="description">{{ old('description') }}</textarea>
                @error('description') <div class="error">{{ $message }}</div> @enderror
            </div>
            @foreach ([
                'problem_solved' => 'Problem Solved', 'objective' => 'Project Objective',
                'technologies' => 'Technologies Used', 'role' => 'Role', 'features' => 'Project Features',
                'process_documentation' => 'Process Documentation', 'user_feedback' => 'User Feedback', 'details' => 'Details',
            ] as $field => $label)
                <div class="form-group">
                    <label for="{{ $field }}">{{ $label }}</label>
                    <textarea name="{{ $field }}" id="{{ $field }}">{{ old($field) }}</textarea>
                    @error($field) <div class="error">{{ $message }}</div> @enderror
                </div>
            @endforeach
            <div class="form-group">
                <label for="demo_link">Demo Link</label>
                <input type="url" name="demo_link" id="demo_link" value="{{ old('demo_link') }}" placeholder="https://...">
                @error('demo_link') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="github_link">GitHub Source Link</label>
                <input type="url" name="github_link" id="github_link" value="{{ old('github_link') }}" placeholder="https://...">
                @error('github_link') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="link">Link (legacy)</label>
                <input type="url" name="link" id="link" value="{{ old('link') }}" placeholder="https://...">
                @error('link') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" accept="image/*">
                @error('image') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="flex">
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Save</button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
