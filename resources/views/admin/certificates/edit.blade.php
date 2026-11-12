@extends('layouts.admin')

@section('title', 'Edit Certificate')

@section('styles')
    .container { max-width: 480px; margin: 0 auto; padding: 2rem; }
    h1 { color: var(--color-title); margin-bottom: 1.5rem; }
    .form-group { margin-bottom: 1.5rem; }
    label { display: block; margin-bottom: 0.5rem; color: var(--color-title); font-weight: 500; }
    input, textarea { width: 100%; padding: 0.75rem 1rem; border-radius: 0.5rem; background: #3a3d4a; color: var(--color-title); border: none; font-family: inherit; font-size: 0.938rem; }
    textarea { resize: vertical; min-height: 100px; }
    input[type=file] { background: transparent; padding-left: 0; }
    .btn { display: inline-flex; gap: 0.5rem; padding: 0.75rem 1.5rem; border-radius: 0.5rem; text-decoration: none; font-weight: 600; border: none; cursor: pointer; }
    .btn-primary { background: var(--color-first); color: var(--color-title); }
    .btn-secondary { background: #3a3d4a; color: var(--color-title); }
    .flex { display: flex; gap: 1rem; }
    .error { color: #dc3545; font-size: 0.813rem; margin-top: 0.25rem; }
@endsection

@section('content')
    <div class="container">
        <h1>Edit Certificate or Achievement</h1>
        <form action="{{ route('admin.certificates.update', $certificate) }}" method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')
            <div class="form-group"><label for="title">Title</label><input type="text" name="title" id="title" value="{{ old('title', $certificate->title) }}" required>@error('title')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="form-group"><label for="description">Description</label><textarea name="description" id="description">{{ old('description', $certificate->description) }}</textarea>@error('description')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="form-group"><label for="date">Date</label><input type="date" name="date" id="date" value="{{ old('date', $certificate->date?->format('Y-m-d')) }}">@error('date')<div class="error">{{ $message }}</div>@enderror</div>
            <div class="form-group"><label for="documentation">Documentation (image or PDF)</label><input type="file" name="documentation" id="documentation" accept="image/jpeg,image/png,image/gif,image/webp,application/pdf">
                @if ($certificate->documentation)<p>Current file: <a href="{{ Storage::url($certificate->documentation) }}" target="_blank" rel="noopener noreferrer">View documentation</a></p>@endif
                @error('documentation')<div class="error">{{ $message }}</div>@enderror
            </div>
            <div class="flex"><button type="submit" class="btn btn-primary">Update</button><a href="{{ route('admin.certificates.index') }}" class="btn btn-secondary">Cancel</a></div>
        </form>
    </div>
@endsection
