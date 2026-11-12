@extends('layouts.admin')

@section('title', 'Create Experience')

@section('styles')
    .container { max-width: 560px; margin: 0 auto; padding: 2rem; }
    h1 { color: var(--color-title); margin-bottom: 1.5rem; }
    .form-group { margin-bottom: 1.25rem; }
    label { display: block; margin-bottom: .5rem; color: var(--color-title); font-weight: 500; }
    input, textarea, select { width: 100%; padding: .75rem 1rem; border-radius: .5rem; background: #3a3d4a; color: var(--color-title); border: none; font: inherit; }
    textarea { resize: vertical; min-height: 100px; }
    input[type=file] { background: transparent; padding-left: 0; }
    .btn { display: inline-flex; align-items: center; gap: .5rem; padding: .75rem 1.5rem; border-radius: .5rem; text-decoration: none; font-weight: 600; border: none; cursor: pointer; }
    .btn-primary { background: var(--color-first); color: var(--color-title); }
    .btn-secondary { background: #3a3d4a; color: var(--color-title); }
    .flex { display: flex; gap: 1rem; }
    .error { color: #ff6b6b; font-size: .813rem; margin-top: .25rem; }
    .dates { display: flex; gap: 1rem; }
    .dates .form-group { flex: 1; }
@endsection

@section('content')
    <div class="container">
        <h1>Create Experience</h1>
        <form action="{{ route('admin.experiences.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label for="category">Category</label>
                <select name="category" id="category" required>
                    <option value="">Choose a category</option>
                    @foreach (['plk' => 'PLK', 'organization' => 'Organization', 'competition' => 'Competition'] as $value => $label)
                        <option value="{{ $value }}" @selected(old('category') === $value)>{{ $label }}</option>
                    @endforeach
                </select>
                @error('category') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="title">Title</label>
                <input type="text" name="title" id="title" value="{{ old('title') }}" required>
                @error('title') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="organization">Organization</label>
                <input type="text" name="organization" id="organization" value="{{ old('organization') }}" required>
                @error('organization') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="role">Role</label>
                <input type="text" name="role" id="role" value="{{ old('role') }}">
                @error('role') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="form-group">
                <label for="description">Description</label>
                <textarea name="description" id="description">{{ old('description') }}</textarea>
                @error('description') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="dates">
                <div class="form-group">
                    <label for="start_date">Start date</label>
                    <input type="date" name="start_date" id="start_date" value="{{ old('start_date') }}" required>
                    @error('start_date') <div class="error">{{ $message }}</div> @enderror
                </div>
                <div class="form-group">
                    <label for="end_date">End date (optional)</label>
                    <input type="date" name="end_date" id="end_date" value="{{ old('end_date') }}">
                    @error('end_date') <div class="error">{{ $message }}</div> @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="documentation">Documentation (image or PDF, max 10 MB)</label>
                <input type="file" name="documentation" id="documentation" accept="image/jpeg,image/png,image/gif,image/webp,application/pdf">
                @error('documentation') <div class="error">{{ $message }}</div> @enderror
            </div>
            <div class="flex">
                <button type="submit" class="btn btn-primary"><i class="ri-save-line"></i> Save</button>
                <a href="{{ route('admin.experiences.index') }}" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
@endsection
