@extends('layouts.admin')

@section('title', 'Edit Project')

@section('styles')
    .container { max-width: 480px; margin: 0 auto; padding: 2rem; }
    h1 { color: var(--color-title); margin-bottom: 1.5rem; }
    .form-group { margin-bottom: 1.5rem; }
    label { display: block; margin-bottom: 0.5rem; color: var(--color-title); font-weight: 500; }
    input, textarea {
        width: 100%;
        padding: 0.75rem 1rem;
        border-radius: 0.5rem;
        background: #3a3d4a;
        color: var(--color-title);
        border: none;
        outline: none;
        font-family: inherit;
        font-size: 0.938rem;
    }
    textarea { resize: vertical; min-height: 100px; }
    input[type="file"] { background: transparent; padding-left: 0; }
    input[type="file"]::file-selector-button {
        padding: 0.5rem 1rem;
        border-radius: 0.5rem;
        background: var(--color-first);
        color: var(--color-title);
        border: none;
        cursor: pointer;
        font-weight: 600;
    }
    .btn {
        display: inline-flex;
        align-items: center;
        gap: 0.5rem;
        padding: 0.75rem 1.5rem;
        border-radius: 0.5rem;
        text-decoration: none;
        font-weight: 600;
        border: none;
        cursor: pointer;
        font-size: 0.938rem;
    }
    .btn-primary { background: var(--color-first); color: var(--color-title); }
    .btn-secondary { background: #3a3d4a; color: var(--color-title); }
    .flex { display: flex; gap: 1rem; }
    .error { color: #dc3545; font-size: 0.813rem; margin-top: 0.25rem; }
    .preview { max-width: 200px; border-radius: 0.5rem; margin-top: 0.5rem; }
@endsection

@section('content')
    <div class="container">
        <h1>Edit Project</h1>

        <form action="{{ route('admin.projects.update', $project) }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('PUT')
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title', $project->title) }}" required>
                @error('title') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description">{{ old('description', $project->description) }}</textarea>
            </div>

            <div class="form-group">
                <label for="link">Link</label>
                <input type="url" name="link" id="link" value="{{ old('link', $project->link) }}" placeholder="https://...">
                @error('link') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="form-group">
                <label for="image">Image</label>
                <input type="file" name="image" id="image" accept="image/*">
                @if ($project->image)
                    <img src="{{ Storage::url($project->image) }}" alt="" class="preview">
                @endif
                @error('image') <div class="error">{{ $message }}</div> @enderror
            </div>

            <div class="flex">
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Update</button>
                <a href="{{ route('admin.projects.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
