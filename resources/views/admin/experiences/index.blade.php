@extends('layouts.admin')

@section('title', 'Manage Experiences')

@section('styles')
    .container { max-width: 1000px; margin: 0 auto; padding: 2rem; }
    h1 { color: var(--color-title); margin-bottom: 1.5rem; }
    .btn { display: inline-flex; align-items: center; gap: .5rem; padding: .65rem 1rem; border-radius: .5rem; text-decoration: none; font-weight: 600; border: none; cursor: pointer; }
    .btn-primary { background: var(--color-first); color: var(--color-title); }
    .btn-danger { background: #dc3545; color: #fff; }
    .btn-edit { background: #ffc107; color: #000; }
    .alert { padding: 1rem; border-radius: .5rem; margin-bottom: 1.5rem; background: #198754; color: #fff; }
    .table-wrapper { border-radius: .5rem; overflow-x: auto; border: 1px solid var(--color-title); }
    table { width: 100%; border-collapse: collapse; background: var(--color-container); }
    th, td { padding: 1rem; text-align: left; }
    th { color: var(--color-title); font-weight: 600; background: #1a1c26; }
    td { color: var(--color-text); }
    .actions { display: flex; gap: .5rem; }
    form.inline { display: inline; }
@endsection

@section('content')
    <div class="container">
        <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:1.5rem;">
            <h1>Manage Experiences</h1>
            <a href="{{ route('admin.experiences.create') }}" class="btn btn-primary"><i class="ri-add-line"></i> New Experience</a>
        </div>

        @if (session('success'))
            <div class="alert">{{ session('success') }}</div>
        @endif

        <div class="table-wrapper">
            <table>
                <thead><tr><th>Category</th><th>Title</th><th>Organization</th><th>Dates</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse ($experiences as $experience)
                        <tr>
                            <td>{{ ucfirst($experience->category) }}</td>
                            <td>{{ $experience->title }}</td>
                            <td>{{ $experience->organization }}</td>
                            <td>{{ $experience->start_date->format('M Y') }} – {{ $experience->end_date?->format('M Y') ?? 'Present' }}</td>
                            <td class="actions">
                                <a href="{{ route('admin.experiences.edit', $experience) }}" class="btn btn-edit" aria-label="Edit experience"><i class="ri-edit-line"></i></a>
                                <form action="{{ route('admin.experiences.destroy', $experience) }}" method="POST" class="inline" onsubmit="return confirm('Delete this experience?')">
                                    @csrf
                                    @method('DELETE')
                                    <button type="submit" class="btn btn-danger" aria-label="Delete experience"><i class="ri-delete-bin-line"></i></button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="5" style="text-align:center;padding:2rem;color:#666;">No experiences yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
@endsection
